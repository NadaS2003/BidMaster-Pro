<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAuctionRequest;
use App\Models\Auction;
use App\Traits\FileUploadTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AuctionController extends Controller
{
    use FileUploadTrait;
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $query = Auction::Active();
        $this->applyFilters($query, $request);

        $auctions = $query->latest()->paginate(9)->withQueryString();

        return view('auctions.index', compact('auctions'));
    }

    public function create()
    {
        return view('auctions.create');
    }

    /**
     * Store a new auction using the validated StoreAuctionRequest.
     */
    public function store(StoreAuctionRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $validated['image_path'] = $this->uploadFile($request->file('image'), 'auctions');
        }

        $validated['user_id']       = auth()->id();
        $validated['current_price'] = $validated['starting_price'];

        // Status defaults based on start_time presence
        if (empty($validated['start_time'])) {
            $validated['status'] = 'active';
        } else {
            $validated['status'] = 'upcoming';
        }

        Auction::create($validated);

        return redirect()->route('home')->with('success', 'Auction created successfully!');
    }

    public function show(Auction $auction)
    {

        if ( Gate::denies('view', $auction)) {
            return redirect()->route('auctions.index')
                ->with('error', 'Sorry, this auction requires a higher account tier.');
        }

        $auction->load(['seller', 'bids.bidder']);

        return view('auctions.show', compact('auction'));
    }

    public function myAuctions(Request $request)
    {
        $auctions = $request->user()
            ->auctions()
            ->withCount('bids')
            ->latest()
            ->paginate(9);

        return view('auctions.my-auctions', compact('auctions'));
    }

    public function edit(Auction $auction)
    {
        $this->authorize('update', $auction);

        return view('auctions.edit', compact('auction'));
    }

    public function update(Request $request, Auction $auction)
    {
        $this->authorize('update', $auction);

        $validated = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'end_time'    => ['required', 'date', 'after:now'],
            'image'       => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:10240'],
        ]);

        if ($request->hasFile('image')) {
            if ($auction->image_path) {
                $this->deleteFile($auction->image_path);
            }
            $validated['image_path'] = $request->file('image')->store('auctions', 'public');
        }

        $auction->update($validated);

        return redirect()->route('auctions.show', $auction->id)
            ->with('success', 'Auction updated successfully!');
    }

    public function destroy(Auction $auction)
    {
        $this->authorize('delete', $auction);

        if ($auction->image_path) {
            $this->deleteFile($auction->image_path);
        }

        $auction->delete();

        return redirect()->route('auctions.my')
            ->with('success', 'Auction deleted successfully!');
    }

    public function upcoming(Request $request)
    {
        $query = Auction::Upcoming();
        $this->applyFilters($query, $request);

        $auctions = $query->orderBy('start_time', 'asc')->paginate(9)->withQueryString();

        return view('auctions.upcoming', compact('auctions'));
    }

    public function results(Request $request)
    {
        $query = Auction::Ended()
            ->withMax('bids as final_price', 'amount')
            ->withCount('bids');

        $this->applyFilters($query, $request);

        $auctions = $query->latest('end_time')->paginate(9)->withQueryString();

        return view('auctions.results', compact('auctions'));
    }

    private function applyFilters($query, Request $request): void
    {
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                    ->orWhere('description', 'like', "%{$searchTerm}%");
            });
        }
    }
}
