<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreScheduleRequest;
use App\Http\Requests\UpdateScheduleRequest;
use App\Http\Resources\ScheduleResource;
use App\Services\ScheduleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ScheduleController extends Controller
{
    protected ScheduleService $scheduleService;

    public function __construct(ScheduleService $scheduleService)
    {
        $this->scheduleService = $scheduleService;
    }

    public function index(int $facilityId): JsonResponse
    {
        try {
            // Service akan memvalidasi apakah fasilitas ini milik seller yang sedang login
            $schedules = $this->scheduleService->getFacilitySchedules($facilityId, auth()->id());

            return response()->json([
                'status' => 'success',
                'message' => 'Daftar jadwal fasilitas berhasil diambil.',
                'data' => ScheduleResource::collection($schedules),
                'meta' => [
                    'current_page' => $schedules->currentPage(),
                    'last_page' => $schedules->lastPage(),
                    'per_page' => $schedules->perPage(),
                    'total' => $schedules->total(),
                ]
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 404);
        } catch (AuthorizationException $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 403);
        }
    }

    public function store(StoreScheduleRequest $request): JsonResponse
    {
        try {
            $schedule = $this->scheduleService->createSchedule($request->validated(), auth()->id());
            
            return response()->json([
                'status' => 'success',
                'message' => 'Jadwal operasional berhasil ditambahkan.',
                'data' => new ScheduleResource($schedule)
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal.',
                'errors' => $e->errors()
            ], 422);
        }
    }

    public function update(UpdateScheduleRequest $request, int $id): JsonResponse
    {
        try {
            $schedule = $this->scheduleService->updateSchedule($id, $request->validated(), auth()->id());
            
            return response()->json([
                'status' => 'success',
                'message' => 'Jadwal operasional berhasil diperbarui.',
                'data' => new ScheduleResource($schedule)
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 404);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal.',
                'errors' => $e->errors()
            ], 422);
        } catch (AuthorizationException $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 403);
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $this->scheduleService->deleteSchedule($id, auth()->id());
            
            return response()->json([
                'status' => 'success',
                'message' => 'Jadwal operasional berhasil dihapus.'
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 404);
        } catch (AuthorizationException $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 403);
        }
    }
}