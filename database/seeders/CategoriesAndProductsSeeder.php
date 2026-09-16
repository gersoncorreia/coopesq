<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesAndProductsSeeder extends Seeder
{
    public function run(): void
    {
        $ensureCategory = function ($name, $slug, $type, $description) {
            DB::table('categories')->updateOrInsert(
                ['slug' => $slug],
                ['name' => $name, 'type' => $type, 'description' => $description, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()]
            );
            return DB::table('categories')->where('slug', $slug)->value('id');
        };

        $pisciculturaCat = $ensureCategory('Piscicultura', 'piscicultura', 'product', 'Peixes frescos e processados da bacia amazônica com rigoroso controle de qualidade.');
        $frutasCat = $ensureCategory('Frutas Regionais', 'frutas-regionais', 'product', 'Frutas cultivadas com sustentabilidade no solo fértil da região.');
        $raizesCat = $ensureCategory('Raízes', 'raizes', 'product', 'Mandioca, macaxeira e tubérculos selecionados.');
        $verdurasCat = $ensureCategory('Verduras e Hortaliças', 'verduras-e-hortalicas', 'product', 'Hortaliças frescas da agricultura familiar local.');
        $ensureCategory('Notícias e Eventos', 'noticias-e-eventos', 'post', 'Informativos e matérias sobre a COOPESQ e a piscicultura regional.');

        $products = [
            ['category_id' => $pisciculturaCat, 'name' => 'Filé de Peixe Fresco (Tambaqui / Pintado)', 'slug' => 'file-de-peixe-fresco', 'description' => 'Cortes nobres limpos e embalados com total rastreabilidade e garantia de frescor.', 'order' => 1],
            ['category_id' => $frutasCat, 'name' => 'Melão Amarelo Regional', 'slug' => 'melao-amarelo-regional', 'description' => 'Cultivado sob o sol da Amazônia, doce e suculento.', 'order' => 2],
            ['category_id' => $frutasCat, 'name' => 'Melancia Doce', 'slug' => 'melancia-doce', 'description' => 'Melancias de altíssimo padrão com polpa vermelha e saborosa.', 'order' => 3],
            ['category_id' => $frutasCat, 'name' => 'Manga Palmer / Rosa', 'slug' => 'manga-palmer-rosa', 'description' => 'Mangas selecionadas colhidas no ponto ideal de maturação.', 'order' => 4],
            ['category_id' => $frutasCat, 'name' => 'Abacaxi Pérola', 'slug' => 'abacaxi-perola', 'description' => 'Abacaxi pérola da região, ideal para consumo in natura ou sucos.', 'order' => 5],
            ['category_id' => $frutasCat, 'name' => 'Mamão Formosa', 'slug' => 'mamao-formosa', 'description' => 'Mamão rico em vitaminas, produzido por cooperados.', 'order' => 6],
            ['category_id' => $frutasCat, 'name' => 'Coco Verde', 'slug' => 'coco-verde', 'description' => 'Água de coco natural e refrescante.', 'order' => 7],
            ['category_id' => $frutasCat, 'name' => 'Banana da Terra e Prata', 'slug' => 'banana-da-terra-e-prata', 'description' => 'Bananas frescas ideais para culinária típica e consumo diário.', 'order' => 8],
            ['category_id' => $frutasCat, 'name' => 'Café Regional Selecionado', 'slug' => 'cafe-regional-selecionado', 'description' => 'Grãos selecionados com torra artesanal amazônica.', 'order' => 9],
            ['category_id' => $frutasCat, 'name' => 'Uva de Mesa', 'slug' => 'uva-de-mesa', 'description' => 'Uvas frescas com sabor intenso e doçura natural.', 'order' => 10],
            ['category_id' => $raizesCat, 'name' => 'Mandioca / Macaxeira de Mesa', 'slug' => 'mandioca-macaxeira-de-mesa', 'description' => 'Mandioca de cozimento rápido, colhida no dia.', 'order' => 11],
            ['category_id' => $verdurasCat, 'name' => 'Abóbora / Jerimum', 'slug' => 'abobora-jerimum', 'description' => 'Abóbora regional macia e perfeita para pratos doces e salgados.', 'order' => 12],
            ['category_id' => $verdurasCat, 'name' => 'Pimenta de Cheiro e Pimentões', 'slug' => 'pimenta-de-cheiro-e-pimentoes', 'description' => 'Especiarias e pimentas típicas com aroma inconfundível.', 'order' => 13],
            ['category_id' => $verdurasCat, 'name' => 'Hortaliças e Verdura Fresca', 'slug' => 'hortalicas-e-verdura-fresca', 'description' => 'Alface, cheiro-verde, couve e temperos verdes colhidos artesanalmente.', 'order' => 14],
        ];

        foreach ($products as $prod) {
            DB::table('products')->updateOrInsert(
                ['slug' => $prod['slug']],
                array_merge($prod, ['is_active' => true, 'created_at' => now(), 'updated_at' => now()])
            );
        }
    }
}
