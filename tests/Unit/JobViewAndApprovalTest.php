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

//     public function test_if_job_status_is_updated_with_notificaton()
//     {




//         // Create an admin user
//         $admin = User::factory()->create(['role' => 'admin']);

//         // Create a regular user and a UserJob
//         $jobProvider = User::factory()->create();

//         $userJob = UserJob::factory()->create(['user_id' => $jobProvider->id]);

//         // Authenticate the admin user
//         Passport::actingAs($admin);

//         // Make a PUT request to update the UserJob
//         $userJob = $this->putJson("/api/updateJobStatus/{$userJob->id}", [

//             'status'=>'approved',
//         ]);


//         // Prevent actual notifications from being sent
//         Notification::fake();
//         // Assert the response status is 200 OK
//         $userJob->assertStatus(200);



//         // Assert the UserJob was updated in the database
//        $userJob = $this->assertDatabaseHas('user_jobs', [

//             'status'=>'approved',

//         ]);

//         $jobProvider->notify((new UserJobUpdated($userJob))->delay(now()->addMinutes(10)));

//         Notification::assertSentTo(
//             [$jobProvider],
//             UserJobUpdated::class,
//             function ($notification, $channels) use ($userJob) {
//                 return $notification->userJob->is($userJob) && $notification->delay->eq(now()->addMinutes(10));
//             }
//         );





//     }
// }
}
