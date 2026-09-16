<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DifferentialsSeeder extends Seeder
{
    public function run(): void
    {
        $differentials = [
            [
                'title' => 'Produção Sustentável',
                'description' => 'Implementamos práticas de cultivo que respeitam o meio ambiente e garantem a saúde dos ecossistemas aquáticos.',
                'icon' => 'leaf',
                'order' => 1,
            ],
            [
                'title' => 'Capacitação e Manejo',
                'description' => 'Oferecemos treinamentos e workshops para nossos membros, visando aprimorar técnicas de manejo, alimentação e saúde dos peixes.',
                'icon' => 'academic-cap',
                'order' => 2,
            ],
            [
                'title' => 'Apoio Comercial',
                'description' => 'Facilitamos o acesso ao mercado para nossos associados promovendo a venda direta de produtos e parcerias com distribuidores.',
                'icon' => 'briefcase',
                'order' => 3,
            ],
            [
                'title' => 'Inovação Tecnológica',
                'description' => 'Estamos sempre em busca de novas tecnologias e métodos para melhorar a eficiência e a qualidade da produção.',
                'icon' => 'light-bulb',
                'order' => 4,
            ],
        ];

        foreach ($differentials as $diff) {
            DB::table('differentials')->updateOrInsert(
                ['title' => $diff['title']],
                array_merge($diff, ['is_active' => true, 'created_at' => now(), 'updated_at' => now()])
            );
        }
    }
}
