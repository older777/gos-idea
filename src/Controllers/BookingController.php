<?php

namespace Older777\GosIdea\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Older777\GosIdea\Models\Guide;
use Older777\GosIdea\Models\HuntingBooking;
use Older777\GosIdea\Requests\HuntingBookingRequest;
use Throwable;

/**
 * @author older777
 */
class BookingController
{
    /**
     * Список гидов
     */
    public function guides(HuntingBookingRequest $request): JsonResponse
    {
        $data = null;

        if ($request->exists('min_experience')) {
            $data = Guide::where('is_active', true)
                ->where('experience_years', '>=', $request->min_experience)
                ->get();
        } else {
            $data = Guide::where('is_active', true)->get();
        }

        return response()->json([
            'success' => true,
            'data' => $data,
        ], Response::HTTP_OK, [], JSON_UNESCAPED_UNICODE);
    }

    /**
     * Забронировать гида
     */
    public function bookings(HuntingBookingRequest $request): JsonResponse
    {
        try {
            $huntingBooking = HuntingBooking::where('guide_id', $request->guide_id)
                ->whereRaw('DATE(date) = DATE(?)', $request->date);

            if ($huntingBooking->count()) {
                throw new Exception('На данную дату гид занят! Выберите другую дату');
            }

            HuntingBooking::create($request->validated());
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->getMessage(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY, [], JSON_UNESCAPED_UNICODE);
        }

        return response()->json([
            'success' => true,
            'message' => 'Гид забронирован',
        ], Response::HTTP_OK, [], JSON_UNESCAPED_UNICODE);
    }
}
