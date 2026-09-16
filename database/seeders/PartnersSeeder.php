<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PartnersSeeder extends Seeder
{
    public function run(): void
    {
        $partners = [
            ['name' => 'Prefeitura de Rio Branco', 'logo' => '/images/partners/rio-branco.svg', 'url' => 'https://riobranco.ac.gov.br', 'order' => 1],
            ['name' => 'Prefeitura de Senador Guiomard', 'logo' => '/images/partners/senador-guiomard.svg', 'url' => null, 'order' => 2],
            ['name' => 'Prefeitura de Bujari', 'logo' => '/images/partners/bujari.svg', 'url' => null, 'order' => 3],
            ['name' => 'Governo do Estado do Acre', 'logo' => '/images/partners/governo-acre.svg', 'url' => 'https://acre.gov.br', 'order' => 4],
            ['name' => 'Universidade Federal do Acre (UFAC)', 'logo' => '/images/partners/ufac.svg', 'url' => 'https://ufac.br', 'order' => 5],
            ['name' => 'Exército Brasileiro', 'logo' => '/images/partners/exercito.svg', 'url' => null, 'order' => 6],
            ['name' => 'Carbon Crédito de Carbono', 'logo' => '/images/partners/carbon.svg', 'url' => null, 'order' => 7],
            ['name' => 'Churrascaria Sabor do Sul', 'logo' => '/images/partners/sabor-do-sul.svg', 'url' => null, 'order' => 8],
            ['name' => 'Distribuidora Aviário', 'logo' => '/images/partners/aviario.svg', 'url' => null, 'order' => 9],
            ['name' => 'Distribuidora Kanaã', 'logo' => '/images/partners/kanaa.svg', 'url' => null, 'order' => 10],
            ['name' => 'Restaurante Sabor Caipira', 'logo' => '/images/partners/sabor-caipira.svg', 'url' => null, 'order' => 11],
            ['name' => 'Restaurante do Pastor', 'logo' => '/images/partners/restaurante-pastor.svg', 'url' => null, 'order' => 12],
        ];

        foreach ($partners as $partner) {
            DB::table('partners')->updateOrInsert(
                ['name' => $partner['name']],
                array_merge($partner, ['is_active' => true, 'created_at' => now(), 'updated_at' => now()])
            );
        }
    }
}
