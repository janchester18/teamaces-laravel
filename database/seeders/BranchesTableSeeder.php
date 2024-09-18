<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class BranchesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('branches')->insert([
            ['name' => 'TeamAces Driving Academy - Lipa',
            'address' => 'W5R2+W9H, President Jose P. Laurel Hwy, Lipa, 4217 Batangas',
            'latitude' => '13.942364',
            'longitude' => '121.151041'],
            ['name' => 'TeamAces Driving Academy - Lipa',
            'address' => 'W5R2+W9H, President Jose P. Laurel Hwy, Lipa, 4217 Batangas',
            'latitude' => '13.942364',
            'longitude' => '121.151041'],
            ['name' => 'TeamAces Driving Academy - Lipa',
            'address' => 'W5R2+W9H, President Jose P. Laurel Hwy, Lipa, 4217 Batangas',
            'latitude' => '13.942364',
            'longitude' => '121.151041'],
            ['name' => 'TeamAces Driving Academy - Lipa',
            'address' => 'W5R2+W9H, President Jose P. Laurel Hwy, Lipa, 4217 Batangas',
            'latitude' => '13.942364',
            'longitude' => '121.151041'],
            ['name' => 'TeamAces Driving Academy - Lipa',
            'address' => 'W5R2+W9H, President Jose P. Laurel Hwy, Lipa, 4217 Batangas',
            'latitude' => '13.942364',
            'longitude' => '121.151041'],
            ['name' => 'TeamAces Driving Academy - Lipa',
            'address' => 'W5R2+W9H, President Jose P. Laurel Hwy, Lipa, 4217 Batangas',
            'latitude' => '13.942364',
            'longitude' => '121.151041'],
            ['name' => 'TeamAces Driving Academy - Lipa',
            'address' => 'W5R2+W9H, President Jose P. Laurel Hwy, Lipa, 4217 Batangas',
            'latitude' => '13.942364',
            'longitude' => '121.151041'],
            // Add more branches
        ]);
    }
}
