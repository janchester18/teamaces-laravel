<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function getEnrollmentInsights()
{
    // Static fake enrollment data used in the pie chart
    $enrollments = [
        'Enrolled' => 50, // Fake data: number of enrolled students
        'Pending' => 30,  // Fake data: number of pending enrollments
        'Dropped' => 20   // Fake data: number of dropped enrollments
    ];

    // Prepare data for insights
    $labels = array_keys($enrollments);
    $data = array_values($enrollments);

    // Call the API to generate insights
    $client = new \GuzzleHttp\Client();
    $url = 'https://api.arliai.com/v1/chat/completions';
    $apiKey = env('API_KEY_ARLI'); // Replace with your actual API key

    // Format the data for the API prompt
    $formattedData = array_map(function ($label, $value) {
        return "$label - $value";
    }, $labels, $data);

    $formattedDataString = implode(', ', $formattedData);

    $prompt = "Here is the enrollment status data for TeamAces Driving Academy: $formattedDataString. Generate a 3-sentence business insight based on this data. The categories include enrolled students, pending enrollments, and dropped enrollments. Provide suggestions to improve the enrollment process Dont include any introductory texts or sentences.";

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

}
