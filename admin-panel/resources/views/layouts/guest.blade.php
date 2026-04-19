<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @include('partials.head-assets')
    </head>
    <body class="font-sans text-slate-100 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center px-4 py-10 bg-gradient-to-br from-slate-950 via-slate-900 to-slate-950">
            <div class="mb-8 text-center">
                <a href="{{ route('login') }}" class="inline-flex items-center justify-center">
                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-amber-400 text-slate-950 shadow-lg shadow-amber-400/30">
                        <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                    </div>
                </a>
            </div>

            <div class="w-full sm:max-w-md">
                <div class="overflow-hidden rounded-2xl border border-slate-700/70 bg-slate-900/90 p-8 shadow-2xl shadow-slate-950/50 backdrop-blur-md ring-1 ring-white/5">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
