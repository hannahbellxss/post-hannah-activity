<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/payroll', [App\Http\Controllers\HumanResourcePayrollController::class, 'payroll']);
Route::post('/payroll/calculate', [PayrollController::class, 'calculate']);
Route::apiResource('products', ProductController::class);
Route::get('/v1/categories', [CategoryController::class, 'index']);
Route::apiResource('/posts', PostController::class);