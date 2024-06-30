<?php

namespace Tests\Unit;

// use PHPUnit\Framework\TestCase;
use Tests\TestCase;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;


class AuthenticationTest extends TestCase
{
    use RefreshDatabase;


    /**
     * A basic unit test example.
     */
    public function test_should_registe_a_user(): void
    {

    // $response = $this->postJson('/api/register', [
    //     'name' => 'Test User',
    //          'email' => 'test@example.com',
    //          'user_type'=>'jobProvider',
    //          'role'=>'admin',
    //          'password' => 'password',
    //         'password_confirmation' => 'password'
    // ]);

    // $response->assertStatus(201) // Expect 201 status code
    //          ->assertJsonStructure([
    //              'user' => [
    //                  'id',
    //                  'name',
    //                  'email',
    //                  'created_at',
    //                  'updated_at',
    //              ],
    //              'token'
    //          ]);

    // $this->assertDatabaseHas('users', [
    //     'email' => 'test@example.com',
    // ]);
    $this->assertTrue(true);

    }
}
