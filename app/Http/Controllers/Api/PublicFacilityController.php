<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use App\Http\Resources\FacilityResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PublicFacilityController extends Controller
{
    /**
     * Etalase Publik: Menampilkan semua fasilitas olahraga (dengan pagination)
     */
    public function index(Request $request): JsonResponse
    {
        // Menggunakan eager loading (with 'seller') agar efisien
        $facilities = Facility::with('seller')->latest()->paginate(10);

        return response()->json([
            'status' => 'success',
            'message' => 'Katalog fasilitas berhasil diambil.',
            // Kita bungkus menggunakan Resource agar format JSON-nya konsisten
            'data' => FacilityResource::collection($facilities),
            'meta' => [
                'current_page' => $facilities->currentPage(),
                'last_page' => $facilities->lastPage(),
                'per_page' => $facilities->perPage(),
                'total' => $facilities->total(),
            ]
        ], 200);
    }

    /**
     * Detail Publik: Menampilkan satu fasilitas beserta relasi yang dibutuhkan Buyer
     */
    public function show(int $id): JsonResponse
    {
        try {
            // Tarik data beserta jadwal (schedules) dan ulasan (reviews) jika ada
            $facility = Facility::with(['seller', 'schedules', 'reviews'])->findOrFail($id);

            return response()->json([
                'status' => 'success',
                'message' => 'Detail fasilitas berhasil diambil.',
                'data' => new FacilityResource($facility)
            ], 200);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Fasilitas tidak ditemukan.'
            ], 404);
        }
    }
}