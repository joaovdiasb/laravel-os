<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run()
    {
        Client::insert([
                           [
                                'name' => 'Alphaville Jacuhy'
                           ],
                           [
                               'name' => 'Alphaville Volta Redonda'
                           ],
                           [
                               'name' => 'Alphaville São José dos Campos'
                           ],
                           [
                               'name' => 'Alphaville Lagoa dos Ingleses'
                           ],
                           [
                               'name' => 'Terras Alpha Goiás 2'
                           ],
                           [
                               'name' => 'Terras Alpha Ponta Grossa'
                           ],
                           [
                               'name' => 'Prefeitura de Cariacica'
                           ],
                           [
                               'name' => 'Prefeitura de Viana'
                           ],
                       ]);
    }
}
