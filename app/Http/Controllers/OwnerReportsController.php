<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\StudentCourse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class OwnerReportsController extends Controller
{
    public function getStudentDemographics()
    {
        // Get the current date
        $currentDate = Carbon::now();

        // Define age groups
        $ageGroups = [
            '0-17' => 0,
            '18-24' => 0,
            '25-34' => 0,
            '35-44' => 0,
            '45-54' => 0,
            '55+' => 0,
        ];

        // Fetch all students (removed branch filtering)
        $students = Student::all();

        // Calculate age and group them
        foreach ($students as $student) {
            $age = $currentDate->diffInYears(Carbon::parse($student->dob));

            if ($age <= 17) {
                $ageGroups['0-17']++;
            } elseif ($age <= 24) {
                $ageGroups['18-24']++;
            } elseif ($age <= 34) {
                $ageGroups['25-34']++;
            } elseif ($age <= 44) {
                $ageGroups['35-44']++;
            } elseif ($age <= 54) {
                $ageGroups['45-54']++;
            } else {
                $ageGroups['55+']++;
            }
        }

        // Fetch popular courses
        $popularCourses = DB::table('student_courses')
            ->join('courses', 'student_courses.course_id', '=', 'courses.id') // Join with the courses table
            ->select('courses.name as course_name', DB::raw('count(*) as total'))
            ->groupBy('courses.name') // Group by course name instead of course ID
            ->orderBy('total', 'desc')
            ->take(5) // Adjust the number of courses displayed as needed
            ->get();

        return view('owner.owner-reports', compact('ageGroups', 'popularCourses'));
    }

    public function generateInsights(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'demographics' => 'required|array',
            'demographics.*' => 'integer|min:0', // Each demographic entry should be a non-negative integer
        ]);

        // Extract demographics data from the request
        $demographics = $request->input('demographics');

        // Prepare data for the API call
        $labels = array_keys($demographics);
        $data = array_values($demographics);

        $formattedData = array_map(function ($label, $value) {
            return "$label - $value";
        }, $labels, $data);

        $formattedDataString = implode(', ', $formattedData);

        // Create the prompt for the API
        $prompt = "Here is the student demographics data: $formattedDataString. Generate a 3-sentence business insights based on this data. Don't include an introductory sentence. The business is a driving school named TeamAces Driving Academy. Focus on marketing strategies that could be beneficial based on the demographics.";

        // Call the API to generate insights
        $client = new Client();
        $url = 'https://api.arliai.com/v1/chat/completions';
        $apiKey = env('API_KEY_ARLI'); // Ensure your API key is set in the .env file

        try {
            $response = $client->post($url, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => "Bearer $apiKey"
                ],
                'json' => [
                    'model' => 'Meta-Llama-3.1-8B-Instruct',
                    'messages' => [
                        ['role' => 'system', 'content' => 'You are a helpful business analyst.'],
                        ['role' => 'user', 'content' => $prompt]
                    ],
                    'max_tokens' => 1024,
                    'temperature' => 0.7
                ]
            ]);

            $body = json_decode($response->getBody()->getContents(), true);
            $insights = $body['choices'][0]['message']['content'] ?? 'No insights generated.';

            return response()->json(['insights' => $insights]);

        } catch (\Exception $e) {
            Log::error('API Request Failed: ' . $e->getMessage());
            return response()->json(['insights' => 'Error generating insights.'], 500);
        }
    }

    public function generateCourseInsights(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'popularCourses' => 'required|array',
            'popularCourses.*.course_name' => 'required|string', // Ensure course name is a string
            'popularCourses.*.total' => 'required|integer|min:0', // Ensure total is a non-negative integer
        ]);

        // Extract popular courses data from the request
        $popularCourses = $request->input('popularCourses');

        // Prepare data for the API call
        $labels = array_map(function ($course) {
            return $course['course_name']; // Use course name as label
        }, $popularCourses);

        $data = array_map(function ($course) {
            return $course['total']; // Use total as data
        }, $popularCourses);

        // Create formatted data for logging
        $formattedData = array_map(function ($label, $value) {
            return "$label - $value";
        }, $labels, $data);

        $formattedDataString = implode(', ', $formattedData);

        // Log the formatted data string
        Log::info('Formatted Data String for API Prompt:', ['formatted_data' => $formattedDataString]);

        // Create the prompt for the API
        $prompt = "Here is the popular courses data: $formattedDataString. Generate a 3-sentence business insights based on this data. This data is the number of students per course and it is a pie chart, dont use percentages only use exact values if you want to mention it, you may choose not to. Don't include an introductory sentence. The business is a driving school named TeamAces Driving Academy. Focus on marketing strategies that could be beneficial based on the demographics.";

        // Call the API to generate insights
        $client = new Client();
        $url = 'https://api.arliai.com/v1/chat/completions';
        $apiKey = env('API_KEY_ARLI'); // Ensure your API key is set in the .env file

        try {
            $response = $client->post($url, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => "Bearer $apiKey"
                ],
                'json' => [
                    'model' => 'Meta-Llama-3.1-8B-Instruct',
                    'messages' => [
                        ['role' => 'system', 'content' => 'You are a helpful business analyst.'],
                        ['role' => 'user', 'content' => $prompt]
                    ],
                    'max_tokens' => 1024,
                    'temperature' => 0.7
                ]
            ]);

            $body = json_decode($response->getBody()->getContents(), true);
            $insights = $body['choices'][0]['message']['content'] ?? 'No insights generated.';

            return response()->json(['insights' => $insights]);

        } catch (\Exception $e) {
            Log::error('API Request Failed: ' . $e->getMessage());
            return response()->json(['insights' => 'Error generating insights.'], 500);
        }
    }

    public function getBranchTransactions(Request $request)
{
    $user = auth()->user(); // Get the current logged-in user

    // Prepare the query
    $query = DB::table('transactions')
        ->join('students', 'transactions.student_id', '=', 'students.id') // Join with students table
        ->join('users', 'transactions.staff_id', '=', 'users.id') // Join with users table to get staff names
        ->join('branches', 'transactions.branch_id', '=', 'branches.id') // Join with branches table
        ->leftJoin('courses', 'transactions.course_id', '=', 'courses.id') // Left join with courses table
        ->leftJoin('packages', 'transactions.package_id', '=', 'packages.id') // Left join with packages table
        ->select(
            'transactions.student_id',
            DB::raw("CONCAT(students.first_name, ' ', students.last_name) as student_name"), // Concatenate first and last name
            DB::raw("COALESCE(courses.name, packages.name) as course_package"), // Use COALESCE to get either course name or package name
            'transactions.price',
            'transactions.balance', // Select balance directly from the transactions table
            'transactions.payment_method', // Select balance directly from the transactions table
            'users.name as processed_by', // Select the staff name directly
            'branches.name as branch_name', // Select the branch name
            'transactions.created_at'
        )
        ->orderBy('transactions.created_at', 'desc'); // Sort by created_at date, latest first

    // Apply date filter if provided
    if ($request->has('start_date') && $request->has('end_date') &&
        !empty($request->input('start_date')) && !empty($request->input('end_date'))) {
        $query->whereBetween('transactions.created_at', [
            $request->input('start_date'),
            $request->input('end_date')
        ]);
    }

    $transactions = $query->get();

    // Return JSON response
    return response()->json($transactions);
}
}

