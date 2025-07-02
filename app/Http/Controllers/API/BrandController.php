<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Country;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\CreateBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use App\Http\Resources\BrandResource;
use App\Http\Controllers\Controller;

class BrandController extends Controller
{
    public function index(Request $request) {
        try {
            $countryCode = app('countryCode');
            $search = $request->query('search');

            $query = Brand::whereHas('countries', function ($query) use ($countryCode) {
                $query->where('code', $countryCode);
            });

            if ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            }

            $brands = $query->paginate();

            return response()->json([
                'message' => 'Brands retrieved successfully.',
                'data' => BrandResource::collection($brands)
            ], 200);

        } catch (\Exception $e) {
            Log::error('Error retrieving brands: ' . $e->getMessage());
            return response()->json([
                'message' => 'Failed to retrieve brands.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(CreateBrandRequest $request)
    {
        try {
            $brand = Brand::create($request->validated());

            if ($request->hasFile('image')) {
                $brand->addMediaFromRequest('image')->toMediaCollection(Brand::PATH);
            }

            if ($request->has('country_codes')) {
                $brand->countries()->attach($request->country_codes);
            }

            return response()->json([
                    'message' => 'Brand created successfully.',
                    'data' => new BrandResource($brand)
            ], 201);

        } catch (\Exception $e) {
            Log::error('Error creating brand: ' . $e->getMessage());
            return response()->json([
                    'message' => 'Failed to create brand.',
                    'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id) {
        try {
            $brand = Brand::findOrFail($id);
            return response()->json([
                'message' => 'Brand retrieved successfully.',
                'data' => new BrandResource($brand)
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error retrieving brand: ' . $e->getMessage());
            return response()->json([
                'message' => 'Brand not found.',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    public function update(UpdateBrandRequest $request, $id)
    {
        try {
            $brand = Brand::findOrFail($id);
            $brand->update($request->validated());

            if ($request->hasFile('image')) {
                $brand->clearMediaCollection(Brand::PATH);
                $brand->addMediaFromRequest('image')->toMediaCollection(Brand::PATH);
            }

            if ($request->has('country_codes')) {
                $brand->countries()->sync($request->country_codes);
            }

            return response()->json([
                    'message' => 'Brand updated successfully.',
                    'data' => new BrandResource($brand)
            ], 201);

        } catch (\Exception $e) {
            Log::error('Error updating brand: ' . $e->getMessage());
            return response()->json([
                    'message' => 'Failed to update brand.',
                    'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $brand = Brand::findOrFail($id);
            $brand->clearMediaCollection(Brand::PATH);
            $brand->countries()->detach();
            $brand->delete();

            return response()->json([
                'message' => 'Brand deleted successfully.'
            ], 200);

        } catch (\Exception $e) {
            Log::error('Error deleting brand: ' . $e->getMessage());
            return response()->json([
                'message' => 'Failed to delete brand.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
