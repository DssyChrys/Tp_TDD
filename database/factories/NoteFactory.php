<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Note>
 */
class NoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'etudiant_id' =>  \App\Models\Etudiant::factory(),
            'ec_id' =>  \App\Models\elements_constitutifs::factory(),
            'note' => $this->faker->numberBetween(0,20),
            'session' => $this->faker->randomElement(['normale', 'rattrapage']),
            'date_evaluation' => $this->faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
        ];
    }
}
