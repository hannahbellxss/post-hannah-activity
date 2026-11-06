<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Indexed Array 
        $categories = [ 
            'Hardware', 
            'Electrical', 
            'Plumbing' 
        ]; 
 
        // MultidiArray 
        $products = [ 
            [ 
                'category' => $categories[0], 
                'name' => 'hammer', 
                'price' => 250, 
            ], 
            [ 
                'category' => $categories[1], 
                'name' => 'extension wire', 
                'price' => 450, 
            ], 
            [ 
                'category' => $categories[2], 
                'name' => 'water pipe', 
                'price' => 180, 
            ], 
        ]; 
 
        //  random product 
        $product = $this->faker->randomElement($products); 
 
        //  product name 
        $name = ucwords( 
            strtolower( 
                trim($product['name']) 
            ) 
        ); 
 
        return [ 
            'name' => $name, 
            'slug' => Str::slug($name) . '-' . $this->faker->unique()->randomNumber(3), 
            'category' => ucwords( 
                          strtolower( 
                          trim($product['category']) 
                ) 
            ), 
 
            'price' => $product['price'], 
            'quantity' => $this->faker->numberBetween(1, 100), 
            'status' => 'Available',  
        ]; 
    }
}
