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
                                   'title'      => 'Chamado: listar todos do cliente',
                                   'identifier' => 'order_index_from_clients',
                               ],
                               [
                                   'title'      => 'Grupo: listar',
                                   'identifier' => 'role_index',
                               ],
                               [
                                   'title'      => 'Grupo: cadastrar',
                                   'identifier' => 'role_create',
                               ],
                               [
                                   'title'      => 'Grupo: atualizar',
                                   'identifier' => 'role_update',
                               ],
                               [
                                   'title'      => 'Grupo: deletar',
                                   'identifier' => 'role_delete',
                               ],
                               [
                                   'title'      => 'Usuário: listar',
                                   'identifier' => 'user_index',
                               ],
                               [
                                   'title'      => 'Usuário: cadastrar',
                                   'identifier' => 'user_create',
                               ],
                               [
                                   'title'      => 'Usuário: atualizar',
                                   'identifier' => 'user_update',
                               ],
                               [
                                   'title'      => 'Usuário: deletar',
                                   'identifier' => 'user_delete',
                               ],
                               [
                                   'title'      => 'Cliente: listar',
                                   'identifier' => 'client_index',
                               ],
                               [
                                   'title'      => 'Cliente: cadastrar',
                                   'identifier' => 'client_create',
                               ],
                               [
                                   'title'      => 'Cliente: atualizar',
                                   'identifier' => 'client_update',
                               ],
                               [
                                   'title'      => 'Cliente: deletar',
                                   'identifier' => 'client_delete',
                               ],
                               [
                                   'title'      => 'Categoria de chamado: listar',
                                   'identifier' => 'order_category_index',
                               ],
                               [
                                   'title'      => 'Categoria de chamado: cadastrar',
                                   'identifier' => 'order_category_create',
                               ],
                               [
                                   'title'      => 'Categoria de chamado: atualizar',
                                   'identifier' => 'order_category_update',
                               ],
                               [
                                   'title'      => 'Categoria de chamado: deletar',
                                   'identifier' => 'order_category_delete',
                               ],
                           ]);
    }
}
