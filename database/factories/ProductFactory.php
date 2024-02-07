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
        $price = $this->faker->randomFloat(2, 1, 100);
        $buy_price = $this->faker->randomFloat(2, 1, 100);
        return [
            'name' => $this->faker->name,
            'description' => $this->faker->paragraph,
            'price' => $price,
            'sell_price' => $buy_price + $price,
            'buy_price' => $buy_price,
            'color_id' => \App\Models\Color::all()->random()->id,
            'size_id' => \App\Models\Size::all()->random()->id,
            'condition_id' => \App\Models\Condition::all()->random()->id,
            'material_id' => \App\Models\Material::all()->random()->id,
            'section_id' => \App\Models\Section::all()->random()->id,
            'category_id' => \App\Models\Category::all()->random()->id,
            'branch_id' => \App\Models\Branch::all()->random()->id,
            'season_id' => \App\Models\Season::all()->random()->id,
            'style_id' => \App\Models\Style::all()->random()->id,
            'location' => $this->faker->address,
            'is_for_sale' => false,
            'user_id' => \App\Models\User::all()->random()->id,
            'status' => $this->faker->randomElement(['rent', 'sale', 'available', 'not_available']),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Product $product) {
            $product->images()->createMany(\App\Models\Image::factory(2)->make()->toArray());
            $product->sku = ($product->is_for_sale ? 'S' : 'R') . str_pad($product->category_id, 3, '0',
                    STR_PAD_LEFT) . '-' .
                str_pad($product->id, 6, '0', STR_PAD_LEFT);
            $product->save();
        });
    }
}
