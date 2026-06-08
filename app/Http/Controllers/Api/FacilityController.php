<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFacilityRequest;
use App\Http\Requests\UpdateFacilityRequest;
use App\Http\Resources\FacilityResource;
use App\Services\FacilityService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;

class FacilityController extends Controller
{
    protected FacilityService $facilityService;

    public function __construct(FacilityService $facilityService)
    {
        $this->facilityService = $facilityService;
    }

    
    public function index(Request $request): JsonResponse
    {
        $search = $request->query('search', '');
        $category = $request->query('category', '');
        
        $facilities = $this->facilityService->getSellerFacilities(
            auth()->id(),
            $search,
            $category,
            $request->query('per_page', 8)
        );

        return response()->json([
            'status' => 'success',
            'message' => 'Daftar fasilitas berhasil diambil.',
            'data' => FacilityResource::collection($facilities),
            'meta' => [
                'current_page' => $facilities->currentPage(),
                'last_page' => $facilities->lastPage(),
                'per_page' => $facilities->perPage(),
                'total' => $facilities->total(),
            ]
        ], 200);
    }

    public function store(StoreFacilityRequest $request): JsonResponse
    {
        $facility = $this->facilityService->storeFacility($request->validated(), auth()->id());

        return response()->json([
            'status' => 'success',
            'message' => 'Fasilitas berhasil ditambahkan.',
            'data' => new FacilityResource($facility)
        ], 201);
    }

    public function show(int $id): JsonResponse
    {
        try {
            $facility = $this->facilityService->getFacilityDetail($id, auth()->id());
            return response()->json([
                'status' => 'success',
                'message' => 'Detail fasilitas berhasil diambil.',
                'data' => new FacilityResource($facility)
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 404);
        } catch (UnauthorizedException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 403);
        }
    }

    public function update(UpdateFacilityRequest $request, int $id): JsonResponse
    {
        try {
            $facility = $this->facilityService->updateFacility($id, $request->validated(), auth()->id());
            return response()->json([
                'status' => 'success',
                'message' => 'Fasilitas berhasil diperbarui.',
                'data' => new FacilityResource($facility)
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 404);
        } catch (UnauthorizedException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 403);
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $this->facilityService->destroyFacility($id, auth()->id());
            return response()->json([
                'status' => 'success',
                'message' => 'Fasilitas berhasil dihapus.'
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 404);
        } catch (UnauthorizedException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 403);
        }
    }
}