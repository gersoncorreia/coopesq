<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroBanner;
use App\Services\HtmlSanitizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class BannerAdminController extends Controller
{
    public function index()
    {
        return response()->json(HeroBanner::orderBy('order', 'asc')->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:500',
            'image' => 'required|string|max:1000',
            'cta_text' => 'nullable|string|max:100',
            'cta_url' => 'nullable|string|max:1000',
            'is_active' => 'boolean',
            'order' => 'nullable|integer|min:0',
        ]);

        $validated['cta_url'] = HtmlSanitizer::cleanUrl($validated['cta_url'] ?? null);
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['order'] = $validated['order'] ?? 0;

        $banner = HeroBanner::create($validated);
        Cache::forget('coopesq_banners');
        return response()->json($banner, 201);
    }

    public function show($id)
    {
        return response()->json(HeroBanner::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $banner = HeroBanner::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:500',
            'image' => 'required|string|max:1000',
            'cta_text' => 'nullable|string|max:100',
            'cta_url' => 'nullable|string|max:1000',
            'is_active' => 'boolean',
            'order' => 'nullable|integer|min:0',
        ]);

        $validated['cta_url'] = HtmlSanitizer::cleanUrl($validated['cta_url'] ?? null);
        $validated['is_active'] = $request->boolean('is_active');

        $banner->update($validated);
        Cache::forget('coopesq_banners');
        return response()->json($banner);
    }

    public function destroy($id)
    {
        HeroBanner::destroy($id);
        Cache::forget('coopesq_banners');
        return response()->json(['message' => 'Banner excluído com sucesso!']);
    }
}
