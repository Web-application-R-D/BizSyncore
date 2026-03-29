<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? config('app.name', 'Laravel') }} — Master Admin</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @include('partials.head-assets')
    </head>
    <body class="font-sans antialiased bg-slate-100 text-slate-900">
        <div class="min-h-screen flex">
            {{-- Sidebar --}}
            <aside class="w-64 shrink-0 bg-slate-900 text-white flex flex-col border-r border-slate-800/80 shadow-xl shadow-slate-900/20">
                <div class="p-6 border-b border-slate-700/80">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-500 text-white shadow-lg shadow-indigo-500/30">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold leading-tight">Admin</p>
                        </div>
                    </div>
                </div>

                <nav class="flex-1 p-3 space-y-1">
                    <a href="{{ route('dashboard') }}"
                       class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition {{ request()->routeIs('dashboard') ? 'bg-white/10 text-white shadow-inner' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                        <span class="flex h-8 w-8 items-center justify-center rounded-lg {{ request()->routeIs('dashboard') ? 'bg-indigo-500 text-white' : 'bg-slate-800 text-slate-400 group-hover:text-white' }}">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                        </span>
                        Dashboard
                    </a>
                    <a href="{{ route('clients.index') }}"
                       class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition {{ request()->routeIs('clients.*') ? 'bg-white/10 text-white shadow-inner' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                        <span class="flex h-8 w-8 items-center justify-center rounded-lg {{ request()->routeIs('clients.*') ? 'bg-indigo-500 text-white' : 'bg-slate-800 text-slate-400 group-hover:text-white' }}">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                        </span>
                        Client management
                    </a>
                </nav>

                <div class="p-4 border-t border-slate-700/80 bg-slate-950/40">
                    <p class="truncate text-sm font-medium text-white">{{ Auth::user()->name }}</p>
                    <p class="truncate text-xs text-slate-400 mt-0.5">{{ Auth::user()->email }}</p>
                    <form method="POST" action="{{ route('logout') }}" class="mt-3">
                        @csrf
                        <button type="submit" class="w-full rounded-lg border border-slate-600 bg-slate-800/50 px-3 py-2 text-xs font-medium text-slate-200 transition hover:bg-slate-800 hover:text-white">
                            Log out
                        </button>
                    </form>
                </div>
            </aside>

            {{-- Main --}}
            <div class="flex-1 flex flex-col min-w-0 bg-gradient-to-br from-slate-50 via-white to-indigo-50/30">
                @isset($header)
                    <header class="sticky top-0 z-10 border-b border-slate-200/80 bg-white/80 backdrop-blur-md">
                        <div class="max-w-6xl mx-auto px-6 py-5">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <main class="flex-1 p-6 sm:p-8">
                    <div class="max-w-6xl mx-auto">
                        {{ $slot }}
                    </div>
                </main>
            </div>
        </div>
    </body>
</html>
