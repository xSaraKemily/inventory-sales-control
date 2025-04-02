<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $timestamps = [
            'created_at' => now(),
            'updated_at' => now(),
        ];

        DB::table('products')->insert([
            [
                'sku' => 'TV-AK932',
                'name' => 'Televisão Samsumg',
                'description' => 'Televisão Samsumg 48 polegadas',
                'cost_price' => 2000,
                'sale_price' => 2640.50,
                ...$timestamps
            ],
            [
                'sku' => 'PC-AB556',
                'name' => 'Computador Gamer',
                'description' => 'Computador gamer completo com processador, placa de video, fonte, memorias RAM e etc.',
                'cost_price' => 9000,
                'sale_price' => 11200.00,
                ...$timestamps
            ],
            [
                'sku' => 'NOT-UA702',
                'name' => 'Notebook Intel',
                'description' => 'Notebook Intel para uso casual',
                'cost_price' => 1000,
                'sale_price' => 2000,
                ...$timestamps
            ],
            [
                'sku' => 'CAB-AK674',
                'name' => 'Cabo USB',
                'description' => 'Cabo USB de 15 metros preto',
                'cost_price' => 10.90,
                'sale_price' => 20.90,
                ...$timestamps
            ],
            [
                'sku' => 'WEB-UO876',
                'name' => 'WebCam Redragon',
                'description' => 'Webcam da marca Redragon HD 720p',
                'cost_price' => 90.70,
                'sale_price' => 120.00,
                ...$timestamps
            ]
        ]);
    }
}
