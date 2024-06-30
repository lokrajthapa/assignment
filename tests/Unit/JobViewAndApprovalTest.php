<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\UserJob;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use App\Notifications\UserJobUpdated;




class JobViewAndApprovalTest extends TestCase
{
    use RefreshDatabase;
    // protected $seed = true;
    /**
     * A basic unit test example.
     */
    public function test_if_all_jobs_are_shown(): void
    {

        $user = User::factory()->create(['role'=>'admin']);
        $alljobs =UserJob::factory()->count(20)->create();

        Passport::actingAs($user);


        $response = $this->getJson('/api/allJobSubmissions');

        // Assert that the response status is 200 OK
        $response->assertStatus(200);
    }

    public function test_if_job_status_is_updated_with_notificaton()
    {


        // Prevent actual notifications from being sent
        Notification::fake();

        // Create an admin user
        $admin = User::factory()->create(['role' => 'admin']);

        // Create a regular user and a UserJob
        $user = User::factory()->create();

        $userJob = UserJob::factory()->create(['user_id' => $user->id]);

        // Authenticate the admin user
        Passport::actingAs($admin);

        // Make a PATCH request to update the UserJob
        $response = $this->putJson("/api/updateJobStatus/{$userJob->id}", [
            'user_id'=>$user->id,
            'title' => 'Updated Title',
            'status'=>'approved',
            'company' => 'Updated Company',
            'location' => 'Updated Location',
            'description' => 'Updated Description',
            'application_instructions' => 'Updated Instructions',
        ]);

       dd($response->json());

        // Assert the response status is 200 OK
        $response->assertStatus(200);



        // Assert the UserJob was updated in the database
       $testingResponse = $this->assertDatabaseHas('user_jobs', [
            'id' => $userJob->id,
            'user_id'=>$user->id,
            'title' => 'Updated Title',
            'status'=>'approved',
            'company' => 'Updated Company',
            'location' => 'Updated Location',
            'description' => 'Updated Description',
            'application_instructions' => 'Updated Instructions',
        ]);


        // Assert a notification was sent to the user, with a delay of 10 minutes
        // Notification::assertSentTo(
        //     [$user],
        //     UserJobUpdated::class,
        //     function ($notification, $channels, $notifiable) {
        //         return $notification->delay->eq(now()->addMinutes(10));
        //     }
        // );

        $jobProvider->notify((new UserJobUpdated($userJob))->delay(now()->addMinutes(10)));
        Notification::assertSentTo(
            [$jobProvider],
            JobApplicationSubmitted::class
        );



    }
}
