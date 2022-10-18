<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run()
    {
        Role::insert([
                         [
                             'title'           => 'Administrador',
                             'can_be_assigned' => 1,
                             'has_client'      => 0,
                         ],
                         [
                             'title'           => 'Técnico',
                             'can_be_assigned' => 1,
                             'has_client'      => 0,
                         ],
                         [
                             'title'           => 'Cliente',
                             'can_be_assigned' => 0,
                             'has_client'      => 1,
                         ],
                     ]);
    }
}
