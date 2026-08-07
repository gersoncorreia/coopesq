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
        return response()->json(Testimonial::all());
    }

    public function store(Request $request)
    {
        $testimonial = Testimonial::create($request->all());
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
        $testimonial->update($request->all());
        Cache::forget('coopesq_testimonials');
        return response()->json($testimonial);
    }

    public function destroy($id)
    {
        Testimonial::destroy($id);
        Cache::forget('coopesq_testimonials');
        return response()->json(['message' => 'Deleted']);
    }
}
