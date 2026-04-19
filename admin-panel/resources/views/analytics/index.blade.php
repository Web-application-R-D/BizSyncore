<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <p class="text-xs font-semibold uppercase tracking-widest text-slate-500">Platform</p>
                <h1 class="mt-1 text-2xl font-bold tracking-tight text-white">Analytics & billing</h1>
            </div>
            <div class="flex gap-2">
                @foreach (['7 days', '30 days', '6 months', '1 year'] as $period)
                    <button type="button"
                            class="rounded-lg border px-3 py-1.5 text-xs font-semibold transition"
                            style="{{ $loop->iteration === 3 ? 'background-color:#F5A623; color:#0F1729; border-color:#F5A623;' : 'border-color:#1E2A5E; color:#94a3b8; background-color:#1E2A5E20;' }}">
                        {{ $period }}
                    </button>
                @endforeach
            </div>
        </div>
    </x-slot>

    {{-- KPI cards --}}
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-5 mb-6">
        @foreach ([
            ['label' => 'Total MRR',       'value' => 'LKR ' . number_format($mrr / 1000, 0) . 'K', 'sub' => '+18.2% MoM',        'color' => '#F5A623'],
            ['label' => 'Active clients',  'value' => $counts['active'],                             'sub' => '+3 this month',      'color' => '#22c55e'],
            ['label' => 'Churn rate',      'value' => '3.8%',                                        'sub' => 'Below 5% target',    'color' => '#22c55e'],
            ['label' => 'API uptime',      'value' => '99.98%',                                      'sub' => 'Last 30 days',       'color' => '#22c55e'],
            ['label' => 'Avg rev/client',  'value' => 'LKR ' . number_format($avgMrr / 1000, 1) . 'K', 'sub' => '+LKR 420 vs last mo', 'color' => '#F5A623'],
        ] as $card)
            <div class="rounded-2xl border p-5" style="background-color:#161F38; border-color:#1E2A5E;">
                <p class="text-[10px] font-semibold uppercase tracking-widest text-slate-500">{{ $card['label'] }}</p>
                <p class="mt-2 text-2xl font-bold" style="color:{{ $card['color'] }};">{{ $card['value'] }}</p>
                <p class="mt-1 text-xs" style="color:{{ str_starts_with($card['sub'], '+') ? '#22c55e' : '#64748b' }};">
                    {{ $card['sub'] }}
                </p>
            </div>
        @endforeach
    </div>

    <div class="grid gap-6 lg:grid-cols-[1.7fr_1fr] mb-6">
        {{-- Revenue chart (bar) --}}
        <div class="rounded-2xl border p-6" style="background-color:#161F38; border-color:#1E2A5E;">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-base font-semibold text-white">Monthly recurring revenue (LKR)</h2>
                <span class="text-xs text-slate-500">Last 6 months</span>
            </div>
            @php
                $bars = [
                    ['label' => 'Nov', 'value' => 148000, 'display' => '148K'],
                    ['label' => 'Dec', 'value' => 186000, 'display' => '186K'],
                    ['label' => 'Jan', 'value' => 203000, 'display' => '203K'],
                    ['label' => 'Feb', 'value' => 226000, 'display' => '226K'],
                    ['label' => 'Mar', 'value' => 240000, 'display' => '240K'],
                    ['label' => 'Apr', 'value' => max($mrr, 284000), 'display' => number_format(max($mrr, 284000) / 1000, 0) . 'K', 'highlight' => true],
                ];
                $maxVal = max(array_column($bars, 'value'));
            @endphp
            <div class="flex items-end gap-3 h-40">
                @foreach ($bars as $bar)
                    @php $height = round(($bar['value'] / $maxVal) * 100); @endphp
                    <div class="flex-1 flex flex-col items-center gap-2">
                        <span class="text-[10px] text-slate-500">{{ $bar['display'] }}</span>
                        <div class="w-full rounded-t-md transition-all"
                             style="height:{{ $height }}%; background-color:{{ isset($bar['highlight']) ? '#F5A623' : '#1E2A5E' }}; min-height:4px;">
                        </div>
                        <span class="text-[10px] text-slate-500">{{ $bar['label'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Clients by vertical --}}
        <div class="rounded-2xl border p-6" style="background-color:#161F38; border-color:#1E2A5E;">
            <h2 class="text-base font-semibold text-white mb-4">Clients by vertical</h2>
            @if ($clientsByVertical->isEmpty())
                <p class="text-sm text-slate-500 mt-4">No vertical data yet.</p>
            @else
                @php $maxCount = $clientsByVertical->max('count'); @endphp
                <div class="space-y-3">
                    @foreach ($clientsByVertical as $row)
                        <div class="flex items-center gap-3">
                            <div class="w-28 truncate text-sm text-slate-300">{{ $row->vertical }}</div>
                            <div class="flex-1 h-2 rounded-full" style="background-color:#1E2A5E30;">
                                <div class="h-2 rounded-full" style="width:{{ round(($row->count / $maxCount) * 100) }}%; background-color:#1E2A5E;"></div>
                            </div>
                            <div class="w-6 text-right text-sm font-semibold text-slate-400">{{ $row->count }}</div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-3">
        {{-- Recent invoices --}}
        <div class="rounded-2xl border p-6" style="background-color:#161F38; border-color:#1E2A5E;">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-base font-semibold text-white">Recent invoices</h2>
                <span class="text-xs" style="color:#F5A623;">View all</span>
            </div>
            @forelse ($recentClients as $i => $client)
                <div class="flex items-center justify-between gap-2 py-2.5 border-b last:border-0" style="border-color:#1E2A5E30;">
                    <div>
                        <div class="text-xs text-slate-500 font-mono">INV-{{ str_pad(300 - $i, 4, '0', STR_PAD_LEFT) }}</div>
                        <div class="text-sm text-slate-300 truncate max-w-[120px]">{{ $client->name }}</div>
                    </div>
                    <div class="text-right">
                        <div class="text-sm font-semibold" style="color:{{ $client->status === 'suspended' ? '#f87171' : '#F5A623' }};">
                            LKR {{ number_format($client->mrr ?? 0) }}
                        </div>
                        @if ($client->status === 'suspended')
                            <span class="text-[10px] font-semibold" style="color:#f87171;">Overdue</span>
                        @elseif ($client->status === 'trial')
                            <span class="text-[10px] font-semibold text-slate-500">Pending</span>
                        @else
                            <span class="text-[10px] font-semibold" style="color:#22c55e;">Paid</span>
                        @endif
                    </div>
                </div>
            @empty
                <p class="text-sm text-slate-500">No clients yet.</p>
            @endforelse
        </div>

        {{-- Client growth --}}
        <div class="rounded-2xl border p-6" style="background-color:#161F38; border-color:#1E2A5E;">
            <h2 class="text-base font-semibold text-white mb-4">Client growth</h2>
            <div class="grid grid-cols-3 gap-3 mb-6">
                @foreach ([
                    ['label' => 'New',     'value' => '+' . $counts['trial'],     'color' => '#22c55e'],
                    ['label' => 'Churned', 'value' => '-' . $counts['suspended'], 'color' => '#f87171'],
                    ['label' => 'Net',     'value' => '+' . ($counts['active'] - $counts['suspended']), 'color' => '#22c55e'],
                ] as $item)
                    <div class="rounded-xl border p-3 text-center" style="border-color:#1E2A5E30; background-color:#1E2A5E20;">
                        <p class="text-xl font-bold" style="color:{{ $item['color'] }};">{{ $item['value'] }}</p>
                        <p class="text-[10px] text-slate-500 mt-1">{{ $item['label'] }}</p>
                        <p class="text-[10px] text-slate-600">This month</p>
                    </div>
                @endforeach
            </div>

            <div class="mt-4">
                <p class="text-xs text-slate-500 mb-2">Trial conversion rate</p>
                <div class="h-2 rounded-full" style="background-color:#1E2A5E30;">
                    <div class="h-2 rounded-full" style="width:68%; background-color:#F5A623;"></div>
                </div>
                <p class="mt-2 text-sm font-semibold" style="color:#F5A623;">68% convert to paid plan</p>
            </div>
        </div>

        {{-- Platform health --}}
        <div class="rounded-2xl border p-6" style="background-color:#161F38; border-color:#1E2A5E;">
            <h2 class="text-base font-semibold text-white mb-4">Platform health</h2>
            <div class="space-y-3">
                @foreach ($health as $item)
                    <div class="flex items-center justify-between gap-3">
                        <span class="text-sm text-slate-300">{{ $item['label'] }}</span>
                        <div class="flex items-center gap-2">
                            <span class="text-sm font-semibold"
                                  style="color:{{ $item['ok'] === true ? '#22c55e' : ($item['ok'] === false ? '#f87171' : '#F5A623') }};">
                                {{ $item['value'] }}
                            </span>
                            <span class="inline-flex rounded-full px-2 py-0.5 text-[10px] font-bold"
                                  style="background-color:{{ $item['ok'] === true ? '#22c55e20' : ($item['ok'] === false ? '#ef444420' : '#F5A62320') }};
                                         color:{{ $item['ok'] === true ? '#22c55e' : ($item['ok'] === false ? '#f87171' : '#F5A623') }};">
                                {{ $item['state'] }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-admin-layout>
