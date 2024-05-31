<?php
namespace App\Http\Controllers;
namespace App\Http\Controllers\teacher;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\teacher\SubjectController;


Route::get('/', function () {
    return view('home');
});

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::get('/signup', [LoginController::class, 'signup'])->name('signup');
Route::post('/signupUser', [LoginController::class, 'store'])->name('signupUser');
Route::post('/loginUser', [LoginController::class, 'loginUser'])->name('loginUser');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->get('/dashboard', [LoginController::class, 'dashboard'])->name('dashboard');

Route::middleware(['auth', 'checkTeacher'])->group(function () {
    Route::get('/api/subjects', [SubjectController::class, 'index'])->name('subjects');
    Route::post('/api/create/subject', [SubjectController::class, 'store'])->name('subject-create');
    Route::post('/api/edit/subject', [SubjectController::class, 'update'])->name('subject-update');
    Route::get('/api/delete/subject/{id}', [SubjectController::class, 'destroy'])->name('subject-destroy');

    Route::get('/dashboard/subject', function () {
        return view('teacher.subject');
    })->name('subject-dashboard');
});

// Learner Routes
Route::middleware(['auth', 'checkLearner'])->group(function () {
    // Define learner-specific routes here
});




