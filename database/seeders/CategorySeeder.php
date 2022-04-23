<?php

namespace Database\Seeders;

use App\Models\Category;
use Faker\Generator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run(Generator $faker)
    {
        $categories=["Tablet","Syrup","Capsule","Salaine"];
        foreach($categories as $name){
            Category::create([
                "name"=>$name,
                "details"=>$faker->paragraph()
            ]);
        }
    }
}
