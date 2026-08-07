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
    /**
     * Get grouped public settings.
     */
    public function settings()
    {
        $settings = Setting::all();

        return response()->json([
            'general' => $settings->where('group', 'general')->pluck('value', 'key')->toArray(),
            'contacts' => $settings->where('group', 'contacts')->pluck('value', 'key')->toArray(),
            'socials' => $settings->where('group', 'socials')->pluck('value', 'key')->toArray(),
            'seo' => $settings->where('group', 'seo')->pluck('value', 'key')->toArray(),
        ]);
    }

    /**
     * Get dynamic active page by slug.
     */
    public function page($slug)
    {
        $page = Page::where('slug', $slug)->where('is_active', true)->firstOrFail();
        return response()->json($page);
    }

    /**
     * Get paginated active products with category filtering.
     */
    public function products(Request $request)
    {
        $query = Product::with('category')->where('is_active', true)->orderBy('order', 'asc');

        if ($request->has('category') && $request->category !== 'all') {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        return response()->json($query->paginate(12));
    }

    /**
     * Get single product by slug.
     */
    public function product($slug)
    {
        $product = Product::with('category')->where('slug', $slug)->where('is_active', true)->firstOrFail();
        return response()->json($product);
    }

    /**
     * Get published blog posts.
     */
    public function posts(Request $request)
    {
        $query = Post::with(['category', 'author:id,name'])->where('is_published', true)->orderBy('published_at', 'desc');

        if ($request->has('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        return response()->json($query->paginate(6));
    }

    /**
     * Get single post by slug and increment views.
     */
    public function post($slug)
    {
        $post = Post::with(['category', 'author:id,name'])->where('slug', $slug)->where('is_published', true)->firstOrFail();
        $post->increment('views');
        return response()->json($post);
    }

    /**
     * Get active partners.
     */
    public function partners()
    {
        return response()->json(
            Partner::where('is_active', true)->orderBy('order', 'asc')->get()
        );
    }

    /**
     * Get active differentials.
     */
    public function differentials()
    {
        return response()->json(
            Differential::where('is_active', true)->orderBy('order', 'asc')->get()
        );
    }

    /**
     * Get active hero banners.
     */
    public function banners()
    {
        return response()->json(
            HeroBanner::where('is_active', true)->orderBy('order', 'asc')->get()
        );
    }

    /**
     * Get active testimonials.
     */
    public function testimonials()
    {
        return response()->json(
            Testimonial::where('is_active', true)->orderBy('order', 'asc')->get()
        );
    }
}
