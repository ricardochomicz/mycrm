<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Classification;
use App\Models\Operator;
use App\Models\OrderType;
use App\Models\Plan;
use App\Models\Role;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        //Create Plans
        $plans = [
            [
                'name' => 'Free',
                'price' => 0.00
            ],
            [
                'name' => 'Starter',
                'price' => 9.90
            ],
            [
                'name' => 'Business',
                'price' => 29.90
            ],
        ];

        foreach ($plans as $plan) {
            $p = Plan::create($plan);
        }


        //Create Roles
        $roles = [
            [
                'name' => 'SuperAdmin',
                'label' => 'SuperAdmin',
                'description' => 'Administrador Total Sistema'
            ],
            [
                'name' => 'Admin',
                'label' => 'Admin',
                'description' => 'Administrador do Sistema'
            ],
            [
                'name' => 'Manager',
                'label' => 'Gerente',
                'description' => 'Gerente'
            ],
            [
                'name' => 'Supervisor',
                'label' => 'Supervisor',
                'description' => 'Supervisor Equipe'
            ],
            [
                'name' => 'Administrative',
                'label' => 'Administrativo',
                'description' => 'Administrativo'
            ],
            [
                'name' => 'User',
                'label' => 'Usuário',
                'description' => 'Usuário do Sistema'
            ],
        ];

        foreach ($roles as $role) {
            $role = Role::create($role);
        }


        $p = $p->latest('id')->first(); //Plano Business ID3
        $tenant = Tenant::create([
            'name' => 'RICARDO A G CHOMICZ ME',
            'document' => '27467352000108',
            'email' => 'ricardo.chomicz@gmail.com',
            'phone' => '42988080544',
            'plan_id' => $p->id
        ]);

        $user = User::create([
            'name' => 'Ricardo Chomicz',
            'email' => 'ricardo.chomicz@gmail.com',
            'phone' => '42988080544',
            'password' => bcrypt('rchomicz020904@'),
            'tenant_id' => $tenant->id
        ]);

        $user->roles()->attach(1); //SuperAdmin

        $types = [
            [
                'name' => 'NOVO',
                'tenant_id' => $tenant->id
            ],
            [
                'name' => 'PORTABILIDADE',
                'tenant_id' => $tenant->id
            ],
            [
                'name' => 'RENOVAÇÃO',
                'tenant_id' => $tenant->id
            ],
            [
                'name' => 'INTENET MÓVEL',
                'tenant_id' => $tenant->id
            ],
        ];

        foreach ($types as $t) {
            OrderType::create($t);
        }

    }
}
