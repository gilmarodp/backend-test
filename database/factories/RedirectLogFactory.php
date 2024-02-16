<?php

namespace Database\Factories;

use App\Models\Redirect;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RedirectLog>
 */
class RedirectLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'redirect_id' => Redirect::factory()->create()->id,
            'ip_address' => fake()->ipv4(),
            'user_agent' => fake()->userAgent(),
            'header_refer' => fake()->url(),
            'query_params' =>json_encode(['foor' => 'bar']),
            'accessed_at' => date('Y-m-d H:i:s'),
        ];
    }
}
