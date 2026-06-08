<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Http\JsonResponse;

class PublicScheduleController extends Controller
{
    public function index(int $facilityId): JsonResponse
    {
        $schedules = Schedule::where('facility_id', $facilityId)
            ->orderBy('id')
            ->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Jadwal fasilitas berhasil diambil.',
            'data' => $schedules
        ], 200);
    }
}