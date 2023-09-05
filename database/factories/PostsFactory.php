<?php

namespace Database\Factories;


use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\posts>
 */
class PostsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $title = $this->faker-> sentence(5);
        $urlVideo = "https://www.youtube.com/watch?v=rEpIV9MBfrQ";

        return [

            //'perfil_id' => rand(1,20),
            //'category_id' => rand(1,20),
            'title' => $title,
            'slug' => Str::slug($title),
            'excerpt' => $this->faker->text(200),
            'content' => $this->faker->text(500),
            'stock' => rand(1, 50),
            'price' => rand(20, 2000),
            'status' => $this->faker->randomElement(['DRAFT', 'PUBLISHED']),
            'level' => $this->faker->randomElement(['top_sales', 'new_products', 'most_seen', 'nothing']),
            'img' => $this->faker->imageUrl($width = 1200, $height = 400),
            'url_video' => $urlVideo,


        ];

    }
}
