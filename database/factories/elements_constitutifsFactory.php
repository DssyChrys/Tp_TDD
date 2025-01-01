<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\elements_constitutifs>
 */
class elements_constitutifsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $code='EC'.str_pad($this->faker->numberBetween(0,99),2,'0',STR_PAD_LEFT);
        return [
            'code' => $code,
            'nom' => $this->faker->sentence(4),
            'coefficient' => $this->faker->numberBetween(0,4),
            'ue_id'=> \App\Models\unites_enseignement::factory()
        ];
    }
}