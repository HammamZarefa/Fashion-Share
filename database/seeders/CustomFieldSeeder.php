<?php

namespace Database\Seeders;

use App\Models\Banner;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Color;
use App\Models\Condition;
use App\Models\Material;
use App\Models\Product;
use App\Models\Section;
use App\Models\Size;
use App\Models\User;
use Database\Factories\BannerFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CustomFieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $colors = [
            ["name" => "Red"],
            ["name" => "Blue"],
            ["name" => "Black"],
            ["name" => "White"],
            ["name" => "Green"],
            ["name" => "Gray"]
        ];
        foreach ($colors as $color)
            Color::create($color);

        $matirials = [
            ["name" => "Polyster"],
            ["name" => "Poplin"],
            ["name" => "Muslin"],
            ["name" => "Lawn"],
            ["name" => "Wool"],
            ["name" => "Cotton"],
        ];
        foreach ($matirials as $matirial)
            Material::create($matirial);

        $size = [
            ["name" => "Small"],
            ["name" => "Medium"],
            ["name" => "Large"],
            ["name" => "Extra Large"]];

        foreach ($size as $item)
            Size::create($item);

        $conditions = [
            [
                "name" =>  "New",

            ],

        ];

        foreach ($conditions as $condition)
            Condition::create($condition);

        $sections = [
            ["name" => "Women"],
            ["name" => "Men"],
            ["name" => "Kids"],
            ["name" => "Accessories"],
        ];
        foreach ($sections as $section)
            Section::create($section);

        $categories = [
            ["name" => "Dress"
                , 'image' => 'https://picsum.photos/800/800?random=' . $faker->unique()->numberBetween(1, 1000),],
            ["name" => "Party Wear", 'image' => 'https://picsum.photos/800/800?random=' . $faker->unique()->numberBetween(1, 1000),],
            ["name" => "Wedding", 'image' => 'https://picsum.photos/800/800?random=' . $faker->unique()->numberBetween(1, 1000),],
            ["name" => "Hats", 'image' => 'https://picsum.photos/800/800?random=' . $faker->unique()->numberBetween(1, 1000),],
            ["name" => "Gold", 'image' => 'https://picsum.photos/800/800?random=' . $faker->unique()->numberBetween(1, 1000),],
            ["name" => "Shirt", 'image' => 'https://picsum.photos/800/800?random=' . $faker->unique()->numberBetween(1, 1000),],
        ];

        foreach ($categories as $category)
            Category::create($category);

        $branches = [
            ["name" => "Bab Tuma", "address" => "babtuma"],
            ["name" => "Jaramana", "address" => "jarmana"],
        ];

        foreach ($branches as $branch)
            Branch::create($branch);

        User::factory()->create();
        Product::factory(1000)->create();
        Banner::factory(3)->create();

    }


}
