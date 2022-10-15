<?php

namespace Database\Seeders;

use App\Models\OrderSituation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSituationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run()
    {
        OrderSituation::insert([
                                   [
                                        'title' => 'Pendente',
                                        'color' => 'warning',
                                   ],
                                   [
                                       'title' => 'Em andamento',
                                       'color' => 'warning',
                                   ],
                                   [
                                       'title' => 'Aguardando aprovação',
                                       'color' => 'blue',
                                   ],
                                   [
                                       'title' => 'Aguardando terceiro',
                                       'color' => 'blue',
                                   ],
                                   [
                                       'title' => 'Solucionado',
                                       'color' => 'blue',
                                   ],
                               ]);
    }
}
