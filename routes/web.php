<?php

use App\Http\Controllers\EnrolleeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;
use function Spatie\LaravelPdf\Support\pdf;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect(route('login'));
});

Route::get('/login', [UserController::class, 'login'])->name('login');
Route::post('/login', [UserController::class,'authenticate'])->name('authenticate');


Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', [UserController::class,'dashboard'])->name('user.dashboard');
    Route::get('enrollees', [EnrolleeController::class,'index'])->name('user.enrollees');
    Route::post('/enrollees', [EnrolleeController::class,'store'])->name('store');
    Route::get('enrollee/{id}', [EnrolleeController::class, 'show'])->name('user.enrollee');
    Route::post('enrollee/{id}', [EnrolleeController::class, 'update'])->name('user.update_enrollee');
    Route::get('logout', [UserController::class,'logout'])->name('user.logout');
});

Route::get('/storage/uploads/{filename}', function ($filename)
{
    // Add folder path here instead of storing in the database.
    $path = storage_path('app/public/uploads/' . $filename);

    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);
    return $response;
});