<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\Student; // Import the Student model
use App\Models\Schedule; // Import the Schedule model
use Carbon\Carbon; // Import Carbon for date handling
use Illuminate\Support\Facades\DB; // Import DB facade
use App\Models\Transaction; // Import the Transaction model

class DashboardController extends Controller
{
    public function index()
    {
        // Get the branch ID of the authenticated user
        $branchId = auth()->user()->branch_id;

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

       // Fetch revenue per month from the transactions table for the current user's branch
       $monthlyRevenue = Transaction::select(DB::raw('SUM(price) as total_revenue'), DB::raw('MONTH(created_at) as month'))
       ->where('branch_id', $branchId)
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

        // Map revenue data for each month
        $revenueData = array_map(function ($month) use ($monthlyRevenue) {
            return $monthlyRevenue->get($month, 0);
        }, range(1, 12));

        return view('admin.branch_analytics', compact('totalStudents', 'scheduledSessionsToday', 'totalRevenue', 'revenueData', 'revenueMonths')); // Pass revenue data to the view
    }

    public function getRevenueInsights()
{
    // Fetch the transactions and group by month
    $transactions = Transaction::where('branch_id', Auth::user()->branch_id)
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

    // Set up the Mistral API request
    $client = new \GuzzleHttp\Client();
    $url = 'https://api.mistralai.com/v1/chat/completions';
    $apiKey = env('MISTRAL_API_KEY'); // Ensure your API key is set in the .env file

    try {
        $response = $client->post($url, [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => "Bearer $apiKey"
            ],
            'json' => [
                'model' => 'mistral-large-latest', // Use the specified model
                'messages' => [
                    ['role' => 'system', 'content' => 'You are a helpful and accurate business analyst.'],
                    ['role' => 'staff', 'content' => $prompt]
                ]
            ]
        ]);

        $body = json_decode($response->getBody()->getContents(), true);
        $insights = $body['choices'][0]['message']['content'] ?? 'No insights generated.';

        return response()->json(['insights' => $insights]);

    } catch (\Exception $e) {
        Log::error('Mistral API Request Failed: ' . $e->getMessage());
        return response()->json(['insights' => 'Error generating insights.'], 500);
    }
}



}
