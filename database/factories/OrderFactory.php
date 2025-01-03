<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Order;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition()
    {
        return [
            // Le url_token sera généré par le Model (booted())
            'title'       => $this->faker->sentence(3),
            'description' => $this->faker->paragraph,
        ];
    }
}
