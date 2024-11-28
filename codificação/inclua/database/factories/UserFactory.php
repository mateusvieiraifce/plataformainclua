<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nome_completo' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 
            'remember_token' => Str::random(10),
            'google_id' => null, 
            'avatar' => $this->faker->imageUrl(100, 100, 'people', true, 'User'), 
            'nome_completo' => $this->faker->name(),
            'documento' => $this->faker->numerify('###########'), 
            'telefone' => $this->faker->phoneNumber,
            'celular' => $this->faker->numerify('(##) 9####-####'),
            'codigo_validacao' => null, 
            'celular_validado' => false, 
            'rg' => $this->faker->numerify('#########'), 
            'data_nascimento' => $this->faker->date('Y-m-d', '2005-12-31'), 
            'sexo' => $this->faker->randomElement(['M', 'F']), 
            'tipo_pessoa' => 'F', 
            'tipo_user' => 'p', 
            'etapa_cadastro' => 'F',
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
