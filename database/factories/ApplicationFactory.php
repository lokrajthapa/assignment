<?php

namespace Database\Factories;
use App\Models\UserJob;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Application>
 */
class ApplicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $fakeResume= UploadedFile::fake()->create('example.pdf', 100); // 100 KB

        $resumePath = $fakeResume->store('documents', 'public');
        $fakeCoverLetter= UploadedFile::fake()->create('example.pdf', 100); // 100 KB
        $coverLetterPath = $fakeCoverLetter->store('letters', 'public');

        $userJobId=UserJob::inRandomOrder()->first()->id;
        return [
            'user_job_id' => $userJobId,
            'title' => $this->faker->jobTitle,
            'description' => $this->faker->paragraph,
            'resume'=>$resumePath,
            'cover_letter'=>$coverLetterPath
        ];
    }
}
