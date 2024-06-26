<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EnrolleeController;
use App\Http\Controllers\HcpController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/hcps/get/{organisation_id}', [HcpController::class, 'getByOrganisation']);
Route::get('/categories/get/{branch_id}', [CategoryController::class,'getByBranch']);
Route::get('/enrollment-data', [EnrolleeController::class, 'enrollmentData'])->name('enrollment_data');
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
