<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class TestimonialAdminController extends Controller
{
    public function index()
    {
        return response()->json(Testimonial::orderBy('order', 'asc')->get());
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $testimonial = Testimonial::create($data);
        Cache::forget('coopesq_testimonials');
        return response()->json($testimonial, 201);
    }

    public function show($id)
    {
        return response()->json(Testimonial::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $testimonial = Testimonial::findOrFail($id);
        $data = $this->validateData($request);
        $testimonial->update($data);
        Cache::forget('coopesq_testimonials');
        return response()->json($testimonial);
    }

    public function destroy($id)
    {
        Testimonial::destroy($id);
        Cache::forget('coopesq_testimonials');
        return response()->json(['message' => 'Depoimento excluído com sucesso!']);
    }

    private function validateData(Request $request): array
    {
        $validated = $request->validate([
            'name' => 'required|string|max:191',
            'role' => 'nullable|string|max:191',
            'content' => 'required|string|max:2000',
            'image' => 'nullable|string|max:500',
            'is_active' => 'nullable|boolean',
            'order' => 'nullable|integer',
        ]);

        $validated['name'] = strip_tags($validated['name']);
        $validated['role'] = !empty($validated['role']) ? strip_tags($validated['role']) : null;
        $validated['content'] = strip_tags($validated['content']);

        return $validated;
    }
}
