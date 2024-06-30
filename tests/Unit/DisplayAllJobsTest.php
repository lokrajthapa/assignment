<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\UserJob;
use Illuminate\Foundation\Testing\RefreshDatabase;



class DisplayAllJobsTest extends TestCase
{
    use RefreshDatabase;
    protected $seed = true;
    /**
     * A basic unit test example.
     */
    public function test_if_anyone_can_view_all_jobs(): void
    {

        User::factory()->count(2)->create();
        UserJob::factory()->count(20)->create();

        $response = $this->getJson('/api/alljobs');
        $response->assertStatus(200);
    }
}
