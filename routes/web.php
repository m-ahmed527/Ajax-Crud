<?php

use App\Http\Controllers\StudentController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [StudentController::class, 'index'])->name('index');
Route::post('/create-student', [StudentController::class, 'create'])->name('create-student');
Route::get('/list', function () {
    return view('screens.student-list');
});
Route::get('/student-list', [StudentController::class, 'studentList'])->name('student-list');
Route::get('/student-edit/{student}', [StudentController::class, 'edit'])->name('student.edit');
Route::post('/student-update/{student}', [StudentController::class, 'update'])->name('student.update');
Route::get('/student-delete/{id}', [StudentController::class, 'destroy'])->name('student.delete');
Route::get('/search', [StudentController::class, 'search'])->name('search');
