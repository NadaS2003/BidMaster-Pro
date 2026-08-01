<?php

namespace App\Http\Requests;

use App\Enums\UserTier;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

/**
 * @OA\Schema(
 *   schema="StoreAuctionRequest",
 *   required={"title", "description", "starting_price", "end_time"},
 *   @OA\Property(property="title",          type="string",  maxLength=255,  example="Vintage Watch"),
 *   @OA\Property(property="description",    type="string",  example="A rare 1960s Swiss timepiece."),
 *   @OA\Property(property="starting_price", type="number",  format="float", example=100.00),
 *   @OA\Property(property="end_time",       type="string",  format="date-time", example="2026-08-01T18:00:00Z"),
 *   @OA\Property(property="start_time",     type="string",  format="date-time", nullable=true),
 *   @OA\Property(property="minimum_tier",   type="string",  enum={"standard","gold","vip"}, example="standard"),
 *   @OA\Property(property="image",          type="string",  format="binary", nullable=true)
 * )
 */
class StoreAuctionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'          => ['required', 'string', 'max:255'],
            'description'    => ['required', 'string'],
            'starting_price' => ['required', 'numeric', 'min:0'],
            'end_time' => 'required|date|after:now',
            'start_time'     => ['nullable', 'date', 'before:end_time'],
            'minimum_tier'   => ['nullable', new Enum(UserTier::class)],
            'image'          => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:51200'],
        ];
    }

    public function messages(): array
    {
        return [
            'end_time.after'        => 'The auction end time must be in the future.',
            'start_time.before'     => 'The start time must be before the end time.',
            'starting_price.min'    => 'The starting price cannot be negative.',
            'minimum_tier.Illuminate\Validation\Rules\Enum' => 'Invalid tier. Must be one of: standard, gold, vip.',
        ];
    }
}
