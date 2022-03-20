<?php

namespace Tests\Feature;

use App\Models\Product;
use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertJson;

class ProductsTest extends TestCase
{
    use DatabaseMigrations;
    
    /**
     * @test
     */
    public function can_create_a_product()
    {
        $user = User::create([
            "name" => "innoss",
            "email" => "Kimihurora@murwanda.com",
            "password" => "elvin30",
            "password_confirmation" => "elvin30"
        ]);
        
        
        $response = $this->actingAs($user)->postJson("/api/product", [
            "name" => "innoss",
            "description" => "Kimihurora mu rwanda",
            "price" => 30,
            "quantity" => 5,
        ]);
        $response->assertStatus(201);
        $response->assertExactJson([       
                "name" => "innoss",
                "description" => "Kimihurora mu rwanda",
                "price" => 30,
                "quantity" => 5,
            ]);
        $this->assertCount(1,Product::all());
    }


    /** @test */
    public function a_user_can_read_all_the_product()
    {
        $user = User::create([
            "name" => "innoss",
            "email" => "Kimihurora@murwanda.com",
            "password" => "elvin30",
            "password_confirmation" => "elvin30"
        ]);
        Product::create([
            "name" => "innoss",
            "description" => "Kimihurora mu rwanda",
            "price" => "30",
            "quantity" => "5",
        ]);

        // Product::create([
        //     "name" => "innoss",
        //     "description" => "Kimihurora mu rwanda",
        //     "price" => "30",
        //     "quantity" => "5",
        // ]);

        $response = $this->actingAs($user)->getJson('/api/product');
        $response->assertStatus(201);
        $response->assertExactJson([
            [
                "name" => "innoss",
                "description" => "Kimihurora mu rwanda",
                "price" => 30,
                "quantity" => 5,
            ],
            // [
            //     "name" => "innoss",
            //     "description" => "Kimihurora mu rwanda",
            //     "price" => 30,
            //     "quantity" => 5,
            // ]
        ]);
    }

    /** @test */
    public function can_update_a_product()
    {
        $user = User::create([
            "name" => "innoss",
            "email" => "Kimihurora@murwanda.com",
            "password" => "elvin30",
            "password_confirmation" => "elvin30"
        ]);
       $product = Product::create([
            "name" => "innoss",
            "description" => "Kimihurora mu rwanda",
            "price" => "30",
            "quantity" => "5",
        ]);

        $response = $this->actingAs($user)->putJson("/api/product/{$product->id}", [
            "name" => "Ndoli",
            "description" => "Kimihurora mu rwanda",
            "price" => "30",
            "quantity" => "5",
        ]);
        $response->assertStatus(200);
        $response->assertExactJson([
            "name" => "Ndoli",
            "description" => "Kimihurora mu rwanda",
            "price" => "30",
            "quantity" => "5",
        ]);
    }
    /** @test */
    public function can_delete_a_product()
    {
        $user = User::create([
            "name" => "innoss",
            "email" => "Kimihurora@murwanda.com",
            "password" => "elvin30",
            "password_confirmation" => "elvin30"
        ]);
        $product = Product::create([
            "name" => "innoss",
            "description" => "Kimihurora mu rwanda",
            "price" => "30",
            "quantity" => "5",
        ]);
        $response = $this->actingAs($user)->deleteJson("/api/product/{$product->id}");
        $response->assertStatus(200);
        $response->assertExactJson(["msg"=> "Product Deleted successfully"]);
        $response = $this->actingAs($user)->getJson('/api/product');
        $response->assertStatus(201);
        $response->assertExactJson([]);
        
    }

    /** @test */
    public function can_search_a_product_with_related_name()
    {
        $user = User::create([
            "name" => "Elvin",
            "email" => "elhirwa3@gmail.com",
            "password" => "landlord",
            "password_confirmation" => "landlord"
        ]);
        $product = Product::create([
            "name" => "innoss",
            "description" => "Kimihurora mu rwanda",
            "price" => 30,
            "quantity" => 5
        ]);
        $response = $this->actingAs($user)->getJson("/api/product/search/{$product->name}");
        $response->assertStatus(200);
        $response->assertExactJson([
            "name" => "innoss",
            "description" => "Kimihurora mu rwanda",
            "price" => 30,
            "quantity" => 5
        ]);
    }
    
}