<?php

use App\Http\Controllers\LandingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RiskAssessmentController;
use App\Http\Controllers\WorkerController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
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

    // 위험성평가 라우트
    Route::resource('risk-assessments', RiskAssessmentController::class);
    Route::get('risk-assessments/{assessment}/pdf', [RiskAssessmentController::class, 'generatePdf'])
        ->name('risk-assessments.pdf');
});

// 관리자 라우트
Route::prefix('admin')->middleware(['web', 'auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/projects', [AdminController::class, 'projects'])->name('admin.projects');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 커뮤니티 라우트
Route::middleware(['auth'])->prefix('community')->group(function () {
    Route::get('/', function () {
        return redirect()->route('community.posts.index');
    })->name('community.index');

    // 게시글 기본 CRUD 라우트
    Route::resource('posts', PostController::class)->names('community.posts');
    
    // 게시글 필터링 라우트
    Route::get('posts/filter/{filter}', [PostController::class, 'index'])
        ->name('community.posts.filter');
    
    // 게시글 좋아요 토글
    Route::post('posts/{post}/like', [PostController::class, 'toggleLike'])
        ->name('community.posts.like');
    
    // 댓글 관련 라우트
    Route::post('posts/{post}/comments', [CommentController::class, 'store'])
        ->name('community.comments.store');
    Route::put('comments/{comment}', [CommentController::class, 'update'])
        ->name('community.comments.update');
    Route::delete('comments/{comment}', [CommentController::class, 'destroy'])
        ->name('community.comments.destroy');
    Route::post('comments/{comment}/like', [CommentController::class, 'toggleLike'])
        ->name('community.comments.like');
});

require __DIR__.'/auth.php';
