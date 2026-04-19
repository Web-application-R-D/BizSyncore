<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? config('app.name', 'BizSyncore') }} — Master Admin</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        @include('partials.head-assets')
    </head>
    <body class="font-sans antialiased" style="background-color:#0F1729; color:#e2e8f0;">
        <div class="min-h-screen flex">

            {{-- ── Sidebar ──────────────────────────────────────────── --}}
            <aside class="sticky top-0 h-screen w-64 shrink-0 flex flex-col overflow-y-auto border-r"
                   style="background-color:#0F1729; border-color:#1E2A5E;">

                {{-- Brand --}}
                <div class="p-5 border-b" style="border-color:#1E2A5E;">
                    <div class="flex items-center gap-2.5 mb-2.5">
                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg"
                             style="background-color:#1E2A5E;">
                            <svg class="h-5 w-5" style="color:#F5A623;" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold leading-tight">
                                <span style="color:#F5A623;">Biz</span><span class="text-white">Syncore</span>
                            </p>
                            <p class="text-[10px] text-slate-400 leading-tight">Master Admin Portal</p>
                        </div>
                    </div>
                    <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-[10px] font-semibold tracking-wide uppercase"
                          style="border-color:#F5A62340; color:#F5A623; background-color:#F5A62315;">
                        Internal only
                    </span>
                </div>

                {{-- Navigation --}}
                <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-5">
                    @php
                        $navLink = fn(string $route, string $label, string $icon) =>
                            ['route' => $route, 'label' => $label, 'icon' => $icon,
                             'active' => request()->routeIs($route . '*')];
                        $navLinkExact = fn(string $route, string $label, string $icon) =>
                            ['route' => $route, 'label' => $label, 'icon' => $icon,
                             'active' => request()->routeIs($route)];
                    @endphp

                    {{-- MANAGEMENT --}}
                    <div>
                        <p class="px-3 mb-1.5 text-[10px] font-semibold uppercase tracking-[0.2em] text-slate-500">Management</p>
                        <div class="space-y-0.5">
                            @foreach ([
                                ['route' => 'dashboard', 'label' => 'Dashboard', 'active' => request()->routeIs('dashboard'), 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>'],
                                ['route' => 'clients.index', 'label' => 'Clients', 'active' => request()->routeIs('clients.*'), 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>'],
                                ['route' => 'plans.index', 'label' => 'Plans & pricing', 'active' => request()->routeIs('plans.*'), 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>'],
                                ['route' => 'access-codes.index', 'label' => 'Access codes', 'active' => request()->routeIs('access-codes.*'), 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>'],
                            ] as $item)
                                <a href="{{ route($item['route']) }}"
                                   class="group flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition-all"
                                   style="{{ $item['active'] ? 'background-color:#1E2A5E; color:#fff;' : 'color:#94a3b8;' }}"
                                   @if(!$item['active']) onmouseover="this.style.backgroundColor='#1E2A5E40';this.style.color='#fff'" onmouseout="this.style.backgroundColor='';this.style.color='#94a3b8'" @endif>
                                    <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-md"
                                          style="{{ $item['active'] ? 'background-color:#F5A623; color:#0F1729;' : 'background-color:#1E2A5E50; color:#64748b;' }}">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            {!! $item['icon'] !!}
                                        </svg>
                                    </span>
                                    {{ $item['label'] }}
                                </a>
                            @endforeach
                        </div>
                    </div>

                    {{-- PLATFORM --}}
                    <div>
                        <p class="px-3 mb-1.5 text-[10px] font-semibold uppercase tracking-[0.2em] text-slate-500">Platform</p>
                        <div class="space-y-0.5">
                            @foreach ([
                                ['route' => 'analytics.index', 'label' => 'Analytics', 'active' => request()->routeIs('analytics.*'), 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>'],
                                ['route' => 'analytics.index', 'label' => 'Billing', 'active' => false, 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>'],
                                ['route' => 'audit-log.index', 'label' => 'Audit log', 'active' => request()->routeIs('audit-log.*'), 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>'],
                                ['route' => 'dashboard', 'label' => 'Admin users', 'active' => false, 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>'],
                            ] as $item)
                                <a href="{{ route($item['route']) }}"
                                   class="group flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition-all"
                                   style="{{ $item['active'] ? 'background-color:#1E2A5E; color:#fff;' : 'color:#94a3b8;' }}"
                                   @if(!$item['active']) onmouseover="this.style.backgroundColor='#1E2A5E40';this.style.color='#fff'" onmouseout="this.style.backgroundColor='';this.style.color='#94a3b8'" @endif>
                                    <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-md"
                                          style="{{ $item['active'] ? 'background-color:#F5A623; color:#0F1729;' : 'background-color:#1E2A5E50; color:#64748b;' }}">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            {!! $item['icon'] !!}
                                        </svg>
                                    </span>
                                    {{ $item['label'] }}
                                </a>
                            @endforeach
                        </div>
                    </div>

                    {{-- SYSTEM --}}
                    <div>
                        <p class="px-3 mb-1.5 text-[10px] font-semibold uppercase tracking-[0.2em] text-slate-500">System</p>
                        <div class="space-y-0.5">
                            @foreach ([
                                ['route' => 'dashboard', 'label' => 'API config', 'active' => false, 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>'],
                                ['route' => 'profile.edit', 'label' => 'Settings', 'active' => request()->routeIs('profile.*'), 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>'],
                            ] as $item)
                                <a href="{{ route($item['route']) }}"
                                   class="group flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition-all"
                                   style="{{ $item['active'] ? 'background-color:#1E2A5E; color:#fff;' : 'color:#94a3b8;' }}"
                                   @if(!$item['active']) onmouseover="this.style.backgroundColor='#1E2A5E40';this.style.color='#fff'" onmouseout="this.style.backgroundColor='';this.style.color='#94a3b8'" @endif>
                                    <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-md"
                                          style="{{ $item['active'] ? 'background-color:#F5A623; color:#0F1729;' : 'background-color:#1E2A5E50; color:#64748b;' }}">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            {!! $item['icon'] !!}
                                        </svg>
                                    </span>
                                    {{ $item['label'] }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </nav>

                {{-- User footer --}}
                <div class="p-4 border-t" style="border-color:#1E2A5E;">
                    <div class="flex items-center gap-2.5">
                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg text-xs font-bold"
                             style="background-color:#1E2A5E; color:#F5A623;">
                            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="truncate text-sm font-semibold text-white">{{ Auth::user()->name }}</p>
                            <p class="truncate text-[10px] text-slate-400">Super Admin</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="mt-3">
                        @csrf
                        <button type="submit"
                                class="w-full rounded-lg border px-3 py-1.5 text-xs font-medium text-slate-300 transition hover:text-white"
                                style="border-color:#1E2A5E; background-color:#1E2A5E40;"
                                onmouseover="this.style.backgroundColor='#1E2A5E'" onmouseout="this.style.backgroundColor='#1E2A5E40'">
                            Log out
                        </button>
                    </form>
                </div>
            </aside>

            {{-- ── Main content ─────────────────────────────────────── --}}
            <div class="flex-1 flex flex-col min-w-0" style="background-color:#0F1729;">
                @isset($header)
                    <header class="sticky top-0 z-10 border-b" style="background-color:#0F1729cc; border-color:#1E2A5E; backdrop-filter:blur(12px);">
                        <div class="max-w-7xl mx-auto px-6 py-4">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <main class="flex-1 p-6 sm:p-8">
                    <div class="max-w-7xl mx-auto">
                        {{ $slot }}
                    </div>
                </main>

                <footer class="border-t px-8 py-3 text-center text-[10px] text-slate-600" style="border-color:#1E2A5E;">
                    BizSyncore Master Admin UI &middot; Midnight Indigo Dark Theme &middot; Confidential
                </footer>
            </div>
        </div>
    </body>
</html>
