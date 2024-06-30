<?php

namespace Tests\Unit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\UserJob;
use Laravel\Passport\Passport;



class UserJobTest extends TestCase
{
    use RefreshDatabase;
    protected $seed = true;

    /**
     * A basic unit test example.
     */
    // public function test_example(): void
    // {

    //     // $this->assertTrue(true);
    // }

    public function test_same_user_can_update_user_job()
    {
        // Create a user and a user job
        $user = User::factory()->create();
        $userJob = UserJob::factory()->create(['user_id' => $user->id]);

        Passport::actingAs($user);

        $response = $this->putJson("/api/job/{$userJob->id}", [
            'title' => 'Updated Title'
        ]);

        $response->assertStatus(200);
        $this->assertEquals('Updated Title', $userJob->fresh()->title);
    }


    public function test_other_user_cannot_update_user_job()
    {

        $user1 = User::factory()->create();
        $user2 = User::factory()->create();


        $userJob = UserJob::factory()->create(['user_id' => $user1->id]);


        Passport::actingAs($user2);


        $response = $this->putJson("/api/job/{$userJob->id}", [
            'title' => 'Updated Title'
        ]);

        // Assert that the response status is 403 Forbidden
        $response->assertStatus(403);

        // Assert that the title was not updated
        $this->assertNotEquals('Updated Title', $userJob->fresh()->title);
    }

    public function test_same_user_can_delete_user_job()
    {
        // Create a user and a user job
        $user = User::factory()->create();
        $userJob = UserJob::factory()->create(['user_id' => $user->id]);

        // Authenticate the user with Passport
        Passport::actingAs($user);

        // Make a DELETE request to delete the user job
        $response = $this->deleteJson("/api/job/{$userJob->id}");

        // Assert that the response status is 200 OK
        $response->assertStatus(200);

        // Assert that the user job was deleted
        $this->assertNull(UserJob::find($userJob->id));
    }

    public function test_other_user_cannot_delete_user_job()
    {
        // Create two users
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        // Create a user job for user1
        $userJob = UserJob::factory()->create(['user_id' => $user1->id]);

        // Authenticate as user2
        Passport::actingAs($user2);

        // Make a DELETE request to delete the user job
        $response = $this->deleteJson("/api/job/{$userJob->id}");

        // Assert that the response status is 403 Forbidden
        $response->assertStatus(403);

        // Assert that the user job was not deleted
        $this->assertNotNull(UserJob::find($userJob->id));
    }



}
