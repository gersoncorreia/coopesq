<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Services\HtmlSanitizer;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PageAdminController extends Controller
{
    public function index()
    {
        return response()->json(Page::orderBy('order', 'asc')->get());
    }

    public function store(Request $request)
    {
        $data = $this->validateAndSanitize($request);

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        $page = Page::create($data);
        return response()->json($page, 201);
    }

    public function show($id)
    {
        return response()->json(Page::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $page = Page::findOrFail($id);
        $data = $this->validateAndSanitize($request, $page->id);

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        $page->update($data);
        return response()->json($page);
    }

    public function destroy($id)
    {
        Page::destroy($id);
        return response()->json(['message' => 'Página excluída com sucesso!']);
    }

    private function validateAndSanitize(Request $request, ?int $id = null): array
    {
        $slugRule = Rule::unique('pages', 'slug');
        if ($id) {
            $slugRule->ignore($id);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:191',
            'slug' => ['nullable', 'string', 'max:191', $slugRule],
            'content' => 'required|string',
            'meta_description' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
            'order' => 'nullable|integer',
        ]);

        $validated['content'] = HtmlSanitizer::clean($validated['content']);

        return $validated;
    }
}
