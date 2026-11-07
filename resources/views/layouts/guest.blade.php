<!DOCTYPE html>
<html lang="pt-BR" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Foco Sinalização') }} | Acesso Restrito</title>

    <!-- Favicon -->
    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo-banner.jpg') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;700&family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Scripts e Estilos -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-foco-navy-950 text-slate-100 font-sans antialiased selection:bg-foco-yellow-500 selection:text-foco-navy-950 min-h-screen flex flex-col justify-center items-center p-4 relative overflow-hidden">

    <!-- Efeitos de iluminação de fundo -->
    <div class="absolute top-1/4 -left-20 w-96 h-96 bg-foco-green-500/15 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-10 -right-20 w-96 h-96 bg-foco-yellow-500/15 rounded-full blur-3xl pointer-events-none"></div>

    <div class="w-full max-w-md relative z-10 space-y-6">
        
        <!-- Logo Oficial no Login -->
        <div class="text-center">
            <a href="{{ route('home') }}" class="inline-block group">
                <div class="relative overflow-hidden rounded-2xl border border-white/15 bg-foco-navy-900/90 p-2 shadow-2xl group-hover:border-foco-yellow-500/50 transition max-w-[280px] mx-auto">
                    <img src="{{ asset('images/logo-banner.jpg') }}" alt="FOCO Sinalização e Sistemas Inteligentes" class="w-full h-auto object-contain rounded">
                </div>
            </a>
            <div class="mt-3">
                <span class="text-xs font-mono font-bold tracking-widest text-foco-yellow-400 uppercase">
                    Acesso ao Gerenciador Central
                </span>
            </div>
        </div>

        <!-- Card de Login -->
        <div class="glass-panel-glow p-8 rounded-3xl border border-white/10 shadow-2xl">
            {{ $slot }}
        </div>

        <div class="text-center text-xs text-slate-500">
            <a href="{{ route('home') }}" class="text-slate-400 hover:text-foco-yellow-400 transition flex items-center justify-center gap-1">
                <span>← Voltar ao site público</span>
            </a>
        </div>
    </div>
</body>
</html>
