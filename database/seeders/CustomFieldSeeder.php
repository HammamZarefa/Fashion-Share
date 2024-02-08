<?php

namespace Database\Seeders;

use App\Models\Banner;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Color;
use App\Models\Condition;
use App\Models\Material;
use App\Models\Product;
use App\Models\Season;
use App\Models\Section;
use App\Models\Size;
use App\Models\Style;
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
            ["name" => "Red", "Hexcolor" => "#ff0000"],
            ["name" => "Blue", "Hexcolor" => "#0000ff"],
            ["name" => "Black", "Hexcolor" => "#000000"],
            ["name" => "White", "Hexcolor" => "#ffffff"],
            ["name" => "Green", "Hexcolor" => "#00ff00"],
            ["name" => "Gray", "Hexcolor" => "#666666"]
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

        $seasons = [
            ["name" => "Summer"],
            ["name" => "Winter"],
            ["name" => "Autumn"],
            ["name" => "Spring"],
        ];
        foreach ($seasons as $season)
            Season::create($season);

        $conditions = [
            ["name" => "New"],
            ["name" => "Used"],
            ["name" => "Refurbished"],

        ];

        foreach ($conditions as $condition)
            Condition::create($condition);

        $sections = [
            ["name" => "Women", "is_rent" => false],
            ["name" => "Rent", "is_rent" => false],
        ];
        foreach ($sections as $section)
            Section::create($section);

        $categories = [
            ["name" => "Dress"
                , 'image' => 'https://picsum.photos/800/800?random=' . $faker->unique()->numberBetween(1, 1000), 'section_id' => 1],
            ["name" => "Party Wear", 'image' => 'https://picsum.photos/800/800?random=' . $faker->unique()->numberBetween(1, 1000), 'section_id' => 1],
            ["name" => "Dress"
                , 'image' => 'https://picsum.photos/800/800?random=' . $faker->unique()->numberBetween(1, 1000), 'section_id' => 2],
            ["name" => "Party Wear", 'image' => 'https://picsum.photos/800/800?random=' . $faker->unique()->numberBetween(1, 1000), 'section_id' => 2],
        ];

        foreach ($categories as $category)
            Category::create($category);


        $size = [
            ["name" => "Small", "category_id" => 1, "section_id" => 1],
            ["name" => "Medium", "category_id" => 1, "section_id" => 2],
            ["name" => "Small", "category_id" => 2, "section_id" => 1],
            ["name" => "Medium", "category_id" => 2, "section_id" => 2],
            ["name" => "Small", "category_id" => 3, "section_id" => 1],
            ["name" => "Medium", "category_id" => 3, "section_id" => 2],
            ["name" => "Small", "category_id" => 4, "section_id" => 1],
            ["name" => "Medium", "category_id" =>4, "section_id" => 2],
        ];

        foreach ($size as $item)
            Size::create($item);


        $styles = [
            ["name" => "Long", "category_id" => 1, "section_id" => 1],
            ["name" => "Short", "category_id" => 1, "section_id" => 2],
            ["name" => "Long", "category_id" => 2, "section_id" => 1],
            ["name" => "Short", "category_id" => 2, "section_id" => 2],
            ["name" => "Long", "category_id" => 3, "section_id" => 1],
            ["name" => "Short", "category_id" => 3, "section_id" => 2],
            ["name" => "Long", "category_id" => 4, "section_id" => 1],
            ["name" => "Short", "category_id" => 4, "section_id" => 2],
        ];

        foreach ($styles as $style)
            Style::create($style);

        $branches = [
            ["name" => "Bab Tuma", "address" => "babtuma"],
            ["name" => "Jaramana", "address" => "jarmana"],
        ];

        foreach ($branches as $branch) {
            $createdBranch = Branch::create($branch);
            $createdBranch->categories()->attach(\App\Models\Category::all()->pluck('id'));
            $createdBranch->sections()->attach(\App\Models\Section::all()->pluck('id'));
            $createdBranch->sizes()->attach(\App\Models\Size::all()->pluck('id'));
            $createdBranch->colors()->attach(\App\Models\Color::all()->pluck('id'));
            $createdBranch->conditions()->attach(\App\Models\Condition::all()->pluck('id'));
            $createdBranch->materials()->attach(\App\Models\Material::all()->pluck('id'));
            $createdBranch->seasons()->attach(\App\Models\Season::all()->pluck('id'));
            $createdBranch->styles()->attach(\App\Models\Style::all()->pluck('id'));
        }


        User::factory()->create();
        Product::factory(100)->create();
        Banner::factory(3)->create();

    }


}
