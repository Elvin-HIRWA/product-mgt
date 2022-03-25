<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Product;
use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertJson;

class ProductsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function user_can_create_the_product()
    {
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
        'token'
    ])->json();
    $token = $response->json('token');
    $response = $this->withHeaders(['Authorization' => "Bearer $token"])->
    postJson("/api/product", [
        "name" => "Ndoli",
        "description" => "Kimihurora mu rwanda",
        "price" => 30,
        "quantity" => 5,
    ]);
    $response->assertStatus(201);
    $response->assertJson([
        "name" => "Ndoli",
        "description" => "Kimihurora mu rwanda",
        "price" => 30,
        "quantity" => 5,
    ]);
    }

    //this test is for reading single data
    /** @test */
    public function a_user_can_filter_the_product_by_its_id()
    {
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
           'token'
       ])->json();

       $product = Product::create([
        "id" => 1,
        "name" => "innoss",
        "description" => "Kimihurora mu rwanda",
        "price" => 30,
        "quantity" => 5,
    ]);


       $token = $response->json('token');
       
       $response = $this->withHeaders(['Authorization' => "Bearer $token"])->getJson("/api/product/{$product->id}");
    
        $response->assertStatus(200);
        $response->assertExactJson(
            [
                "id" => 1,
                "name" => "innoss",
                "description" => "Kimihurora mu rwanda",
                "price" => 30,
                "quantity" => 5,
            ]);
        
    }

     /** @test */
    public function a_user_can_read_all_the_product()
    {
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
           'token'
       ])->json();

       $product = Product::create([
        "id" => 1,
        "name" => "innoss",
        "description" => "Kimihurora mu rwanda",
        "price" => 30,
        "quantity" => 5,
    ]);


       $token = $response->json('token');
       
       $response = $this->withHeaders(['Authorization' => "Bearer $token"])->getJson("/api/product");
    
        $response->assertStatus(200);
        $response->assertExactJson([
            [
                "id" => 1,
                "name" => "innoss",
                "description" => "Kimihurora mu rwanda",
                "price" => 30,
                "quantity" => 5,]
            ]); 
    }

    /** @test */
    public function can_update_a_product()
    {
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
        'token'
    ])->json();
    $product = Product::create([
        "id" => 1,
        "name" => "innoss",
        "description" => "Kimihurora mu rwanda",
        "price" => 30,
        "quantity" => 5,
    ]);

    $token = $response->json('token');
    $response = $this->withHeaders(['Authorization' => "Bearer $token"])->
    putJson("/api/product/{$product->id}", [
        "name" => "Ndoli",
        "description" => "Kimihurora mu rwanda",
        "price" => 30,
        "quantity" => 5,
    ]);
    $response->assertStatus(200);
    $response->assertJson([
        "name" => "Ndoli",
        "description" => "Kimihurora mu rwanda",
        "price" => 30,
        "quantity" => 5,
    ]);
    }
    /** @test */
    public function can_delete_a_product()
    {
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
           'token'
       ])->json();

       $product = Product::create([
        "id" => 1,
        "name" => "innoss",
        "description" => "Kimihurora mu rwanda",
        "price" => 30,
        "quantity" => 5,
    ]);


       $token = $response->json('token');
       
       $response = $this->withHeaders(['Authorization' => "Bearer $token"])->deleteJson("/api/product/{$product->id}");
    
        $response->assertStatus(200);
        $response->assertExactJson(["msg"=> "Product Deleted successfully"]);
        
    }

    /** @test */
    public function can_search_a_product_with_related_name()
    {
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
           'token'
       ])->json();

       $product = Product::create([
        "id" => 1,
        "name" => "innoss",
        "description" => "Kimihurora mu rwanda",
        "price" => 30,
        "quantity" => 5,
    ]);


       $token = $response->json('token');
       
       $response = $this->withHeaders(['Authorization' => "Bearer $token"])->getJson("/api/product/search/{$product->name}");
    
        $response->assertStatus(200);
        $response->assertExactJson([
            [
                "id" => 1,
                "name" => "innoss",
                "description" => "Kimihurora mu rwanda",
                "price" => 30,
                "quantity" => 5,]
            ]);
    }
    
}