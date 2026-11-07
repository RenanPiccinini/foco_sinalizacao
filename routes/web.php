<?php

use App\Http\Controllers\Admin\ChamadoController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rotas Públicas do Site Institucional FOCO SINALIZAÇÃO
|--------------------------------------------------------------------------
*/
Route::get('/', [SiteController::class, 'index'])->name('home');
Route::get('/chamados', [SiteController::class, 'chamados'])->name('site.chamados');
Route::post('/chamados', [SiteController::class, 'storeChamado'])->name('site.chamados.store');
Route::get('/solucoes', [SiteController::class, 'solucoes'])->name('site.solucoes');
Route::get('/sobre', [SiteController::class, 'sobre'])->name('site.sobre');
Route::get('/cidades-e-rodovias', [SiteController::class, 'cidades'])->name('site.cidades');
Route::get('/contato', [SiteController::class, 'contato'])->name('site.contato');

/*
|--------------------------------------------------------------------------
| Rotas Protegidas do Gerenciador (Painel Admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard principal
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Menu Chamados
    Route::get('/admin/chamados', [ChamadoController::class, 'index'])->name('admin.chamados.index');
    Route::post('/admin/chamados', [ChamadoController::class, 'store'])->name('admin.chamados.store');
    Route::get('/admin/chamados/exportar/csv', [ChamadoController::class, 'exportarCsv'])->name('admin.chamados.export.csv');
    Route::get('/admin/chamados/{id}', [ChamadoController::class, 'show'])->name('admin.chamados.show');
    Route::post('/admin/chamados/{id}/status', [ChamadoController::class, 'update'])->name('admin.chamados.update');
    Route::post('/admin/chamados/{id}/concluir', [ChamadoController::class, 'concluir'])->name('admin.chamados.concluir');
    Route::get('/admin/chamados/{id}/imprimir-os', [ChamadoController::class, 'imprimirOs'])->name('admin.chamados.imprimir-os');

    // Módulos adicionais do gerenciador
    Route::get('/admin/controladores', function () {
        return view('admin.controladores');
    })->name('admin.controladores');

    Route::get('/admin/central-nuvem', function () {
        return view('admin.central-nuvem');
    })->name('admin.central-nuvem');

    Route::get('/admin/cidades', function () {
        return view('admin.cidades');
    })->name('admin.cidades');

    // Perfil do Administrador
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
