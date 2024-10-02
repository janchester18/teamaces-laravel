<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Package;

class PackagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Define an array of package data
        $packages = [
            [
                'name' => 'TDC Face to Face + PDC Motorcycle',
                'price' => 1998.00,
                'is_active' => 1,
            ],
            [
                'name' => 'Online TDC + PDC Motorcycle',
                'price' => 3498.00,
                'is_active' => 1,
            ],
            [
                'name' => 'TDC Face to Face + PDC 4 Wheels',
                'price' => 4498.00,
                'is_active' => 0,
            ],
            [
                'name' => 'Online TDC + PDC 4 Wheels',
                'price' => 5998.00,
                'is_active' => 1,
            ],
            [
                'name' => 'TDC Face to Face + PDC Motorcycle + 4 Wheels',
                'price' => 5997.00,
                'is_active' => 1,
            ],
            [
                'name' => 'Online TDC + PDC Motorcycle + 4 Wheels',
                'price' => 7497.00,
                'is_active' => 0,
            ],
            [
                'name' => 'PDC Motorcycle + PDC 4 Wheels',
                'price' => 5498.00,
                'is_active' => 1,
            ],
        ];

        // Insert package data into the database
        foreach ($packages as $package) {
            Package::create($package);
        }
    }
}
