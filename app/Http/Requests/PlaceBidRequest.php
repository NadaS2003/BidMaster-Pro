<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *   schema="PlaceBidRequest",
 *   required={"amount"},
 *   @OA\Property(
 *     property="amount",
 *     type="number",
 *     format="float",
 *     example=150.00,
 *     description="Bid amount — must be a positive number. Must exceed the current auction price (enforced post-lock in BidService)."
 *   )
 * )
 */
class PlaceBidRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * Authorization (policy check) is handled in the controller via authorize().
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation rules.
     *
     * Note: The "must be higher than current price" rule is intentionally
     * NOT placed here. That check is done inside BidService::placeBid()
     * AFTER acquiring the pessimistic lock, preventing TOCTOU race conditions
     * where the current price changes between validation and DB write.
     */
    public function rules(): array
    {
        return [
            'amount' => ['required', 'numeric', 'min:0.01'],
        ];
    }

    public function messages(): array
    {
        return [
            'amount.required' => 'A bid amount is required.',
            'amount.numeric'  => 'The bid amount must be a valid number.',
            'amount.min'      => 'The bid amount must be greater than zero.',
        ];
    }
}
