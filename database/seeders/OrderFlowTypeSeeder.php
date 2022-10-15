<?php

namespace Database\Seeders;

use App\Models\OrderFlowType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderFlowTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run()
    {
        OrderFlowType::insert([
                                  [
                                      'title'            => 'Acompanhamento',
                                      'color'            => null,
                                      'needs_permission' => 0,
                                      'deleted_at'       => null,
                                  ],
                                  [
                                      'title'            => 'Tarefa',
                                      'color'            => 'yellow',
                                      'needs_permission' => 1,
                                      'deleted_at'       => null,
                                  ],
                                  [
                                      'title'            => 'Documento',
                                      'color'            => 'blue',
                                      'needs_permission' => 0,
                                      'deleted_at'       => now()->toDateTimeString(),
                                  ],
                                  [
                                      'title'            => 'Solução',
                                      'color'            => 'green',
                                      'needs_permission' => 1,
                                      'deleted_at'       => null,
                                  ],
                              ]);
    }
}
