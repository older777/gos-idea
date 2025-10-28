<?php

namespace Older777\GosIdea\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class HuntingBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(Request $request): array
    {
        if ($request->routeIs('guides')) {
            return [
                'min_experience' => 'integer|max:100',
            ];
        } elseif ($request->routeIs('bookings')) {
            return [
                'tour_name' => 'required|string',
                'hunter_name' => 'required|string',
                'guide_id' => 'required|exists:guides,id',
                'date' => 'required|date',
                'participants_count' => 'required|integer|max:10',
            ];
        }

        return [];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Ошибка валидации!',
            'errors' => $validator->errors(),
        ], 422));
    }
}
