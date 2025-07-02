<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use App\Http\Resources\CountryResource;
use App\Http\Requests\CreateCountryRequest;
use App\Http\Requests\UpdateCountryRequest;
use Illuminate\Support\Facades\Log;

class CountryController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Country::query();

            if ($request->has('filter')) {
                $filter = $request->input('filter');
                if (isset($filter['name'])) {
                    $query->where('name', 'like', '%' . $filter['name'] . '%');
                }
            }

            $countries = CountryResource::collection($query->get()->paginate());

            return response()->json(['message' => 'Countries retrieved successfully', 'data' => $countries], 201);
        } catch (\Exception $e) {
            Log::error('Error retrieving countries: ' . $e->getMessage());
            return response()->json([
                'message' => 'Failed to retrieve countries.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(CreateCountryRequest $request)
    {
        try {
            $country = Country::create($request->validated());

            return response()->json([
                'message' => 'Country created successfully.',
                'data' => new CountryResource($country)
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error creating country: ' . $e->getMessage());
            return response()->json([
                'message' => 'Failed to create country.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(UpdateCountryRequest $request, $code)
    {
        try {
            $country = Country::where('code', $code)->firstOrFail();
            $country->update($request->validated());

            return response()->json([
                'message' => 'Country updated successfully.',
                'data' => new CountryResource($country)
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error updating country: ' . $e->getMessage());
            return response()->json([
                'message' => 'Failed to update country.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($code)
    {
        try {
            $country = Country::firstOrFail($code);
            $country->brands()->detach();
            $country->delete();

            return response()->json(['message' => 'Country deleted successfully.'], 200);
        } catch (\Exception $e) {
            Log::error('Error deleting country: ' . $e->getMessage());
            return response()->json([
                'message' => 'Failed to delete country.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
