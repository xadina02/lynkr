<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Brand;
use App\Models\Country;
use Illuminate\Support\Facades\Log;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = Brand::factory()->count(30)->create();

        $countries = Country::all();

        if ($countries->isEmpty()) {
            Log::warning('No countries were found to attach to brands [seeding...]: ');
            return;
        }

        foreach ($brands as $brand) {
            try {
                $imageUrl = 'https://img-cdn.inc.com/image/upload/f_webp,c_fit,w_1920,q_auto/images/panoramic/brand-ecko-970_30294.jpg';
                $brand->addMediaFromUrl($imageUrl)
                    ->toMediaCollection(Brand::PATH);
            } catch (\Exception $e) {
                Log::error('Failed to save brand image: ' . $e->getMessage());
            }

            try {
                $randomCountries = $countries->random(rand(1, min(3, $countries->count())));
                $brand->countries()->attach($randomCountries->pluck('code'));
            } catch (\Exception $e) {
                Log::error('Failed to attach countries to brand: ' . $e->getMessage());
            }
        }
    }
}
