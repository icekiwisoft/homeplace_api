<?php

namespace Database\Factories;

use App\Models\Media;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Media>
 */
class MediaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Media::class;
    public function definition(): array
    {
        return [
            'file' => $this->faker->imageUrl(),
            'thumbnail' => $this->faker->imageUrl(),
            'type' => $this->faker->randomElement(["image","video"])
        ];
    }
}
