<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Public\PublicApiController;
use App\Http\Controllers\Api\Admin\AdminApiController;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

/*
|--------------------------------------------------------------------------
| Public Whitelabel API Routes (Throttled against DoS/Scraping)
|--------------------------------------------------------------------------
*/
Route::middleware('throttle:60,1')->group(function () {
    Route::get('/settings', [PublicApiController::class, 'settings']);
    Route::get('/pages/{slug}', [PublicApiController::class, 'page']);
    Route::get('/products', [PublicApiController::class, 'products']);
    Route::get('/products/{slug}', [PublicApiController::class, 'product']);
    Route::get('/posts', [PublicApiController::class, 'posts']);
    Route::get('/posts/{slug}', [PublicApiController::class, 'post']);
    Route::get('/partners', [PublicApiController::class, 'partners']);
    Route::get('/differentials', [PublicApiController::class, 'differentials']);
    Route::get('/banners', [PublicApiController::class, 'banners']);
    Route::get('/testimonials', [PublicApiController::class, 'testimonials']);
});

/*
|--------------------------------------------------------------------------
| Admin Auth & Management API Routes
|--------------------------------------------------------------------------
*/
Route::post('/admin/login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['As credenciais fornecidas estão incorretas.'],
        ]);
    }

    $token = $user->createToken('admin-token')->plainTextToken;

    return response()->json([
        'token' => $token,
        'user' => [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
        ],
    ]);
})->middleware('throttle:5,1');

Route::middleware('auth:sanctum')->prefix('admin')->group(function () {
    // Logout endpoint to revoke current access token
    Route::post('/logout', function (Request $request) {
        if ($request->user()) {
            $request->user()->currentAccessToken()->delete();
        }
        return response()->json(['message' => 'Sessão encerrada com sucesso!']);
    });

    Route::get('/stats', [AdminApiController::class, 'stats']);
    Route::post('/settings', [AdminApiController::class, 'updateSettings']);
    Route::post('/upload', [AdminApiController::class, 'upload']);

    // Resource Endpoints (CRUD)
    Route::apiResource('pages', \App\Http\Controllers\Api\Admin\PageAdminController::class)->except(['create', 'edit']);
    Route::apiResource('products', \App\Http\Controllers\Api\Admin\ProductAdminController::class)->except(['create', 'edit']);
    Route::apiResource('posts', \App\Http\Controllers\Api\Admin\PostAdminController::class)->except(['create', 'edit']);
    Route::apiResource('partners', \App\Http\Controllers\Api\Admin\PartnerAdminController::class)->except(['create', 'edit']);
    Route::apiResource('banners', \App\Http\Controllers\Api\Admin\BannerAdminController::class)->except(['create', 'edit']);
    Route::apiResource('testimonials', \App\Http\Controllers\Api\Admin\TestimonialAdminController::class)->except(['create', 'edit']);
    
    // User management strictly restricted to admin role
    Route::apiResource('users', \App\Http\Controllers\Api\Admin\UserAdminController::class)
        ->except(['create', 'edit'])
        ->middleware('admin');
});

