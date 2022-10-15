<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run()
    {
        Permission::insert([
                               [
                                   'title'      => 'Chamado: cadastrar',
                                   'identifier' => 'order_create',
                               ],
                               [
                                   'title'      => 'Chamado: atualizar',
                                   'identifier' => 'order_update',
                               ],
                               [
                                   'title'      => 'Chamado: deletar',
                                   'identifier' => 'order_delete',
                               ],
                               [
                                   'title'      => 'Chamado: selecionar tipo especial de fluxo',
                                   'identifier' => 'order_select_special_flow_type',
                               ],
                               [
                                   'title'      => 'Chamado: listar dos clientes',
                                   'identifier' => 'order_index_from_clients',
                               ],
                           ]);
    }
}
