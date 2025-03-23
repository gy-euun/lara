<?php

use App\Http\Controllers\LandingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RiskAssessmentController;
use App\Http\Controllers\WorkerController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\AdminController;
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

Route::get('/', [LandingController::class, 'index'])->name('landing');

Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return view('welcome');
    })->name('home');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // 프로젝트 관련 라우트
    Route::resource('projects', ProjectController::class);
    Route::get('/projects/{project}/dashboard', [ProjectController::class, 'dashboard'])->name('projects.dashboard');
    
    // 위험성 평가 관련 라우트
    Route::resource('projects.risk-assessments', RiskAssessmentController::class);

    // 근로자 관련 라우트
    Route::resource('projects.workers', WorkerController::class);

    // 문서 관련 라우트
    Route::resource('projects.documents', DocumentController::class);

    // 챗봇 관련 라우트
    Route::get('/projects/{project}/chatbot', [ChatbotController::class, 'index'])->name('projects.chatbot.index');
});

// 관리자 라우트
Route::middleware(['web', 'auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/projects', [AdminController::class, 'projects'])->name('admin.projects');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
