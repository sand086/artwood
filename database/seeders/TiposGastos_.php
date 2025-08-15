<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\TiposGastos;

class TiposGastos_ extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TiposGastos::factory(50)->create();
    }
}
