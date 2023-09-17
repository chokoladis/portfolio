<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Example_work;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Example_work>
 */
class Example_workFactory extends Factory
{
    protected $model = Example_work::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $arWorksUrl = ['zolotoykod.ru','linza.team', 'mag.zoloykod.ru', 'antro.cx', 'forward-media.ru', 'sbg-s.ru'];

        return [
            'title' => fake()->sentence(4),
            'description' => fake()->text(150),
            'url_work' => $arWorksUrl[rand(0, count($arWorksUrl) - 1 )],
            'url_files' => fake()->image('public/storage/works/img', 900, 900, null, false),
        ];
    }
}
