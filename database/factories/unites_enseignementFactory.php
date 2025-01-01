<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\unites_enseignement>
 */
class unites_enseignementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $code='UE'.str_pad($this->faker->numberBetween(0,99),2,'0',STR_PAD_LEFT);
        return [
            'code' => $code,
            'nom' => $this->faker->sentence(5),
            'credits_ects' => $this->faker->numberBetween(0,99),
            'semestre' =>$this->faker->numberBetween(1,6)
        ];
    }
}