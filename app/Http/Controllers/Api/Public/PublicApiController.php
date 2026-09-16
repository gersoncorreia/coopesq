<?php

namespace App\Http\Controllers\Api\Public;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\Page;
use App\Models\Product;
use App\Models\Post;
use App\Models\Partner;
use App\Models\Differential;
use App\Models\HeroBanner;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PublicApiController extends Controller
{
    public function settings()
    {
        $data = Cache::remember('coopesq_public_settings', 3600, function () {
            $settings = Setting::all();
            return [
                'general' => $settings->where('group', 'general')->pluck('value', 'key')->toArray(),
                'contacts' => $settings->where('group', 'contacts')->pluck('value', 'key')->toArray(),
                'socials' => $settings->where('group', 'socials')->pluck('value', 'key')->toArray(),
                'seo' => $settings->where('group', 'seo')->pluck('value', 'key')->toArray(),
            ];
        });

        return response()->json($data);
    }

    public function page($slug)
    {
        $page = Cache::remember("coopesq_page_{$slug}", 3600, fn() =>
            Page::where('slug', $slug)->where('is_active', true)->first()?->toArray()
        );

        abort_if(!$page, 404);
        return response()->json($page);
    }

    public function products(Request $request)
    {
        $query = Product::with('category')->where('is_active', true)->orderBy('order', 'asc');

        if ($request->has('category') && $request->category !== 'all') {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }

        return response()->json($query->paginate(12));
    }

    public function product($slug)
    {
        $product = Product::with('category')->where('slug', $slug)->where('is_active', true)->firstOrFail();
        return response()->json($product);
    }

    public function posts(Request $request)
    {
        $query = Post::with(['category', 'author:id,name'])->where('is_published', true)->orderBy('published_at', 'desc');

        if ($request->filled('category') && $request->category !== 'all') {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(fn($q) =>
                $q->where('title', 'like', "%{$search}%")->orWhere('excerpt', 'like', "%{$search}%")
            );
        }

        return response()->json($query->paginate(6));
    }

    public function post(Request $request, $slug)
    {
        $post = Post::with(['category', 'author:id,name'])->where('slug', $slug)->where('is_published', true)->firstOrFail();

        $cacheKey = 'post_view_' . $post->id . '_' . md5($request->ip());
        if (Cache::add($cacheKey, true, now()->addHour())) {
            $post->increment('views');
        }

        return response()->json($post);
    }

    public function partners()
    {
        $data = Cache::remember('coopesq_partners', 3600, fn() =>
            Partner::where('is_active', true)->orderBy('order', 'asc')->get()->toArray()
        );
        return response()->json($data);
    }

    public function differentials()
    {
        $data = Cache::remember('coopesq_differentials', 3600, fn() =>
            Differential::where('is_active', true)->orderBy('order', 'asc')->get()->toArray()
        );
        return response()->json($data);
    }

    public function banners()
    {
        $data = Cache::remember('coopesq_banners', 3600, fn() =>
            HeroBanner::where('is_active', true)->orderBy('order', 'asc')->get()->toArray()
        );
        return response()->json($data);
    }

    public function testimonials()
    {
        $data = Cache::remember('coopesq_testimonials', 3600, fn() =>
            Testimonial::where('is_active', true)->orderBy('order', 'asc')->get()->toArray()
        );
        return response()->json($data);
    }
}
