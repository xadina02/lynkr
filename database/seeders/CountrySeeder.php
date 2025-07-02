<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Country;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countries = [
            // Africa
            ['code' => 'NG', 'name' => 'Nigeria'],
            ['code' => 'CM', 'name' => 'Cameroon'],
            ['code' => 'ZA', 'name' => 'South Africa'],
            ['code' => 'EG', 'name' => 'Egypt'],
            ['code' => 'KE', 'name' => 'Kenya'],

            // Europe
            ['code' => 'FR', 'name' => 'France'],
            ['code' => 'DE', 'name' => 'Germany'],
            ['code' => 'IT', 'name' => 'Italy'],
            ['code' => 'ES', 'name' => 'Spain'],
            ['code' => 'GB', 'name' => 'United Kingdom'],

            // Asia
            ['code' => 'CN', 'name' => 'China'],
            ['code' => 'JP', 'name' => 'Japan'],
            ['code' => 'IN', 'name' => 'India'],
            ['code' => 'KR', 'name' => 'South Korea'],
            ['code' => 'SA', 'name' => 'Saudi Arabia'],

            // North America
            ['code' => 'US', 'name' => 'United States'],
            ['code' => 'CA', 'name' => 'Canada'],
            ['code' => 'MX', 'name' => 'Mexico'],
            ['code' => 'CU', 'name' => 'Cuba'],
            ['code' => 'GT', 'name' => 'Guatemala'],

            // South America
            ['code' => 'BR', 'name' => 'Brazil'],
            ['code' => 'AR', 'name' => 'Argentina'],
            ['code' => 'CO', 'name' => 'Colombia'],
            ['code' => 'CL', 'name' => 'Chile'],
            ['code' => 'PE', 'name' => 'Peru'],

            // Oceania
            ['code' => 'AU', 'name' => 'Australia'],
            ['code' => 'NZ', 'name' => 'New Zealand'],
            ['code' => 'FJ', 'name' => 'Fiji'],
            ['code' => 'PG', 'name' => 'Papua New Guinea'],
            ['code' => 'WS', 'name' => 'Samoa'],

            // Default Country
            ['code' => 'ZZ', 'name' => 'Default'],
        ];

        foreach ($countries as $country) {
            Country::updateOrCreate(
                ['code' => $country['code']],
                ['name' => $country['name']]
            );
        }
    }
}
