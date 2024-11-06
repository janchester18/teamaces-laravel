<?php

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie', 'schedules/*'], // Add your paths here

    'allowed_methods' => ['*'], // Allows all HTTP methods

    'allowed_origins' => ['*'], // Allows all origins or specify exact origins ['http://yourdomain.com']

    'allowed_origins_patterns' => [], // Patterns for allowed origins

    'allowed_headers' => ['*'], // Allows all headers

    'exposed_headers' => [], // Headers exposed to the client

    'max_age' => 0, // Cache duration in seconds

    'supports_credentials' => true, // Set to true if using cookies or authentication headers
];
