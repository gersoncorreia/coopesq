<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SettingsSeeder extends Seeder
{
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

        $settings = [
            ['key' => 'site_name', 'value' => 'COOPESQ', 'group' => 'general'],
            ['key' => 'site_tagline', 'value' => 'Promovendo o desenvolvimento sustentável e a piscicultura de excelência na Amazônia', 'group' => 'general'],
            ['key' => 'mission', 'value' => 'Promover o desenvolvimento sustentável, social e familiar da agricultura e piscicultura através da produção e comercialização de produtos de alta qualidade, gerando renda e melhorando a qualidade de vida dos nossos cooperados e suas comunidades.', 'group' => 'general'],
            ['key' => 'vision', 'value' => 'Ser referência mundial em produção, comercialização de produtos e serviços da nossa fruticultura e piscicultura, reconhecido pela excelência dos nossos produtos e pelo compromisso com a sustentabilidade e inovação voltados ao meio ambiente.', 'group' => 'general'],
            ['key' => 'values', 'value' => 'Compromisso em atender com qualidade nossos cooperados, clientes e parceiros. Organização com as práticas que respeitem o meio ambiente. Oportunidade de levar a Amazônia para o mundo. Profissionalismo, Ética, Transparência, Responsabilidade e Solidariedade.', 'group' => 'general'],
            ['key' => 'phone_primary', 'value' => '(61) 99576-3665', 'group' => 'contacts'],
            ['key' => 'phone_secondary', 'value' => '(69) 99954-7575', 'group' => 'contacts'],
            ['key' => 'phone_tertiary', 'value' => '(68) 99927-4776', 'group' => 'contacts'],
            ['key' => 'email', 'value' => 'coopesqcooperativa@gmail.com', 'group' => 'contacts'],
            ['key' => 'address', 'value' => 'Porto Acre - AC, Brasil', 'group' => 'contacts'],
            ['key' => 'instagram', 'value' => '@coopesq', 'group' => 'socials'],
            ['key' => 'instagram_url', 'value' => 'https://instagram.com/coopesq', 'group' => 'socials'],
            ['key' => 'meta_title', 'value' => 'COOPESQ - Cooperativa de Piscicultura e Produtos Naturais', 'group' => 'seo'],
            ['key' => 'meta_description', 'value' => 'Cooperativa agropecuária de Porto Acre dedicada à produção sustentável de pescados amazônicos, frutas regionais, raízes e verduras.', 'group' => 'seo'],
            ['key' => 'meta_keywords', 'value' => 'piscicultura, amazonia, tambaqui, coopesq, acre, porto acre, frutas regionais, agricultura familiar, producao sustentavel', 'group' => 'seo'],
            ['key' => 'site_logo', 'value' => '/storage/uploads/kfwa91Dvu7vzsnKZJrlMSD9nyV9Wwz7jpPmAeLNu.png', 'group' => 'general'],
            ['key' => 'site_favicon', 'value' => '/storage/uploads/Mldq1LQn1DsokRK3uRvJsONPSK2G2js4vcCHkkYf.png', 'group' => 'general'],
            ['key' => 'site_logo_header', 'value' => '/storage/uploads/kfwa91Dvu7vzsnKZJrlMSD9nyV9Wwz7jpPmAeLNu.png', 'group' => 'general'],
            ['key' => 'site_logo_footer', 'value' => '/storage/uploads/C01M0WI0gLZAc66VnkcmzncLVvdxFG2GbFM7daGL.png', 'group' => 'general'],
            ['key' => 'about_image', 'value' => '/storage/uploads/ghk8qFXUKPTu9zT3MQ0Z7UKm7a0IJsIKZMl8H4hH.png', 'group' => 'general'],
        ];

        foreach ($settings as $setting) {
            DB::table('settings')->updateOrInsert(
                ['key' => $setting['key']],
                array_merge($setting, ['created_at' => now(), 'updated_at' => now()])
            );
        }
    }
}
