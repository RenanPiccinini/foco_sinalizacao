<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\EvolutionWhatsAppService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ConexaoController extends Controller
{
    protected EvolutionWhatsAppService $whatsAppService;

    public function __construct(EvolutionWhatsAppService $whatsAppService)
    {
        $this->whatsAppService = $whatsAppService;
    }

    /**
     * Tela principal de gerenciamento de Conexão WhatsApp
     */
    public function index()
    {
        $stateInfo = $this->whatsAppService->getConnectionState();
        $instance = config('services.evolution.instance', 'foco_sinalizacao');
        $apiUrl = config('services.evolution.url', 'https://evolution.piccininidigitalsolutions.com.br');
        $hasApiKey = ! empty(config('services.evolution.api_key'));

        return view('admin.conexao.index', compact('stateInfo', 'instance', 'apiUrl', 'hasApiKey'));
    }

    /**
     * Endpoint JSON para polling de status (atualiza automaticamente ao conectar)
     */
    public function status(): JsonResponse
    {
        $stateInfo = $this->whatsAppService->getConnectionState();

        return response()->json($stateInfo);
    }

    /**
     * Endpoint JSON para gerar/obter o QR Code da Evolution API
     */
    public function qrcode(): JsonResponse
    {
        $qrInfo = $this->whatsAppService->getQrCode();

        return response()->json($qrInfo);
    }

    /**
     * Desconecta o WhatsApp da Evolution API
     */
    public function desconectar(Request $request)
    {
        $this->whatsAppService->logout();

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Desconectado com sucesso.']);
        }

        return back()->with('success', 'Sessão do WhatsApp desconectada com sucesso! Você pode escanear novamente para conectar outro número.');
    }

    /**
     * Dispara uma mensagem de teste para verificar a conexão ativa
     */
    public function teste(Request $request)
    {
        $request->validate([
            'numero' => 'nullable|string|max:30',
        ]);

        $numeroInput = trim((string) $request->input('numero'));
        $digitsOnly = preg_replace('/\D/', '', $numeroInput);

        // Se digitou um número com DDD válido (pelo menos 10 dígitos), usa o digitado
        if (! empty($digitsOnly) && strlen($digitsOnly) >= 10) {
            $numero = $digitsOnly;
        } else {
            // Caso contrário, usa o próprio número conectado na instância (com fallback oficial)
            $numero = $this->whatsAppService->getConnectedNumber();
        }

        $hora = now()->format('d/m/Y H:i:s');

        $mensagem = "🟢 *TESTE DE CONEXÃO WHATSAPP - FOCO SINALIZAÇÃO*\n\n"
            ."Parabéns! O seu WhatsApp está conectado com sucesso ao sistema da FOCO Sinalização via Evolution API.\n\n"
            ."⏰ *Data/Hora do Teste:* {$hora}\n"
            .'🚀 *Instância:* '.config('services.evolution.instance', 'foco_sinalizacao')."\n\n"
            .'As notificações de novos chamados e avisos automáticos de conclusão já estão operacionais e serão enviadas por este número conectado!';

        $resultado = $this->whatsAppService->sendMessage($numero, $mensagem);

        if (! empty($resultado['success'])) {
            $destinatarioFormatado = EvolutionWhatsAppService::formatPhoneNumber($numero);

            return back()->with('success', "Mensagem de teste enviada com sucesso para {$destinatarioFormatado}!");
        }

        if (! empty($resultado['simulated'])) {
            return back()->with('info', 'Simulação realizada! Para envio real, preencha a chave EVOLUTION_API_KEY no arquivo .env.');
        }

        return back()->with('error', 'Não foi possível enviar o teste: '.($resultado['error'] ?? 'Verifique se o WhatsApp está realmente conectado.'));
    }
}
