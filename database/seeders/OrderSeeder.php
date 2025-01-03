<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;

class OrderSeeder extends Seeder
{
    public function run()
    {
        // Génère 5 “bons de commande” aléatoires
        Order::factory()->count(5)->create();
    }
}
