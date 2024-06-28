<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_job_id');
            $table->string('title');
            $table->text('description');
            $table->string('resume');
            $table->string('cover_letter');
            $table->timestamps();
             // Define the foreign key constraint
             $table->foreign('user_job_id')->references('id')->on('user_jobs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
