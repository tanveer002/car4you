<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

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
        return [
            'name' => $this->faker->name(),
            'description' => $this->faker->text(),
        ];
    }

    /**
     * Indicate that the product should have a specific name.
     *
     * @param  string  $name
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function withName(string $name)
    {
        return $this->state(function() use ($name) {
            return [
                'name' => $name,
            ];
        });
    }

    /**
     * Indicate that the product should have a specific description.
     *
     * @param  string  $description
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function withDescription(string $description)
    {
        return $this->state(function() use ($description) {
            return [
                'description' => $description,
            ];
        });
    }
}
