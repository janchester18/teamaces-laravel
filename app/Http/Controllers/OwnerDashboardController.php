<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\Student; // Import the Student model
use App\Models\Schedule; // Import the Schedule model
use Carbon\Carbon; // Import Carbon for date handling
use Illuminate\Support\Facades\DB; // Import DB facade
use App\Models\Transaction; // Import the Transaction model

class OwnerDashboardController extends Controller
{
    public function index(Request $request)
    {
        // Determine the year to filter by (default to the current year)
        $yearFilter = $request->get('year', Carbon::now()->year);

        // Count the total number of students in the students table
        $totalStudents = Student::count();

        // Get today's date
        $today = Carbon::today();

        // Count how many students have scheduled sessions today with a status of 'pending' without filtering by branch_id
        $scheduledSessionsToday = Schedule::whereDate('scheduled_date', $today)
        ->where('status', 'pending') // Filter by 'pending' status
        ->count();

        // Sum the total revenue from the transactions table
        $totalRevenue = Transaction::sum('price');

        // Fetch revenue per month from the transactions table
        $monthlyRevenue = Transaction::select(DB::raw('SUM(price) as total_revenue'), DB::raw('MONTH(created_at) as month'))
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

        // Map revenue data for each month
        $revenueData = array_map(function ($month) use ($monthlyRevenue) {
            return $monthlyRevenue->get($month, 0);
        }, range(1, 12));

        // Fetch top 10 branches by revenue
        $topBranches = Branch::select('branches.name', DB::raw('SUM(transactions.price) as revenue'))
        ->join('transactions', 'transactions.branch_id', '=', 'branches.id')
        ->groupBy('branches.name')
        ->orderByDesc('revenue')
        ->take(10)
        ->get();

        return view('owner.branch_analytics', compact('totalStudents', 'scheduledSessionsToday', 'totalRevenue', 'revenueData', 'revenueMonths', 'yearFilter', 'topBranches')); // Pass revenue data to the view
    }

    public function getRevenueInsights(Request $request)
    {
        $yearFilter = $request->input('year', Carbon::now()->year); // Default to current year if not passed
        // Fetch the transactions and group by month
        $transactions = Transaction::selectRaw('SUM(price) as total, MONTH(created_at) as month')
            ->whereYear('created_at', $yearFilter) // Filter transactions by the selected year
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Prepare data for insights
        $labels = $transactions->pluck('month')->map(fn($month) => date('F', mktime(0, 0, 0, $month, 1)))->toArray();
        $data = $transactions->pluck('total')->toArray();

        // Call the API to generate insights
        $client = new Client();
        $url = 'https://api.arliai.com/v1/chat/completions';
        $apiKey = env('API_KEY_ARLI'); // Replace with your actual API key

        $formattedData = array_map(function ($label, $value) {
            return "$label - $value";
        }, $labels, $data);

        $formattedDataString = implode(', ', $formattedData);

        $prompt = "Here is the revenue data per month for the bar chart sales per month: $formattedDataString. Generate a 3-sentence business insights based on this graph. Don't include an introductory sentence. The business is a driving school named TeamAces Driving Academy. Don't include holidays and seasons. And provide suggestions. Again, don't include an introductory sentence or colon. The currency is Philippine pesos or pesos.";

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
            Log::info('Formatted Data String:', [$formattedDataString]);

            return response()->json(['insights' => $insights]);

        } catch (\Exception $e) {
            Log::error('API Request Failed: ' . $e->getMessage());
            return response()->json(['insights' => 'Error generating insights.'], 500);
        }
    }

}
