<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CoursePackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Seeding data for the `course_package` table
        DB::table('course_package')->insert([
            // Package 1: TDC Face to Face + PDC Motorcycle
            ['course_id' => 1, 'package_id' => 1], // Theoretical Driving Course
            ['course_id' => 3, 'package_id' => 1], // Practical Driving Course

            // Package 2: Online TDC + PDC Motorcycle
            ['course_id' => 2, 'package_id' => 2], // Online Theoretical Driving Course
            ['course_id' => 4, 'package_id' => 2], // Motorcycle Practical Driving Course

            // Package 3: TDC Face to Face + PDC 4 Wheels
            ['course_id' => 1, 'package_id' => 3], // Theoretical Driving Course
            ['course_id' => 3, 'package_id' => 3], // Practical Driving Course

            // Package 4: Online TDC + PDC 4 Wheels
            ['course_id' => 2, 'package_id' => 4], // Online Theoretical Driving Course
            ['course_id' => 3, 'package_id' => 4], // Practical Driving Course

            // Package 5: TDC Face to Face + PDC Motorcycle + 4 Wheels
            ['course_id' => 1, 'package_id' => 5], // Theoretical Driving Course
            ['course_id' => 3, 'package_id' => 5], // Practical Driving Course
            ['course_id' => 4, 'package_id' => 5], // Motorcycle Practical Driving Course

            // Package 6: Online TDC + PDC Motorcycle + 4 Wheels
            ['course_id' => 2, 'package_id' => 6], // Online Theoretical Driving Course
            ['course_id' => 3, 'package_id' => 6], // Practical Driving Course
            ['course_id' => 4, 'package_id' => 6], // Motorcycle Practical Driving Course

            // Package 7: PDC Motorcycle + PDC 4 Wheels
            ['course_id' => 3, 'package_id' => 7], // Practical Driving Course
            ['course_id' => 4, 'package_id' => 7], // Motorcycle Practical Driving Course
        ]);
    }
}
