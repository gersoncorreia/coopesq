<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContentSeeder extends Seeder
{
    public function run(): void
    {
        // Testimonials
        $testimonials = [
            [
                'name' => 'Raimundo Nonato da Silva',
                'role' => 'Piscicultor Associado - Porto Acre',
                'content' => 'A COOPESQ transformou a forma como vendemos nossos peixes. Antes tínhamos dificuldade com compradores, hoje temos capacitação e garantia de comercialização justa.',
                'image' => null,
                'order' => 1,
            ],
            [
                'name' => 'Maria José de Oliveira',
                'role' => 'Produtora de Hortifruti',
                'content' => 'Fazer parte da cooperativa nos dá orgulho. Sabemos que nossas frutas e verduras chegam frescas a grandes restaurantes e feiras com responsabilidade socioambiental.',
                'image' => null,
                'order' => 2,
            ],
        ];

        foreach ($testimonials as $test) {
            DB::table('testimonials')->updateOrInsert(
                ['name' => $test['name']],
                array_merge($test, ['is_active' => true, 'created_at' => now(), 'updated_at' => now()])
            );
        }

        // Blog Post
        $noticiasCatId = DB::table('categories')->where('slug', 'noticias-e-eventos')->value('id') ?? 1;

        DB::table('posts')->updateOrInsert(
            ['slug' => 'coopesq-expande-parceria-com-restaurantes-e-distribuidores-no-acre'],
            [
                'category_id' => $noticiasCatId,
                'author_id' => 1,
                'title' => 'COOPESQ expande parceria com restaurantes e distribuidores no Acre',
                'excerpt' => 'Cooperativa agropecuária de Porto Acre consolida fornecimento contínuo de pescado fresco e hortifruti para o setor alimentício regional.',
                'content' => '<p>A COOPESQ segue avançando na consolidação da marca de piscicultura e produtos naturais da Amazônia. Com a ampliação de parcerias com restaurantes, hotéis e grandes redes de distribuição, nossos associados ganham segurança e escala na produção.</p><p>O compromisso com o cultivo sustentável e a rastreabilidade sociambiental permanecem no centro de nossas diretrizes corporativas.</p>',
                'featured_image' => '/storage/uploads/C0Pj6Esub8yOCvd86GWu0yOxC9n4DM2X5f33y3pm.png',
                'is_published' => true,
                'published_at' => now(),
                'meta_description' => 'Parceria da COOPESQ com restaurantes e distribuidores regionais fortalece a economia da piscicultura em Porto Acre.',
                'views' => 44,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
