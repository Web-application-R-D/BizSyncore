<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <p class="text-xs font-semibold uppercase tracking-widest text-slate-500">Master Admin</p>
                <h1 class="mt-1 text-2xl font-bold tracking-tight text-white">Dashboard</h1>
            </div>
            <div class="flex items-center gap-3">
                <span class="rounded-full border px-4 py-1.5 text-xs text-slate-400"
                      style="border-color:#1E2A5E; background-color:#1E2A5E20;">
                    {{ now()->format('D d M Y · h:i A') }}
                </span>
                <a href="{{ route('clients.create') }}"
                   class="inline-flex items-center rounded-lg px-4 py-2 text-sm font-semibold shadow-lg transition"
                   style="background-color:#F5A623; color:#0F1729;">
                    + New client
                </a>
            </div>
        </div>
    </x-slot>

    {{-- KPI Cards --}}
    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4 mb-6">
        @foreach ([
            ['label' => 'Total clients',     'value' => $counts['total'],          'sub' => '+' . $counts['trial'] . ' trial',         'color' => '#e2e8f0'],
            ['label' => 'Active clients',    'value' => $counts['active'],         'sub' => ($counts['total'] > 0 ? round($counts['active'] / $counts['total'] * 100) : 0) . '% active', 'color' => '#22c55e'],
            ['label' => 'Monthly revenue',   'value' => 'LKR ' . number_format($mrr / 1000, 0) . 'K', 'sub' => 'from active clients', 'color' => '#F5A623'],
            ['label' => 'Trial / Suspended', 'value' => $counts['trial'] . ' / ' . $counts['suspended'], 'sub' => 'Needs review', 'color' => '#f87171'],
        ] as $card)
            <div class="rounded-2xl border p-5" style="background-color:#161F38; border-color:#1E2A5E;">
                <p class="text-[10px] font-semibold uppercase tracking-widest text-slate-500">{{ $card['label'] }}</p>
                <p class="mt-2 text-3xl font-bold" style="color:{{ $card['color'] }};">{{ $card['value'] }}</p>
                <span class="mt-2 inline-flex rounded-full px-2.5 py-0.5 text-[10px] font-semibold"
                      style="background-color:{{ $card['color'] }}20; color:{{ $card['color'] }};">
                    {{ $card['sub'] }}
                </span>
            </div>
        @endforeach
    </div>

    <div class="grid gap-6 xl:grid-cols-[1.65fr_1fr] mb-6">
        {{-- Revenue trend --}}
        <div class="rounded-2xl border p-6" style="background-color:#161F38; border-color:#1E2A5E;">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-base font-semibold text-white">Monthly revenue trend (LKR)</h2>
                <a href="{{ route('analytics.index') }}" class="text-xs font-semibold" style="color:#F5A623;">Full report</a>
            </div>
            @php
                $revenueBars = [
                    ['label' => 'Nov', 'value' => 'LKR 148K', 'w' => '52%'],
                    ['label' => 'Dec', 'value' => 'LKR 186K', 'w' => '65%'],
                    ['label' => 'Jan', 'value' => 'LKR 203K', 'w' => '72%'],
                    ['label' => 'Feb', 'value' => 'LKR 226K', 'w' => '80%'],
                    ['label' => 'Mar', 'value' => 'LKR 240K', 'w' => '85%'],
                    ['label' => 'Apr', 'value' => 'LKR ' . number_format($mrr / 1000, 0) . 'K', 'w' => '100%', 'hl' => true],
                ];
            @endphp
            <div class="space-y-3.5">
                @foreach ($revenueBars as $bar)
                    <div class="grid items-center gap-3" style="grid-template-columns:36px 1fr 80px;">
                        <span class="text-xs text-slate-500">{{ $bar['label'] }}</span>
                        <div class="h-3 rounded-full" style="background-color:#1E2A5E30;">
                            <div class="h-3 rounded-full transition-all"
                                 style="width:{{ $bar['w'] }}; background-color:{{ isset($bar['hl']) ? '#F5A623' : '#1E2A5E' }};"></div>
                        </div>
                        <span class="text-right text-xs font-semibold"
                              style="color:{{ isset($bar['hl']) ? '#F5A623' : '#64748b' }};">
                            {{ $bar['value'] }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- New clients --}}
        <div class="rounded-2xl border p-6" style="background-color:#161F38; border-color:#1E2A5E;">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-base font-semibold text-white">New clients today</h2>
                <a href="{{ route('clients.index') }}" class="text-xs font-semibold" style="color:#F5A623;">View all</a>
            </div>
            @forelse ($newClients as $client)
                <div class="flex items-center gap-3 py-2.5 border-b last:border-0" style="border-color:#1E2A5E30;">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg text-xs font-bold"
                         style="background-color:#F5A62315; color:#F5A623;">
                        {{ strtoupper(substr($client->name, 0, 2)) }}
                    </div>
                    <div class="min-w-0 flex-1">
                        <div class="truncate text-sm font-semibold text-white">{{ $client->name }}</div>
                        <div class="truncate text-xs text-slate-500">{{ $client->vertical ?? $client->company_name ?? '—' }}</div>
                    </div>
                    <span class="rounded-full px-2.5 py-0.5 text-[10px] font-semibold capitalize"
                          style="background-color:#1E2A5E; color:#e2e8f0;">
                        {{ $client->plan ?? '—' }}
                    </span>
                </div>
            @empty
                <p class="text-sm text-slate-500 py-4">No clients yet. <a href="{{ route('clients.create') }}" class="underline" style="color:#F5A623;">Create one.</a></p>
            @endforelse
        </div>
    </div>

    <div class="grid gap-6 xl:grid-cols-3">
        {{-- Clients by plan --}}
        <div class="rounded-2xl border p-6" style="background-color:#161F38; border-color:#1E2A5E;">
            <h2 class="text-base font-semibold text-white mb-5">Clients by plan</h2>
            @php
                $total = max(array_sum($planCounts->toArray()), 1);
                $planRows = [
                    ['label' => 'Large',  'key' => 'large',  'color' => '#F5A623'],
                    ['label' => 'Medium', 'key' => 'medium', 'color' => '#1E2A5E'],
                    ['label' => 'Small',  'key' => 'small',  'color' => '#64748b'],
                ];
            @endphp
            <div class="space-y-4">
                @foreach ($planRows as $row)
                    @php $count = $planCounts[$row['key']] ?? 0; $pct = round(($count / $total) * 100); @endphp
                    <div>
                        <div class="flex items-center justify-between text-sm mb-1.5">
                            <span class="text-slate-400">{{ $row['label'] }}</span>
                            <span class="text-slate-300">{{ $count }} clients</span>
                        </div>
                        <div class="h-3 rounded-full" style="background-color:#1E2A5E30;">
                            <div class="h-3 rounded-full" style="width:{{ $pct }}%; background-color:{{ $row['color'] }};"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Recent activity --}}
        <div class="rounded-2xl border p-6" style="background-color:#161F38; border-color:#1E2A5E;">
            <h2 class="text-base font-semibold text-white mb-5">Recent activity</h2>
            @forelse ($activity as $log)
                @php
                    $dot = match ($log->action) {
                        'create', 'activate', 'restore' => '#22c55e',
                        'suspend', 'delete'             => '#f87171',
                        'regen_code'                    => '#F5A623',
                        default                         => '#60a5fa',
                    };
                @endphp
                <div class="flex items-center gap-3 py-2.5 border-b last:border-0" style="border-color:#1E2A5E30;">
                    <span class="h-2.5 w-2.5 shrink-0 rounded-full" style="background-color:{{ $dot }};"></span>
                    <div class="min-w-0 flex-1 text-sm text-slate-300 truncate">
                        {{ $log->change_detail ?? $log->target_name ?? '—' }}
                    </div>
                    <span class="text-[10px] text-slate-600 whitespace-nowrap">{{ $log->created_at->format('H:i') }}</span>
                </div>
            @empty
                <p class="text-sm text-slate-500 py-4">No activity yet.</p>
            @endforelse
        </div>

        {{-- System health --}}
        <div class="rounded-2xl border p-6" style="background-color:#161F38; border-color:#1E2A5E;">
            <h2 class="text-base font-semibold text-white mb-5">System health</h2>
            @foreach ([
                ['label' => 'API uptime',          'value' => '99.98%', 'state' => 'Healthy', 'ok' => true],
                ['label' => 'Database cluster',    'value' => '100%',   'state' => 'Healthy', 'ok' => true],
                ['label' => 'Email delivery',      'value' => '97.2%',  'state' => 'Monitor', 'ok' => null],
                ['label' => 'Trials expiring soon','value' => $counts['trial'], 'state' => 'Review', 'ok' => false],
            ] as $item)
                <div class="flex items-center justify-between py-2.5 border-b last:border-0" style="border-color:#1E2A5E30;">
                    <div>
                        <div class="text-sm text-slate-300">{{ $item['label'] }}</div>
                        <div class="text-xs font-semibold"
                             style="color:{{ $item['ok'] === true ? '#22c55e' : ($item['ok'] === false ? '#f87171' : '#F5A623') }};">
                            {{ $item['value'] }}
                        </div>
                    </div>
                    <span class="inline-flex rounded-full px-2.5 py-0.5 text-[10px] font-semibold"
                          style="background-color:{{ $item['ok'] === true ? '#22c55e20' : ($item['ok'] === false ? '#ef444420' : '#F5A62320') }};
                                 color:{{ $item['ok'] === true ? '#22c55e' : ($item['ok'] === false ? '#f87171' : '#F5A623') }};">
                        {{ $item['state'] }}
                    </span>
                </div>
            @endforeach
        </div>
    </div>
</x-admin-layout>
