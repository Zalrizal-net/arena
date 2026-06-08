<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ShopService;
use Illuminate\Http\Request;
use App\Http\Resources\ShopResource;
use App\Http\Resources\FacilityResource; 

class ShopController extends Controller
{
    public function __construct(
        private ShopService $shopService
    ) {}

    /**
     * GET /api/shops
     * Mengambil daftar semua toko
     */
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 10);
        $shops = $this->shopService->getAllShops($perPage);
        
        return ShopResource::collection($shops);
    }

    /**
     * GET /api/shops/{slug}
     * Mengambil detail profil 1 toko beserta statistiknya (Rating, Total Fasilitas)
     */
    public function show($slug)
    {
        try {
            $data = $this->shopService->getShopDetailsBySlug($slug);
            
            return response()->json([
                'status'  => 'success',
                'profile' => new ShopResource($data['profile']),
                'stats'   => $data['stats']
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Toko tidak ditemukan.'
            ], 404);
        }
    }

    /**
     * GET /api/shops/{slug}/facilities
     * Mengambil katalog fasilitas milik 1 toko dengan fitur Filter (Search & Sort)
     */
    public function facilities($slug, Request $request)
    {
        try {
            // 1. Ambil data toko untuk mendapatkan seller_id (user_id)
            $shopData = $this->shopService->getShopDetailsBySlug($slug);
            $sellerId = $shopData['profile']->user_id;

            // 2. Siapkan filter dari query parameter URL (?search=...&sort=...)
            $filters = [
                'search' => $request->query('search', ''),
                'sort'   => $request->query('sort', 'newest'), // newest, lowest_price, highest_price
            ];

            // 3. Ambil data fasilitas via Service
            $perPage = $request->query('per_page', 12);
            $facilities = $this->shopService->getShopFacilities($sellerId, $filters, $perPage);

            // Return dengan FacilityResource jika ada, atau return langsung paginate json bawaan Laravel
            // return FacilityResource::collection($facilities);
            return response()->json($facilities);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Katalog toko tidak dapat dimuat.'
            ], 404);
        }
    }
}