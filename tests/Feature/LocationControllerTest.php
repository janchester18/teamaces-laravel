<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LocationControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testIndexMethodReturnsData()
{
    $response = $this->get('/locations'); // Adjust route if necessary
    $response->assertStatus(200); // Check if the response status is OK
    $response->assertViewHas('locations'); // Ensure the view has the 'locations' data
}

}
