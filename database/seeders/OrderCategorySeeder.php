<?php

namespace Database\Seeders;

use App\Models\OrderCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run()
    {
        OrderCategory::insert([
                                 [
                                     'title' => 'Dúvida',
                                 ],
                                 [
                                     'title' => 'Solução de problema',
                                 ],
                                 [
                                     'title' => 'Pedido de alteração'
                                 ]
                              ]);
    }
}
