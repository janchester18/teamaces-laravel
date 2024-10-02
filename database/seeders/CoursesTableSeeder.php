<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CoursesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('courses')->insert([
            [
                'name' => 'Theoretical Driving Course',
                'description' => 'A comprehensive course covering the essential knowledge for safe driving, including traffic rules and regulations.',
                'number_of_sessions' => 2,
                'hours_per_session' => 8,
                'price' => 1000,
                'acronym' => 'TDC',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Online Theoretical Driving Course',
                'description' => 'An online version of the theoretical driving course that can be taken remotely.',
                'number_of_sessions' => 2,
                'hours_per_session' => 8,
                'price' => 2000,
                'acronym' => 'OTDC',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Practical Driving Course',
                'description' => 'A hands-on driving course focusing on practical driving skills.',
                'number_of_sessions' => 10, // Assuming more sessions for practical
                'hours_per_session' => 4,
                'price' => 4000,
                'acronym' => 'PDC',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Motorcycle Practical Driving Course',
                'description' => 'A practical course focused on motorcycle riding skills and safety.',
                'number_of_sessions' => 6,
                'hours_per_session' => 4,
                'price' => 2500,
                'acronym' => 'MPDC',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
