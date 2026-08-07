<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class BannerAdminController extends Controller
{
    public function index()
    {
        return response()->json(HeroBanner::all());
    }

    public function store(Request $request)
    {
        $banner = HeroBanner::create($request->all());
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
        $banner->update($request->all());
        Cache::forget('coopesq_banners');
        return response()->json($banner);
    }

    public function destroy($id)
    {
        HeroBanner::destroy($id);
        Cache::forget('coopesq_banners');
        return response()->json(['message' => 'Deleted']);
    }
}
