<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Generic;
use Faker\Generator;

class GenericSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Generator $faker)
    {
        $genercis=["Aceclofenac","Acetylcysteine","Aciclovir","Ambroxol","Amoxicillin","Aspirin","Aripiprazole","Atorvastatin","Azithromycin"];
        foreach($genercis as $name){
            Generic::create([
                "name"=>$name,
                "details"=>$faker->paragraph()
            ]);
        }
    }
}
