<?php

namespace Database\Seeders;

 use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
                        ClientSeeder::class,
                        OrderSituationSeeder::class,
                        OrderCategorySeeder::class,
                        OrderFlowTypeSeeder::class,
                        RoleSeeder::class,
                        PermissionSeeder::class,
                        PermissionRoleSeeder::class
                    ]);

        \App\Models\User::factory()->create([
                                                'name' => 'João Victor Dias Bittencourt',
                                                'email' => 'joao@aprovalegal.com.br',
                                                'password' => bcrypt('minhasenha'),
                                                'role_id' => 1
                                            ]);
    }
}
