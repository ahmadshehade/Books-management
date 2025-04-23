<?php

namespace Database\Factories;
;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Language;
use App\Models\BookType;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->unique()->sentence(3);
        return [
            "title"=> $title,
            'slug'=>Str::slug($title),
            'author_id'=>User::inRandomOrder()->first()->id,
            'description' => $this->faker->paragraph(4),
            'price' => $this->faker->randomFloat(2, 5, 100),
            'cover_image' => null,
            'pdf_copy' => null, 
            'isbn'=>$this->faker->isbn13,
            'published_at' => $this->faker->date(),
            'stock' => $this->faker->numberBetween(0, 50),
            'language_id' => Language::inRandomOrder()->first()->id,
            'type_id' => BookType::inRandomOrder()->first()->id,
            'pages' => $this->faker->numberBetween(100, 500),
            'is_valid' => $this->faker->boolean(90), // 90% تكون valid
            
        ];
    }
}
