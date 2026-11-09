<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Official\{CaseController, DocumentController, HearingController, ReportController};
use App\Http\Controllers\Resident\{ComplaintController, NoticeController, ProfileController};
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (!auth()->check())
        return redirect()->route('login');
    return auth()->user()->isOfficial() ? redirect()->route('official.dashboard') : redirect()->route('resident.dashboard.index');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Resident
Route::middleware(['auth', RoleMiddleware::class . ':resident'])->prefix('resident')->name('resident.')->group(function () {
    Route::resource('dashboard', ComplaintController::class)->only(['index', 'create', 'store', 'show'])
        ->parameters(['dashboard' => 'incident']);
    Route::get('calendar', [ComplaintController::class, 'calendar'])->name('calendar');
    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('notices', [NoticeController::class, 'index'])->name('notices.index');
    Route::post('notices/read', [NoticeController::class, 'read'])->name('notices.read');

});

// Barangay 
Route::middleware(['auth', RoleMiddleware::class . ':official'])->prefix('official')->name('official.')->group(function () {
    Route::get('dashboard', [CaseController::class, 'index'])->name('dashboard');
    Route::get('calendar', [CaseController::class, 'calendar'])->name('calendar');
    Route::get('reports', [ReportController::class, 'index'])->name('reports');
    Route::get('sms', [CaseController::class, 'sms'])->name('sms');

    Route::get('cases/{incident}', [CaseController::class, 'show'])->name('cases.show');
    Route::get('cases/{incident}/edit', [CaseController::class, 'edit'])->name('cases.edit');
    Route::put('cases/{incident}', [CaseController::class, 'update'])->name('cases.update');
    Route::delete('cases/{incident}', [CaseController::class, 'destroy'])->name('cases.destroy');
    Route::patch('cases/{incident}/status', [CaseController::class, 'updateStatus'])->name('cases.status');
    Route::get('cases/{incident}/print/{type}', [DocumentController::class, 'show'])->name('cases.print');

    Route::post('cases/{incident}/hearings', [HearingController::class, 'store'])->name('cases.hearings');
    Route::resource('hearings', HearingController::class)->only(['edit', 'update', 'destroy']);

});
