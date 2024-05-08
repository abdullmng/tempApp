<?php

use App\Http\Controllers\AccessController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EnrolleeController;
use App\Http\Controllers\HcpController;
use App\Http\Controllers\HmoController;
use App\Http\Controllers\OrganisationController;
use App\Http\Controllers\SectorController;
use App\Http\Controllers\UserController;
use Carbon\Carbon;
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

Route::get('/forgot', [UserController::class, 'forgot'])->name('password.request');
Route::post('/forgot', [UserController::class,'requestPasswordReset'])->name('password.email');
Route::get('/reset-password/{token}', [UserController::class, 'passwordReset'])->middleware('guest')->name('password.reset');
Route::post('/reset-password/{token}', [UserController::class, 'updatePassword'])->middleware('guest')->name('password.update');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', [UserController::class,'dashboard'])->name('user.dashboard');
    
    Route::group([], function () {
        Route::get('enrollees', [EnrolleeController::class,'index'])->name('user.enrollees')->middleware('can:can_view_enrollees');
        Route::post('/enrollees', [EnrolleeController::class,'store'])->name('store')->middleware('can:can_create_enrollees');
        Route::get('enrollee/{id}', [EnrolleeController::class, 'show'])->name('user.enrollee')->middleware('can:can_edit_enrollees');;
        Route::post('enrollee/{id}', [EnrolleeController::class, 'update'])->name('user.update_enrollee')->middleware('can:can_edit_enrollees');
        Route::post('enrollees/import', [EnrolleeController::class, 'storeImport'])->name('enrollee.store_import')->middleware('can:can_bulk_import_enrollees');
        Route::get('enrollees/import/template', [EnrolleeController::class, 'downloadTemplate'])->name('enrollee.download')->middleware('can:can_bulk_import_enrollees');
        Route::get('/enrollees/slip/print/{id}', [EnrolleeController::class, 'printSlip'])->name('enrollee.print_slip')->middleware('can:can_print_enrollee_slip');
        Route::get('/enrollees/idcard/print/{id}', [EnrolleeController::class, 'printIdCard'])->name('enrollee.print_id')->middleware('can:can_print_enrollee_id_card');
        Route::get('/enrollees/raw/export', [EnrolleeController::class, 'rawExportView'])->name('enrollee.raw_export')->middleware('can:can_raw_export');
        Route::post('/enrollees/raw/export', [EnrolleeController::class, 'rawExport'])->name('enrollee.raw_export_download')->middleware('can:can_raw_export');
        Route::get('/enrollee/raw/import', [EnrolleeController::class, 'rawImportView'])->name('enrollee.raw_import')->middleware('can:can_raw_import');
        Route::post('/enrollee/raw/import', [EnrolleeController::class, 'rawImport'])->name('enrollee.raw_import_data')->middleware('can:can_raw_import');
    });

    Route::group(['prefix' => 'branches'], function () {
        Route::get('/', [BranchController::class,'index'])->name('branch.index')->middleware('can:can_view_branches');
        Route::post('/', [BranchController::class,'store'])->name('branch.store')->middleware('can:can_create_branches');
        Route::get('/{id}', [BranchController::class, 'show'])->name('branch.show')->middleware('can:can_edit_branches');
        Route::post('/{id}', [BranchController::class, 'update'])->name('branch.update')->middleware('can:can_edit_branches');
        Route::get('/delete/{id}', [BranchController::class, 'delete'])->name('branch.delete')->middleware('can:can_delete_branches');
    });
    Route::group(['prefix' => 'organisations'], function () {
        Route::get('/', [OrganisationController::class, 'index'])->name('organisation.index')->middleware('can:can_view_organisations');
        Route::post('/', [OrganisationController::class,'store'])->name('organisation.store')->middleware('can:can_create_organisations');
        Route::get('/{id}', [OrganisationController::class, 'show'])->name('organisation.show')->middleware('can:can_edit_organisations');
        Route::post('/{id}', [OrganisationController::class, 'update'])->name('organisation.update')->middleware('can:can_edit_organisations');
        Route::get('/delete/{id}', [OrganisationController::class, 'delete'])->name('organisation.delete')->middleware('can:can_delete_organisations');
    });

    Route::group(['prefix' => 'hcps'], function () {
        Route::get('/', [HcpController::class, 'index'])->name('hcp.index')->middleware('can:can_view_hcps');
        Route::post('/', [HcpController::class,'store'])->name('hcp.store')->middleware('can:can_create_hcps');
        Route::get('/{id}', [HcpController::class, 'show'])->name('hcp.show')->middleware('can:can_edit_hcps');
        Route::post('/{id}', [HcpController::class, 'update'])->name('hcp.update')->middleware('can:can_edit_hcps');
        Route::get('/delete/{id}', [HcpController::class, 'delete'])->name('hcp.delete')->middleware('can:can_delete_hcps');
    });

    Route::group(['prefix' => 'sectors'], function () {
        Route::get('/', [SectorController::class, 'index'])->name('sector.index')->middleware('can:can_view_sectors');
        Route::post('/', [SectorController::class,'store'])->name('sector.store')->middleware('can:can_create_sectors');
        Route::get('/{id}', [SectorController::class, 'show'])->name('sector.show')->middleware('can:can_edit_sectors');
        Route::post('/{id}', [SectorController::class, 'update'])->name('sector.update')->middleware('can:can_edit_sectors');
        Route::get('/delete/{id}', [SectorController::class, 'delete'])->name('sector.delete')->middleware('can:can_delete_sectors');
    });

    Route::group(['prefix'=> 'categories'], function () {
        Route::get('/', [CategoryController::class, 'index'])->name('category.index')->middleware('can:can_view_categories');
        Route::post('/', [CategoryController::class,'store'])->name('category.store')->middleware('can:can_create_categories');
        Route::get('/{id}', [CategoryController::class, 'show'])->name('category.show')->middleware('can:can_edit_categories');
        Route::post('/{id}', [CategoryController::class, 'update'])->name('category.update')->middleware('can:can_edit_categories');
        Route::get('/delete/{id}', [CategoryController::class, 'delete'])->name('category.delete')->middleware('can:can_delete_categories');
    });

    Route::group(['prefix'=> 'users'], function () {
        Route::get('/', [UserController::class,'index'])->name('user.index')->middleware('can:can_view_users');
        Route::post('/', [UserController::class,'store'])->name('user.store')->middleware('can:can_create_users');
        Route::get('/{id}', [UserController::class, 'show'])->name('user.show')->middleware('can:can_edit_users');
        Route::post('/{id}', [UserController::class, 'update'])->name('user.update')->middleware('can:can_edit_users');
        Route::get('/delete/{id}', [UserController::class, 'delete'])->name('user.delete')->middleware('can:can_delete_users');
    });

    Route::group(['prefix'=> 'hmos'], function () {
        Route::get('/', [HmoController::class,'index'])->name('hmo.index')->middleware('can:can_view_hmos');
        Route::post('/', [HmoController::class, 'store'])->name('hmo.store')->middleware('can:can_create_hmos');
        Route::get('/{id}', [HmoController::class, 'show'])->name('hmo.show')->middleware('can:can_view_hmos');
        Route::post('/{id}', [HmoController::class,'update'])->name('hmo.update')->middleware('can:can_edit_hmos');
        Route::get('/delete/{id}', [HmoController::class, 'delete'])->name('hmo.delete')->middleware('can:can_delete_hmos');
    });

    Route::group(['prefix' => 'access'], function () {
        Route::group(['prefix' => 'roles'], function () {
            Route::get('/', [AccessController::class, 'index'])->name('access.index')->middleware('can:can_view_roles');
            Route::get('create', [AccessController::class, 'createRoles'])->name('access.create_roles')->middleware('can:can_create_roles');
            Route::post('create', [AccessController::class, 'storeRole'])->name('access.store_role')->middleware('can:can_create_roles');
            Route::get('show/{id}', [AccessController::class, 'showRole'])->name('access.show_role')->middleware('can:can_edit_roles');
            Route::post('show/{id}', [AccessController::class, 'updateRole'])->name('access.update_role')->middleware('can:can_edit_roles');
            Route::get('delete/{id}', [AccessController::class, 'deleteRole'])->name('access.delete_role')->middleware('can:can_delete_roles');
        });
    });

    Route::get('/reports', [UserController::class, 'reports'])->name('report.index')->middleware('can:can_view_reports');
    Route::post('/reports', [UserController::class, 'exportReports'])->name('report.export')->middleware('can:can_export_reports');

    Route::get('logout', [UserController::class,'logout'])->name('user.logout');
});
Route::get('enrollees/slip/verify/{id}', [EnrolleeController::class, 'verify'])->name('enrollee.verify');
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

/*Route::get('/calc', function () {
    $datestring =  '2024-04-28';
    $date = Carbon::parse($datestring);
    $daysadd = $date->addDays(130);
    return $enddate = $daysadd->format('Y-m-d');
});*/