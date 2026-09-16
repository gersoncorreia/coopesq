<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\Page;
use App\Models\Product;
use App\Models\Post;
use App\Models\Partner;
use App\Models\Differential;
use App\Models\HeroBanner;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class AdminApiController extends Controller
{
    /**
     * Dashboard statistics and recent activities.
     */
    public function stats()
    {
        $totalProducts = Product::count();
        $activeProducts = Product::where('is_active', true)->count();
        $totalPosts = Post::count();
        $publishedPosts = Post::where('is_published', true)->count();
        $totalPartners = Partner::count();
        $totalBanners = HeroBanner::where('is_active', true)->count();
        $totalTestimonials = Testimonial::where('is_active', true)->count();
        $totalPostViews = Post::sum('views');

        // Últimos produtos cadastrados
        $recentProducts = Product::with('category')
            ->orderBy('id', 'desc')
            ->limit(4)
            ->get(['id', 'name', 'category_id', 'is_active', 'created_at']);

        // Últimos posts publicados
        $recentPosts = Post::with('category')
            ->orderBy('id', 'desc')
            ->limit(4)
            ->get(['id', 'title', 'slug', 'category_id', 'is_published', 'views', 'created_at']);

        return response()->json([
            'total_products' => $totalProducts,
            'active_products' => $activeProducts,
            'total_posts' => $totalPosts,
            'published_posts' => $publishedPosts,
            'total_partners' => $totalPartners,
            'total_banners' => $totalBanners,
            'total_testimonials' => $totalTestimonials,
            'total_post_views' => $totalPostViews,
            'recent_products' => $recentProducts,
            'recent_posts' => $recentPosts,
            'system_info' => [
                'php_version' => PHP_VERSION,
                'laravel_version' => app()->version(),
                'server_time' => now()->format('d/m/Y H:i'),
            ]
        ]);
    }


    /**
     * Update settings in bulk.
     */
    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'settings' => 'required|array',
            'settings.*.key' => 'required|string',
            'settings.*.value' => 'nullable',
            'settings.*.group' => 'required|string',
        ]);

        foreach ($validated['settings'] as $item) {
            Setting::updateOrCreate(
                ['key' => $item['key']],
                [
                    'value' => array_key_exists('value', $item) ? $item['value'] : null,
                    'group' => $item['group']
                ]
            );
        }

        Cache::forget('coopesq_public_settings');

        return response()->json(['message' => 'Configurações atualizadas com sucesso!']);
    }

    /**
     * Upload asset file with strict MIME validation.
     */
    public function upload(Request $request)
    {
        $request->validate([
            'file' => [
                'required',
                'file',
                'mimes:jpeg,png,jpg,webp,svg,ico',
                'mimetypes:image/jpeg,image/png,image/webp,image/svg+xml,image/x-icon,image/vnd.microsoft.icon',
                'max:4096'
            ],
        ]);

        $file = $request->file('file');

        if (in_array(strtolower($file->getClientOriginalExtension()), ['svg', 'svgz']) || $file->getMimeType() === 'image/svg+xml') {
            $content = file_get_contents($file->getRealPath());
            if (preg_match('/<script|onload|onerror|onclick|onmouseover|javascript:|data:text\/html/i', $content)) {
                return response()->json([
                    'message' => 'O arquivo SVG contém scripts ou elementos executáveis não permitidos por segurança.'
                ], 422);
            }
        }

        $path = $file->store('uploads', 'public');
        $relativeUrl = '/storage/' . $path;

        return response()->json([
            'path' => $relativeUrl,
            'url' => $relativeUrl,
        ]);
    }


}
