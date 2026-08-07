<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin User
        DB::table('users')->updateOrInsert(
            ['email' => 'admin@coopesq.com.br'],
            [
                'name' => 'COOPESQ Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // Settings (Whitelabel Global Configurations)
        $settings = [
            // General
            ['key' => 'site_name', 'value' => 'COOPESQ - Cooperativa de Piscicultura e Produtos Naturais da Amazônia', 'group' => 'general'],
            ['key' => 'site_tagline', 'value' => 'Promovendo o desenvolvimento sustentável e a piscicultura de excelência na Amazônia', 'group' => 'general'],
            ['key' => 'mission', 'value' => 'Promover o desenvolvimento sustentável, social e familiar da agricultura e piscicultura através da produção e comercialização de produtos de alta qualidade, gerando renda e melhorando a qualidade de vida dos nossos cooperados e suas comunidades.', 'group' => 'general'],
            ['key' => 'vision', 'value' => 'Ser referência mundial em produção, comercialização de produtos e serviços da nossa fruticultura e piscicultura, reconhecido pela excelência dos nossos produtos e pelo compromisso com a sustentabilidade e inovação voltados ao meio ambiente.', 'group' => 'general'],
            ['key' => 'values', 'value' => 'Compromisso em atender com qualidade nossos cooperados, clientes e parceiros. Organização com as práticas que respeitem o meio ambiente. Oportunidade de levar a Amazônia para o mundo. Profissionalismo, Ética, Transparência, Responsabilidade e Solidariedade.', 'group' => 'general'],
            
            // Contacts
            ['key' => 'phone_primary', 'value' => '(61) 99576-3665', 'group' => 'contacts'],
            ['key' => 'phone_secondary', 'value' => '(69) 99954-7575', 'group' => 'contacts'],
            ['key' => 'phone_tertiary', 'value' => '(68) 99927-4776', 'group' => 'contacts'],
            ['key' => 'email', 'value' => 'coopesqcooperativa@gmail.com', 'group' => 'contacts'],
            ['key' => 'address', 'value' => 'Porto Acre - AC, Brasil', 'group' => 'contacts'],

            // Socials
            ['key' => 'instagram', 'value' => '@coopesq', 'group' => 'socials'],
            ['key' => 'instagram_url', 'value' => 'https://instagram.com/coopesq', 'group' => 'socials'],

            // SEO
            ['key' => 'meta_title', 'value' => 'COOPESQ - Cooperativa de Piscicultura e Produtos Naturais', 'group' => 'seo'],
            ['key' => 'meta_description', 'value' => 'Cooperativa agropecuária de Porto Acre dedicada à produção sustentável de pescados amazônicos, frutas regionais, raízes e verduras.', 'group' => 'seo'],
            ['key' => 'meta_keywords', 'value' => 'piscicultura, amazonia, tambaqui, coopesq, acre, porto acre, frutas regionais, agricultura familiar, producao sustentavel', 'group' => 'seo'],
        ];

        foreach ($settings as $setting) {
            DB::table('settings')->updateOrInsert(
                ['key' => $setting['key']],
                array_merge($setting, ['created_at' => now(), 'updated_at' => now()])
            );
        }

        // Differentials
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

        // Categories helper
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
        $noticiasCat = $ensureCategory('Notícias e Eventos', 'noticias-e-eventos', 'post', 'Informativos e matérias sobre a COOPESQ e a piscicultura regional.');

        // Products
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

        // Partners
        $partners = [
            ['name' => 'Prefeitura de Rio Branco', 'logo' => '/images/partners/rio-branco.png', 'url' => 'https://riobranco.ac.gov.br', 'order' => 1],
            ['name' => 'Prefeitura de Senador Guiomard', 'logo' => '/images/partners/senador-guiomard.png', 'url' => null, 'order' => 2],
            ['name' => 'Prefeitura de Bujari', 'logo' => '/images/partners/bujari.png', 'url' => null, 'order' => 3],
            ['name' => 'Governo do Estado do Acre', 'logo' => '/images/partners/governo-acre.png', 'url' => 'https://acre.gov.br', 'order' => 4],
            ['name' => 'Universidade Federal do Acre (UFAC)', 'logo' => '/images/partners/ufac.png', 'url' => 'https://ufac.br', 'order' => 5],
            ['name' => 'Exército Brasileiro', 'logo' => '/images/partners/exercito.png', 'url' => null, 'order' => 6],
            ['name' => 'Carbon Crédito de Carbono', 'logo' => '/images/partners/carbon.png', 'url' => null, 'order' => 7],
            ['name' => 'Churrascaria Sabor do Sul', 'logo' => '/images/partners/sabor-do-sul.png', 'url' => null, 'order' => 8],
            ['name' => 'Distribuidora Aviário', 'logo' => '/images/partners/aviario.png', 'url' => null, 'order' => 9],
            ['name' => 'Distribuidora Kanaã', 'logo' => '/images/partners/kanaa.png', 'url' => null, 'order' => 10],
            ['name' => 'Restaurante Sabor Caipira', 'logo' => '/images/partners/sabor-caipira.png', 'url' => null, 'order' => 11],
            ['name' => 'Restaurante do Pastor', 'logo' => '/images/partners/restaurante-pastor.png', 'url' => null, 'order' => 12],
        ];

        foreach ($partners as $partner) {
            DB::table('partners')->updateOrInsert(
                ['name' => $partner['name']],
                array_merge($partner, ['is_active' => true, 'created_at' => now(), 'updated_at' => now()])
            );
        }

        // Hero Banner
        DB::table('hero_banners')->updateOrInsert(
            ['order' => 1],
            [
                'title' => 'Fortalecendo a Piscicultura e Agricultura na Amazônia',
                'subtitle' => 'Unindo produtores para entregar produtos sustentáveis e de altíssima qualidade diretamente de Porto Acre para todo o mercado.',
                'image' => '/images/hero/amazon-river.jpg',
                'cta_text' => 'Conheça Nossos Produtos',
                'cta_url' => '#produtos',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

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

        // Posts (Blog)
        DB::table('posts')->updateOrInsert(
            ['slug' => 'coopesq-expande-parceria-com-restaurantes-e-distribuidores-no-acre'],
            [
                'category_id' => $noticiasCat,
                'author_id' => 1,
                'title' => 'COOPESQ expande parceria com restaurantes e distribuidores no Acre',
                'excerpt' => 'Cooperativa agropecuária de Porto Acre consolida fornecimento contínuo de pescado fresco e hortifruti para o setor alimentício regional.',
                'content' => '<p>A COOPESQ segue avançando na consolidação da marca de piscicultura e produtos naturais da Amazônia. Com a ampliação de parcerias com restaurantes, hotéis e grandes redes de distribuição, nossos associados ganham segurança e escala na produção.</p><p>O compromisso com o cultivo sustentável e a rastreabilidade sociambiental permanecem no centro de nossas diretrizes corporativas.</p>',
                'featured_image' => '/images/blog/expansao.jpg',
                'is_published' => true,
                'published_at' => now(),
                'meta_description' => 'Parceria da COOPESQ com restaurantes e distribuidores regionais fortalece a economia da piscicultura em Porto Acre.',
                'views' => 42,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
