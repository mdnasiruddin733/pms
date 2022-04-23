<?php

namespace Database\Factories;

use Bezhanov\Faker\Provider\Medicine;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

        
        $faker = new Generator();
        $faker->addProvider(new Medicine($faker));

        return [
            "name"=>$faker->medicine(),
            "details"=>$this->faker->paragraph(),
            "category_id"=>$this->faker->numberBetween(1,4),
            "generic_id"=>$this->faker->numberBetween(1,9),
            "price"=>$this->faker->numberBetween(5,500),
            "quantity"=>$this->faker->numberBetween(0,200),
            "weight"=>$this->faker->numberBetween(10,1000),
            "image"=>$this->faker->imageUrl(400,400,"medicine",true, 1)
        ];
    }
}
