<?php

namespace Tests\Feature;

use App\Mail\UserRegistration;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
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

        Mail::fake();

        $UserData = [
            "name"=>"elvin",
            "email"=>"elhirwa3@gmail.com",
            "password"=>"elvin",
            "password_confirmation"=>"elvin"
        ];   
        
        $response = $this->postJson('/api/register', $UserData);

        $email = "elhirwa3@gmail.com";

        Mail::assertSent(function (UserRegistration $mail) use ($email) {
            return $mail->email === $email;
        });


        $response->assertStatus(201);  

        $response->assertExactJson([
            "name"=>"elvin",
            "email"=>"elhirwa3@gmail.com"
            
        ]); 
    }
}