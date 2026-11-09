<?php

use App\Http\Controllers\Admin\ChamadoController;
use App\Http\Controllers\Admin\ConexaoController;
use App\Http\Controllers\Admin\ContatoController as AdminContatoController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rotas Públicas do Site Institucional FOCO SINALIZAÇÃO
|--------------------------------------------------------------------------
*/
Route::get('/', [SiteController::class, 'index'])->name('home');
Route::get('/solucoes', [SiteController::class, 'solucoes'])->name('site.solucoes');
Route::get('/sobre', [SiteController::class, 'sobre'])->name('site.sobre');
Route::get('/cidades-e-rodovias', [SiteController::class, 'cidades'])->name('site.cidades');

// Formulário de Contato e Solicitação de Orçamento (Público com os campos da foto)
Route::get('/contato', [SiteController::class, 'contato'])->name('site.contato');
Route::get('/orcamento', [SiteController::class, 'orcamento'])->name('site.orcamento');
Route::post('/contato', [SiteController::class, 'storeContato'])->name('site.contato.store');

// Abertura e Acompanhamento de Chamados (Exclusivo para Usuários Autenticados com Login e Senha)
Route::middleware('auth')->group(function () {
    Route::get('/chamados', [SiteController::class, 'chamados'])->name('site.chamados');
    Route::post('/chamados', [SiteController::class, 'storeChamado'])->name('site.chamados.store');
});

/*
|--------------------------------------------------------------------------
| Rotas Protegidas do Gerenciador (Painel Admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'admin'])->group(function () {
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

    // Menu Usuários (Controle Master de Usuários - Criar/Editar/Excluir/Bloquear/Liberar)
    Route::resource('admin/users', UserController::class)->names('admin.users');
    Route::patch('admin/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('admin.users.toggle-status');

    // Menu Solicitações & Orçamentos Recebidos
    Route::get('/admin/contatos', [AdminContatoController::class, 'index'])->name('admin.contatos.index');
    Route::get('/admin/contatos/{contato}', [AdminContatoController::class, 'show'])->name('admin.contatos.show');
    Route::patch('/admin/contatos/{contato}/status', [AdminContatoController::class, 'updateStatus'])->name('admin.contatos.status');
    Route::get('/admin/contatos/{contato}/download', [AdminContatoController::class, 'downloadArquivo'])->name('admin.contatos.download');
    Route::delete('/admin/contatos/{contato}', [AdminContatoController::class, 'destroy'])->name('admin.contatos.destroy');

    // Menu Conexão WhatsApp (Evolution API)
    Route::get('/admin/conexao', [ConexaoController::class, 'index'])->name('admin.conexao.index');
    Route::get('/admin/conexao/status', [ConexaoController::class, 'status'])->name('admin.conexao.status');
    Route::get('/admin/conexao/qrcode', [ConexaoController::class, 'qrcode'])->name('admin.conexao.qrcode');
    Route::post('/admin/conexao/desconectar', [ConexaoController::class, 'desconectar'])->name('admin.conexao.desconectar');
    Route::post('/admin/conexao/teste', [ConexaoController::class, 'teste'])->name('admin.conexao.teste');

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
});

// Perfil do Usuário Autenticado
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
