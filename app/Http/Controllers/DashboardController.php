<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use App\Models\StudentCourse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\Student; // Import the Student model
use App\Models\Schedule; // Import the Schedule model
use Carbon\Carbon; // Import Carbon for date handling
use Illuminate\Support\Facades\DB; // Import DB facade
use App\Models\Transaction; // Import the Transaction model

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Get the branch ID of the authenticated user
        $branchId = auth()->user()->branch_id;

        // Determine the year to filter by (default to the current year)
        $yearFilter = $request->get('year', Carbon::now()->year);

        // Count the number of students in the students table for the current user's branch
        $totalStudents = Student::where('branch_id', $branchId)->count();

        // Get today's date
        $today = Carbon::today();

        // Count how many students have scheduled sessions today in the schedules table
        $scheduledSessionsToday = Schedule::where('branch_id', $branchId)
            ->whereDate('scheduled_date', $today)
            ->count();

        // Sum the revenue from the transactions table for the current user's branch
        $totalRevenue = Transaction::where('branch_id', $branchId)->sum('price');

        // Fetch revenue per month for the selected year
        $monthlyRevenue = Transaction::select(DB::raw('SUM(price) as total_revenue'), DB::raw('MONTH(created_at) as month'))
        ->where('branch_id', $branchId)
        ->whereYear('created_at', $yearFilter)
        ->groupBy('month')
        ->orderBy('month')
        ->pluck('total_revenue', 'month');

        // Prepare data for the chart
        $months = range(1, 12); // Months from January to December
        $revenueData = [];

        foreach ($months as $month) {
            // If there's no revenue for a month, default to 0
            $revenueData[$month] = $monthlyRevenue->get($month, 0);
        }

        $revenueMonths = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

        // Pending New Enrollments
        $newEnrollments = Enrollment::where('branch_id', $branchId)
            ->where('is_email_verified', 1)
            ->count();

        // Existing Student Enrollments (not approved)
        $existingStudentsEnrollments = StudentCourse::with('student', 'course') // Assuming you have relationships defined
            ->where('is_approved', 0)
            ->count();


        return view('admin.branch_analytics', compact(
            'totalStudents',
            'scheduledSessionsToday',
            'totalRevenue',
            'revenueData',
            'revenueMonths',
            'newEnrollments',
            'existingStudentsEnrollments',
            'yearFilter'
        ));
    }

    public function getRevenueInsights(Request $request)
    {
        $yearFilter = $request->input('year', Carbon::now()->year); // Default to current year if not passed
        \Log::debug('Year received in controller: ' . $yearFilter); // Debugging line

        // Fetch the transactions and group by month, using the year filter
        $transactions = Transaction::where('branch_id', Auth::user()->branch_id)
            ->whereYear('created_at', $yearFilter) // Filter transactions by the selected year
            ->selectRaw('SUM(price) as total, MONTH(created_at) as month')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Prepare data for insights
        $labels = $transactions->pluck('month')->map(fn($month) => date('F', mktime(0, 0, 0, $month, 1)))->toArray();
        $data = $transactions->pluck('total')->toArray();

        // Format data for the prompt
        $formattedData = array_map(function ($label, $value) {
            return "$label - $value";
        }, $labels, $data);

        $formattedDataString = implode(', ', $formattedData);

        // Craft the prompt
        $prompt = "Here is the revenue data per month for the bar chart sales per month: $formattedDataString. Generate a 3-sentence business insights based on this graph. Don't include an introductory sentence. The business is a driving school named TeamAces Driving Academy. Don't include holidays and seasons. And provide suggestions. Again, don't include an introductory sentence or colon. The currency is Philippine pesos or pesos.";

        // Set up the Arli AI API request
        $client = new \GuzzleHttp\Client();
        $url = 'https://api.arliai.com/v1/chat/completions';
        $apiKey = env('API_KEY_ARLI'); // Ensure your API key is set in the .env file

        try {
            $response = $client->post($url, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => "Bearer $apiKey"
                ],
                'json' => [
                    'model' => 'Meta-Llama-3.1-8B-Instruct', // Use the Arli AI model
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

            // Log formatted data string for debugging
            Log::info('Formatted Data String:', [$formattedDataString]);

            return response()->json(['insights' => $insights]);

        } catch (\Exception $e) {
            Log::error('API Request Failed: ' . $e->getMessage());
            return response()->json(['insights' => 'Error generating insights.'], 500);
        }
    }



}
