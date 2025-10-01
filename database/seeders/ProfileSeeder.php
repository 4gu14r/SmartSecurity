<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $profiles = [
            [
                'name' => 'Administrador',
                'description' => 'Acesso completo ao sistema, pode gerenciar usuários e configurações',
            ],
            [
                'name' => 'Usuário',
                'description' => 'Usuário padrão, pode reportar e visualizar ocorrências',
            ],
            [
                'name' => 'Moderador',
                'description' => 'Pode moderar ocorrências e comentários',
            ],
        ];

        foreach ($profiles as $profile) {
            \App\Models\Profile::firstOrCreate(
                ['name' => $profile['name']],
                $profile
            );
        }
    }
}
