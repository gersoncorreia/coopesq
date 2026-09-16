<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Services\HtmlSanitizer;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PostAdminController extends Controller
{
    public function index()
    {
        return response()->json(Post::with('category')->orderBy('id', 'desc')->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:posts,slug',
            'category_id' => 'nullable|exists:categories,id',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|string|max:1000',
            'is_published' => 'boolean',
            'published_at' => 'nullable|date',
            'meta_description' => 'nullable|string|max:300',
        ]);

        $validated['slug'] = !empty($validated['slug']) 
            ? Str::slug($validated['slug']) 
            : Str::slug($validated['title']);

        $validated['content'] = HtmlSanitizer::clean($validated['content']);
        $validated['author_id'] = $request->user()?->id ?? 1;
        $validated['is_published'] = $request->boolean('is_published', true);

        $post = Post::create($validated);
        return response()->json($post, 201);
    }

    public function show($id)
    {
        return response()->json(Post::with('category')->findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('posts')->ignore($post->id)],
            'category_id' => 'nullable|exists:categories,id',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|string|max:1000',
            'is_published' => 'boolean',
            'published_at' => 'nullable|date',
            'meta_description' => 'nullable|string|max:300',
        ]);

        if (!empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['slug']);
        }

        $validated['content'] = HtmlSanitizer::clean($validated['content']);
        $validated['is_published'] = $request->boolean('is_published');

        $post->update($validated);
        return response()->json($post);
    }

    public function destroy($id)
    {
        Post::destroy($id);
        return response()->json(['message' => 'Post excluído com sucesso!']);
    }
}
