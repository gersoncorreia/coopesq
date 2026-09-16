<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HeroBannersSeeder extends Seeder
{
    public function run(): void
    {
        $banners = [
            [
                'order' => 1,
                'title' => 'Fortalecendo a Piscicultura e Agricultura na Amazônia',
                'subtitle' => 'Unindo produtores para entregar produtos sustentáveis e de altíssima qualidade diretamente de Porto Acre para todo o mercado.',
                'image' => '/storage/uploads/nA0TSZdFepZFyPGY2UFAbVTVCwvEWMnDXhig2kmK.png',
                'cta_text' => 'Conheça Nossos Produtos',
                'cta_url' => '#produtos',
                'is_active' => true,
            ],
            [
                'order' => 2,
                'title' => 'Nosso Produtos',
                'subtitle' => 'Produtos de alta qualidade',
                'image' => '/storage/uploads/ZlML7hgrPvFuQBwTJs7Etb4hUeIZESj1wKxPDu75.png',
                'cta_text' => null,
                'cta_url' => null,
                'is_active' => true,
            ],
        ];

        foreach ($banners as $banner) {
            DB::table('hero_banners')->updateOrInsert(
                ['title' => $banner['title']],
                array_merge($banner, ['created_at' => now(), 'updated_at' => now()])
            );
        }
    }
}
