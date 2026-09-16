<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use App\Services\HtmlSanitizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PartnerAdminController extends Controller
{
    public function index()
    {
        return response()->json(Partner::orderBy('order', 'asc')->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'required|string|max:1000',
            'url' => 'nullable|string|max:1000',
            'is_active' => 'boolean',
            'order' => 'nullable|integer|min:0',
        ]);

        $validated['url'] = HtmlSanitizer::cleanUrl($validated['url'] ?? null);
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['order'] = $validated['order'] ?? 0;

        $partner = Partner::create($validated);
        Cache::forget('coopesq_partners');
        return response()->json($partner, 201);
    }

    public function show($id)
    {
        return response()->json(Partner::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $partner = Partner::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'required|string|max:1000',
            'url' => 'nullable|string|max:1000',
            'is_active' => 'boolean',
            'order' => 'nullable|integer|min:0',
        ]);

        $validated['url'] = HtmlSanitizer::cleanUrl($validated['url'] ?? null);
        $validated['is_active'] = $request->boolean('is_active');

        $partner->update($validated);
        Cache::forget('coopesq_partners');
        return response()->json($partner);
    }

    public function destroy($id)
    {
        Partner::destroy($id);
        Cache::forget('coopesq_partners');
        return response()->json(['message' => 'Parceiro excluído com sucesso!']);
    }
}
