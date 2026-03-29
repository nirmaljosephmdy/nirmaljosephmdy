<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ArAddress;
use App\Enums\ArRegion;

class ArAddressSeeder extends Seeder
{
    public function run(): void
    {
        ArAddress::firstOrCreate(['name' => 'EU Representative (Ireland)'], [
            'region' => ArRegion::EU,
            'address_line_1' => '123 Dublin Road',
            'city' => 'Dublin',
            'postcode' => 'D01 XYZ',
            'country' => 'Ireland',
            'contact_email' => 'eu@euverify-ar.com',
            'is_active' => true,
        ]);

        ArAddress::firstOrCreate(['name' => 'UK Representative (England)'], [
            'region' => ArRegion::UK,
            'address_line_1' => '456 London Road',
            'city' => 'London',
            'postcode' => 'SW1A 1AA',
            'country' => 'United Kingdom',
            'contact_email' => 'uk@euverify-ar.com',
            'is_active' => true,
        ]);
    }
}
