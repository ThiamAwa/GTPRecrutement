<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Candidat>
 */
class CandidatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nom' => $this->faker->lastName,
            'prenom' => $this->faker->firstName,
            'telephone' => $this->faker->phoneNumber,
            'email' => $this->faker->unique()->safeEmail,
            'adresse' => $this->faker->address,
            'status' => $this->faker->randomElement(['En cours', 'Accepter','Refuser']),
            'date_de_candidature' => $this->faker->date,
//            'statut_evaluation' => $this->faker->randomElement(['Non évalué', 'En cours', 'Évalué']),
            'date_de_naissance' => $this->faker->date,
            'cv' => $this->faker->url,
            'lm' => $this->faker->url,
        ];
    }
}
