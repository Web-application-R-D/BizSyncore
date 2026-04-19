<?php

use App\Http\Controllers\AccessCodeController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => auth()->check()
    ? redirect()->route('dashboard')
    : redirect()->route('login')
);

Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        $counts = [
            'total'     => \App\Models\Client::count(),
            'active'    => \App\Models\Client::where('status', 'active')->count(),
            'trial'     => \App\Models\Client::where('status', 'trial')->count(),
            'suspended' => \App\Models\Client::where('status', 'suspended')->count(),
        ];
        $mrr        = \App\Models\Client::where('status', 'active')->sum('mrr');
        $newClients = \App\Models\Client::latest('joined_at')->limit(3)->get();
        $planCounts = \App\Models\Client::selectRaw('plan, count(*) as count')
            ->whereIn('status', ['active', 'trial'])
            ->groupBy('plan')
            ->pluck('count', 'plan');
        $activity   = \App\Models\AuditLog::with('user')->latest()->limit(4)->get();

        return view('dashboard', compact('counts', 'mrr', 'newClients', 'planCounts', 'activity'));
    })->name('dashboard');

    // Profile
    Route::get('/profile',    [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',  [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Clients — CRUD + status + code regen
    Route::get('/clients',                        [ClientController::class, 'index'])->name('clients.index');
    Route::get('/clients/create',                 [ClientController::class, 'create'])->name('clients.create');
    Route::post('/clients',                       [ClientController::class, 'store'])->name('clients.store');
    Route::get('/clients/{client}/edit',          [ClientController::class, 'edit'])->name('clients.edit');
    Route::patch('/clients/{client}',             [ClientController::class, 'update'])->name('clients.update');
    Route::patch('/clients/{client}/status',      [ClientController::class, 'updateStatus'])->name('clients.updateStatus');
    Route::post('/clients/{client}/regen-code',   [ClientController::class, 'regenerateCode'])->name('clients.regenCode');
    Route::delete('/clients/{client}',            [ClientController::class, 'destroy'])->name('clients.destroy');

    // Plans & Pricing
    Route::get('/plans',                [PlanController::class, 'index'])->name('plans.index');

    // Access Codes
    Route::get('/access-codes',                             [AccessCodeController::class, 'index'])->name('access-codes.index');
    Route::post('/access-codes/{client}/regen',             [AccessCodeController::class, 'regen'])->name('access-codes.regen');
    Route::patch('/access-codes/{client}/toggle-status',   [AccessCodeController::class, 'toggleStatus'])->name('access-codes.toggleStatus');

    // Audit Log
    Route::get('/audit-log', [AuditLogController::class, 'index'])->name('audit-log.index');

    // Analytics & Billing
    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics.index');
});

require __DIR__.'/auth.php';
