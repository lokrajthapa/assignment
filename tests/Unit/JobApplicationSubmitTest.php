<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
// use PHPUnit\Framework\TestCase;
use App\Models\Application;
use App\Notifications\JobApplicationSubmitted;
use Tests\TestCase;
use App\Models\UserJob;
use Illuminate\Support\Facades\Notification;


class JobApplicationSubmitTest extends TestCase
{
    use RefreshDatabase;
    protected $seed = true;

    /**
     * A basic unit test example.
     */
    public function test_if_application_submit_is_stored(): void
    {

        $userJobId=UserJob::inRandomOrder()->first()->id;

        $jobapplication = [
            'user_job_id' => $userJobId,
            'title' => 'Sample Title',
            'description' => 'Sample Description',
            'resume' => 'sample_resume.pdf',
            'cover_letter' => 'sample_cover_letter.docx',
        ];
        $jobApplications = Application::create($jobapplication);

        $jobApplications->save();

        $this->assertDatabaseHas('applications', [

            'title' => 'Sample Title',
            'description' => 'Sample Description',
            'resume' => 'sample_resume.pdf',
            'cover_letter' => 'sample_cover_letter.docx',
        ]);



        Notification::fake();


        // $userJob=$jobApplication->userJob;
         $jobProvider = UserJob::findorFail($userJobId)->user;

        // Assert that a notification was sent to the job provider user
        $jobProvider->notify(new JobApplicationSubmitted($jobApplications));
        Notification::assertSentTo(
            [$jobProvider],
            JobApplicationSubmitted::class
        );






    }
}
