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
                             'title'           => 'Administardor',
                             'can_be_assigned' => 1,
                         ],
                         [
                             'title'           => 'Técnico',
                             'can_be_assigned' => 1,
                         ],
                         [
                             'title'           => 'Cliente',
                             'can_be_assigned' => 0,
                         ],
                     ]);
    }
}
