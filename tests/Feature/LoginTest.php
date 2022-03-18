<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LoginTest extends TestCase
{
    use DatabaseMigrations;
    
    /** @test */
    public function check_user_login() {

        $user = User::Create([
            "name" =>"innocent",
            "email" =>"innocent@gmail.com",
            "password" =>bcrypt("innocent"),
        ]); 

     $response = $this->postJson('/api/login', [
         'email' => $user->email,
         'password' => "innocent"
     ]);
     $response->assertStatus(201);
     $response->assertJsonStructure([
         'token',
     ])->json();
     
     $token = $response->json('token');
    }
}