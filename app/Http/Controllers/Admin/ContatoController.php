<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contato;
use App\Services\OrcamentoMailerService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class ContatoController extends Controller
{
    /**
     * Lista todas as mensagens e solicitações de orçamento recebidas
     */
    public function index(Request $request)
    {
        $status = $request->query('status');
        $assunto = $request->query('assunto');
        $busca = $request->query('busca');

        $query = Contato::query()->latest('created_at');

        if ($status && $status !== 'todos') {
            $query->where('status', $status);
        }

        if ($assunto && $assunto !== 'todos') {
            $query->where('assunto', $assunto);
        }

        if ($busca) {
            $term = '%'.trim($busca).'%';
            $query->where(function ($q) use ($term) {
                $q->where('protocolo', 'like', $term)
                    ->orWhere('empresa', 'like', $term)
                    ->orWhere('responsavel', 'like', $term)
                    ->orWhere('email', 'like', $term)
                    ->orWhere('fone', 'like', $term)
                    ->orWhere('cnpj', 'like', $term);
            });
        }

        $contatos = $query->paginate(15)->withQueryString();

        $all = Contato::all();
        $stats = [
            'total' => $all->count(),
            'novos' => $all->where('status', 'Novo')->count(),
            'em_analise' => $all->where('status', 'Em Análise')->count(),
            'respondidos' => $all->where('status', 'Respondido')->count(),
            'orcamentos' => $all->filter(fn ($c) => str_contains($c->assunto, 'ORÇAMENTO'))->count(),
        ];

        $mailStatus = [
            'mailer' => config('mail.default'),
            'host' => config('mail.mailers.smtp.host'),
            'port' => config('mail.mailers.smtp.port'),
            'scheme' => config('mail.mailers.smtp.scheme') ?: ((int) config('mail.mailers.smtp.port') === 465 ? 'smtps' : 'smtp'),
            'username' => config('mail.mailers.smtp.username'),
            'password_configured' => ! empty(config('mail.mailers.smtp.password')),
            'from_address' => config('mail.from.address'),
            'demandas_address' => config('mail.demandas_address') ?: config('mail.from.address'),
            'config_cached' => app()->configurationIsCached(),
        ];

        $ultimoDiagnostico = app(OrcamentoMailerService::class)->obterUltimoDiagnostico();

        return view('admin.contatos.index', compact('contatos', 'stats', 'status', 'assunto', 'busca', 'mailStatus', 'ultimoDiagnostico'));
    }

    /**
     * Dispara um e-mail de teste para validar a configuração SMTP Hostinger.
     */
    public function testarEmail(OrcamentoMailerService $mailerService): RedirectResponse
    {
        $resultado = $mailerService->enviarTeste();

        if ($resultado['success']) {
            return redirect()->back()->with('success', $resultado['message']);
        }

        return redirect()->back()->with('error', $resultado['message']);
    }

    /**
     * Limpa caches de configuração para recarregar alterações feitas no .env.
     */
    public function limparCacheConfig(): RedirectResponse
    {
        Artisan::call('config:clear');
        Artisan::call('cache:clear');

        return redirect()->back()->with('success', 'Cache de configuração (.env) limpo e recarregado com sucesso!');
    }

    /**
     * Exibe os detalhes de uma solicitação / orçamento
     */
    public function show(Contato $contato)
    {
        return view('admin.contatos.show', compact('contato'));
    }

    /**
     * Atualiza o status da solicitação
     */
    public function updateStatus(Request $request, Contato $contato)
    {
        $validated = $request->validate([
            'status' => 'required|string|in:Novo,Em Análise,Respondido,Arquivado',
        ]);

        $contato->status = $validated['status'];
        $contato->save();

        return redirect()->back()
            ->with('success', "Status da solicitação {$contato->protocolo} atualizado para '{$contato->status}'.");
    }

    /**
     * Download do arquivo ou planilha anexa
     */
    public function downloadArquivo(Contato $contato)
    {
        if (! $contato->arquivo_path || ! Storage::disk('public')->exists($contato->arquivo_path)) {
            return redirect()->back()->with('error', 'Arquivo anexo não encontrado.');
        }

        return Storage::disk('public')->download($contato->arquivo_path, $contato->arquivo_nome ?? 'anexo');
    }

    /**
     * Remove a solicitação
     */
    public function destroy(Contato $contato)
    {
        if ($contato->arquivo_path && Storage::disk('public')->exists($contato->arquivo_path)) {
            Storage::disk('public')->delete($contato->arquivo_path);
        }

        $protocolo = $contato->protocolo;
        $contato->delete();

        return redirect()->route('admin.contatos.index')
            ->with('success', "Solicitação {$protocolo} removida com sucesso.");
    }
}
