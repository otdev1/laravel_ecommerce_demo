<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;


class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // $table->id();
        // $table->string('name')->unique();
        // $table->string('slug')->unique();
        // $table->string('details')->nullable(); 
        // $table->integer('price');
        // $table->text('description');
        // $table->timestamps(); 

        return [
            //
            'name' => $this->faker->text(50), //50 is number of text characters see https://fakerphp.github.io/formatters/text-and-paragraphs/
            'slug' => $this->faker->text(50),
            'details' => $this->faker->text(80),
            'price' => $this->faker->randomNumber(5, false), //Generates a random integer, containing between 0 and $nbDigits amount of digits see https://fakerphp.github.io/formatters/numbers-and-strings/
            'description' => $this->faker->paragraph(2), //Generate a paragraph of text, 2 sentences see https://fakerphp.github.io/formatters/text-and-paragraphs/
        ];
    }
}
