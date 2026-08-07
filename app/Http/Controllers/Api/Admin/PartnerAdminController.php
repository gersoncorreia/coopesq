<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PartnerAdminController extends Controller
{
    public function index()
    {
        return response()->json(Partner::all());
    }

    public function store(Request $request)
    {
        $partner = Partner::create($request->all());
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
        $partner->update($request->all());
        Cache::forget('coopesq_partners');
        return response()->json($partner);
    }

    public function destroy($id)
    {
        Partner::destroy($id);
        Cache::forget('coopesq_partners');
        return response()->json(['message' => 'Deleted']);
    }
}
