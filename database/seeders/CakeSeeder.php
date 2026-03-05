<?php

namespace Database\Seeders;

use App\Models\Cake;
use Illuminate\Database\Seeder;

class CakeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cakes = [
            [
                'name' => 'Clásica Fundente',
                'description' => 'Queso crema artesanal sobre base de galleta dorada, con un centro líquido que se derrama lentamente al primer corte.',
                'price' => 24.90,
                'image_url' => 'https://images.unsplash.com/photo-1533134242443-d4fd215305ad?auto=format&fit=crop&w=900&q=80',
                'is_available' => true,
            ],
            [
                'name' => 'Pistacho Ibérico Fluido',
                'description' => 'Intenso pistacho tostado, notas saladas y un corazón cremoso que cae como lava verde al abrir la porción.',
                'price' => 29.50,
                'image_url' => 'https://images.unsplash.com/photo-1558312651-b4be22e5a53b?auto=format&fit=crop&w=900&q=80',
                'is_available' => true,
            ],
            [
                'name' => 'Lotus & Caramelo Melting',
                'description' => 'Galleta Lotus triturada, caramelo mantecoso y centro sedoso ultra fluido que se desborda sobre cada migaja.',
                'price' => 27.90,
                'image_url' => 'https://images.unsplash.com/photo-1542826438-bd32f43d626f?auto=format&fit=crop&w=900&q=80',
                'is_available' => true,
            ],
            [
                'name' => 'Triple Chocolate Lava',
                'description' => 'Tres chocolates en capas, textura mousse y un núcleo caliente de cacao líquido que se derrama como volcán.',
                'price' => 31.00,
                'image_url' => 'https://images.unsplash.com/photo-1565958011703-44f9829ba187?auto=format&fit=crop&w=900&q=80',
                'is_available' => true,
            ],
        ];

        foreach ($cakes as $cake) {
            Cake::updateOrCreate(['name' => $cake['name']], $cake);
        }
    }
}
