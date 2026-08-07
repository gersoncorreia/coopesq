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
     * Dashboard statistics.
     */
    public function stats()
    {
        return response()->json([
            'total_products' => Product::count(),
            'total_posts' => Post::count(),
            'published_posts' => Post::where('is_published', true)->count(),
            'total_partners' => Partner::count(),
            'total_post_views' => Post::sum('views'),
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
            'settings.*.value' => 'nullable|string',
            'settings.*.group' => 'required|string',
        ]);

        foreach ($validated['settings'] as $item) {
            Setting::updateOrCreate(
                ['key' => $item['key']],
                ['value' => $item['value'], 'group' => $item['group']]
            );
        }

        Cache::forget('coopesq_public_settings');

        return response()->json(['message' => 'Configurações atualizadas com sucesso!']);
    }

    /**
     * Upload asset file.
     */
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,webp,svg|max:4096',
        ]);

        $path = $request->file('file')->store('uploads', 'public');
        $url = asset('storage/' . $path);

        return response()->json([
            'path' => '/storage/' . $path,
            'url' => $url,
        ]);
    }
}
