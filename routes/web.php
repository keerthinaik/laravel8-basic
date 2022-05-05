<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AboutController;
use App\Http\Controllers\CategoryController;
use App\Models\User;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/about', [AboutController::class, 'index'])->middleware('check_age');

// Category Controller
Route::get('category/all', [CategoryController::class, 'allCategory'])->name('all.category');
Route::post('category/add', [CategoryController::class, 'addCategory'])->name('add.category');
Route::get('category/edit/{id}', [CategoryController::class, 'editCategory']);
Route::post('category/update/{id}', [CategoryController::class, 'updateCategory']);
Route::get('category/softdelete/{id}', [CategoryController::class, 'softDeleteCategory']);
Route::get('category/restore/{id}', [CategoryController::class, 'restoreCategory']);
Route::get('category/permanent_delete/{id}', [CategoryController::class, 'deleteCategory']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        // $users = User::all();
        $users = DB::table('users')->get();
        return view('dashboard', compact('users'));
    })->name('dashboard');
});
