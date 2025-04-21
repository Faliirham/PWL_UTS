<?php
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PerformanceController;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::get('/', [WelcomeController::class, 'index']);

// Route::get('login', [LoginController::class, 'showLogin'])->name('login')->middleware('guest');
// Route::post('login', [LoginController::class, 'login']);
// Route::post('logout', [LoginController::class, 'logout'])->name('logout');

//Route User
Route::group(['prefix' => 'user'], function () {
    Route::get('/', [UserController::class, 'index']);
    Route::post('/list', [UserController::class, 'list']);
    Route::get('/create', [UserController::class, 'create']);
    Route::post('/', [UserController::class, 'store']);
    Route::get('/create_ajax', [UserController::class, 'create_ajax']);
    Route::post('/ajax', [UserController::class, 'store_ajax']);
    Route::get('/{id}/show_ajax', [UserController::class, 'show_ajax']);
    Route::get('/{id}', [UserController::class, 'show']);
    Route::get('/{id}/edit', [UserController::class, 'edit']);
    Route::put('/{id}', [UserController::class, 'update']);
    Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [UserController::class, 'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [UserController::class, 'delete_ajax']);
    Route::delete('/{id}', [UserController::class, 'destroy']);
});

//Route Position
Route::group(['prefix' => 'position'], function () {
    Route::get('/', [PositionController::class, 'index']);
    Route::post('/list', [PositionController::class, 'list']);
    Route::get('/create', [PositionController::class, 'create']);
    Route::post('/', [PositionController::class, 'store']);
    Route::get('/create_ajax', [PositionController::class, 'create_ajax']);
    Route::post('/ajax', [PositionController::class, 'store_ajax']);
    Route::get('/{id}/show_ajax', [PositionController::class, 'show_ajax']);
    Route::get('/{id}', [PositionController::class, 'show']);
    Route::get('/{id}/edit', [PositionController::class, 'edit']);
    Route::put('/{id}', [PositionController::class, 'update']);
    Route::get('/{id}/edit_ajax', [PositionController::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [PositionController::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [PositionController::class, 'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [PositionController::class, 'delete_ajax']);
    Route::delete('/{id}', [PositionController::class, 'destroy']);
});

//Route Branch
Route::prefix('branch')->group(function () {
    Route::get('/', [BranchController::class, 'index'])->name('branch.index');
    Route::post('/list', [BranchController::class, 'list'])->name('branch.list');
    Route::get('/create', [BranchController::class, 'create'])->name('branch.create');
    Route::post('/', [BranchController::class, 'store'])->name('branch.store');
    Route::get('/{id}', [BranchController::class, 'show'])->name('branch.show');
    Route::get('/{id}/edit', [BranchController::class, 'edit'])->name('branch.edit');
    Route::put('/{id}', [BranchController::class, 'update'])->name('branch.update');
    Route::delete('/{id}', [BranchController::class, 'destroy'])->name('branch.destroy');
});

//Route Employee
Route::prefix('employee')->group(function () {
    Route::get('/', [EmployeeController::class, 'index']);
    Route::post('/list', [EmployeeController::class, 'list']);
    Route::get('/create', [EmployeeController::class, 'create']);
    Route::post('/', [EmployeeController::class, 'store']);
    Route::get('/{id}', [EmployeeController::class, 'show']);
    Route::get('/{id}/edit', [EmployeeController::class, 'edit']);
    Route::put('/{id}', [EmployeeController::class, 'update']);
    Route::delete('/{id}', [EmployeeController::class, 'destroy']);
});

//Route Performance
Route::prefix('performance')->group(function () {
    Route::get('/', [PerformanceController::class, 'index']);
    Route::post('/list', [PerformanceController::class, 'list']); // ini untuk DataTables
    Route::get('/create', [PerformanceController::class, 'create']);
    Route::post('/', [PerformanceController::class, 'store']);
    Route::get('/{id}', [PerformanceController::class, 'show']);
    Route::get('/{id}/edit', [PerformanceController::class, 'edit']);
    Route::put('/{id}', [PerformanceController::class, 'update']);
    Route::delete('/{id}', [PerformanceController::class, 'destroy']);
});