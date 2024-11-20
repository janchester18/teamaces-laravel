<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use Illuminate\Http\Request;

class ShowEnrollmentController extends Controller
{
    public function showPendingEnrollments()
    {
        $staffBranchId = auth()->user()->branch_id;

        // Fetch pending enrollments
        $pendingEnrollments = Enrollment::with('course') // Eager load the course
            ->where('branch_id', $staffBranchId)
            ->where('is_approved', false)
            ->where('is_email_verified', true)
            ->get();

        // Fetch payments from PayMongo API
        $client = new \GuzzleHttp\Client();
        try {
            $response = $client->request('GET', 'https://api.paymongo.com/v1/payments?limit=10', [
                'headers' => [
                    'accept' => 'application/json',
                    'authorization' => 'Basic c2tfbGl2ZV9CWkxRenZQUmJXWUpqbUxCc2RRWE0yQ3Y6',
                ],
            ]);

            $payments = json_decode($response->getBody(), true)['data'];

            // Map the relevant payment data
            $paymentDetails = array_map(function ($payment) {
                return [
                    'id' => $payment['id'],
                    'amount' => $payment['attributes']['amount'],
                    'status' => $payment['attributes']['status'],
                    'description' => $payment['attributes']['description'],
                    'email' => $payment['attributes']['billing']['email'],
                    'name' => $payment['attributes']['billing']['name'],
                    'phone' => $payment['attributes']['billing']['phone'],
                    'paid_at' => $payment['attributes']['paid_at'] ?? null,
                    'payment_type' => $payment['attributes']['source']['type'] ?? 'N/A', // Payment type (e.g., 'card', 'visa', etc.)
                ];
            }, $payments);

        } catch (\Exception $e) {
            // Handle API errors
            $paymentDetails = [];
        }

        return view('admin.pending_enrollments', compact('pendingEnrollments', 'paymentDetails'));
    }
}
