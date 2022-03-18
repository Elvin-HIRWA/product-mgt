<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_User_Register_Successfully() {

        $UserData = [
            "name"=>"innocent",
            "email"=>"innocent@gmail.com",
            "password"=>"innocent",
            "password_confirmation"=>"innocent"
        ];   
        
        $response = $this->postJson('/api/register', $UserData);
        $response->assertStatus(201);  
        $response->assertExactJson([
            "name"=>"innocent",
            "email"=>"innocent@gmail.com"
            
        ]); 
    }
}