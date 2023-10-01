<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'description' => $this->faker->paragraph,
            'price' => $this->faker->randomFloat(2, 1, 100),
            'color_id' => \App\Models\Color::all()->random()->id,
            'size_id' => \App\Models\Size::all()->random()->id,
            'condition_id' => \App\Models\Condition::all()->random()->id,
            'material_id' => \App\Models\Material::all()->random()->id,
            'section_id' => \App\Models\Section::all()->random()->id,
            'branch_id' => \App\Models\Branch::all()->random()->id,
            'location' => $this->faker->address,
            'is_for_sale' => $this->faker->boolean,
            'user_id' => \App\Models\User::all()->random()->id,
            'status' => $this->faker->randomElement(['rent', 'sale', 'available', 'not_available']),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Product $product) {
            $product->categories()->attach(\App\Models\Category::all()->pluck('id')->toArray());
            $product->images()->createMany(\App\Models\Image::factory(5)->make()->toArray());
            $product->sku = ($product->is_for_sale ? 'S' : 'R') . str_pad(($product->categories->pluck('category_id')->toArray())[0], 3, '0',
                    STR_PAD_LEFT) . '-' .
                str_pad($product->id, 6, '0', STR_PAD_LEFT);
            $product->save();
        });
    }
}
