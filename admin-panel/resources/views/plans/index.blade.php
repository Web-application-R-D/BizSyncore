<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <p class="text-xs font-semibold uppercase tracking-widest text-slate-500">Management</p>
                <h1 class="mt-1 text-2xl font-bold tracking-tight text-white">Plans & pricing</h1>
            </div>
            <button type="button"
                    class="inline-flex items-center rounded-lg px-4 py-2 text-sm font-semibold shadow-lg transition"
                    style="background-color:#F5A623; color:#0F1729;">
                + New plan
            </button>
        </div>
    </x-slot>

    @if (session('status'))
        <div class="mb-6 flex items-center gap-3 rounded-xl border border-emerald-500/30 bg-emerald-500/10 px-4 py-3 text-sm text-emerald-300">
            <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            {{ session('status') }}
        </div>
    @endif

    {{-- Plan cards --}}
    <div class="grid gap-6 lg:grid-cols-3">
        @foreach ($plans as $key => $plan)
            <div class="relative flex flex-col rounded-2xl border transition"
                 style="background-color:#161F38; border-color:{{ isset($plan['popular']) ? '#F5A623' : '#1E2A5E' }};">

                @if (isset($plan['popular']))
                    <div class="absolute -top-3 left-1/2 -translate-x-1/2">
                        <span class="inline-flex rounded-full px-3 py-1 text-[10px] font-bold uppercase tracking-widest"
                              style="background-color:#F5A623; color:#0F1729;">
                            Most popular
                        </span>
                    </div>
                @endif

                <div class="p-6 border-b" style="border-color:#1E2A5E;">
                    <p class="text-base font-semibold text-white">{{ $plan['label'] }}</p>
                    <p class="mt-2 text-3xl font-bold text-white">
                        LKR {{ number_format($plan['price']) }}
                    </p>
                    <p class="mt-1 text-xs text-slate-500">{{ $plan['per'] }}</p>

                    <div class="mt-4 flex items-center justify-between rounded-lg px-3 py-2"
                         style="background-color:#1E2A5E40;">
                        <span class="text-xs text-slate-400">Active clients</span>
                        <span class="text-sm font-bold" style="color:#F5A623;">
                            {{ $clientCounts[$key] ?? 0 }}
                        </span>
                    </div>
                </div>

                <div class="flex-1 p-6 space-y-3">
                    @foreach ($plan['features'] as $feature)
                        <div class="flex items-center gap-3 text-sm">
                            @if ($feature['enabled'])
                                <svg class="h-4 w-4 shrink-0" style="color:#22c55e;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span class="text-slate-300">{{ $feature['label'] }}</span>
                            @else
                                <svg class="h-4 w-4 shrink-0 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                <span class="text-slate-600">{{ $feature['label'] }}</span>
                            @endif
                        </div>
                    @endforeach
                </div>

                <div class="flex gap-2 p-6 pt-0">
                    <button type="button"
                            class="flex-1 rounded-lg border py-2 text-sm font-semibold text-slate-300 transition hover:text-white"
                            style="border-color:#1E2A5E; background-color:#1E2A5E30;">
                        Edit plan
                    </button>
                    <button type="button"
                            class="rounded-lg border px-4 py-2 text-sm font-semibold transition"
                            style="border-color:#ef444440; background-color:#ef444415; color:#f87171;"
                            onmouseover="this.style.backgroundColor='#ef444425'" onmouseout="this.style.backgroundColor='#ef444415'">
                        Delete
                    </button>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Revenue breakdown --}}
    <div class="mt-6 rounded-2xl border p-6" style="background-color:#161F38; border-color:#1E2A5E;">
        <h2 class="text-base font-semibold text-white">Revenue breakdown by plan</h2>
        <div class="mt-4 grid gap-4 sm:grid-cols-3">
            @foreach ([
                ['key' => 'small',  'label' => 'Small plan MRR',  'clients' => $clientCounts['small']  ?? 0, 'price' => 1800],
                ['key' => 'medium', 'label' => 'Medium plan MRR', 'clients' => $clientCounts['medium'] ?? 0, 'price' => 4800],
                ['key' => 'large',  'label' => 'Large plan MRR',  'clients' => $clientCounts['large']  ?? 0, 'price' => 12500],
            ] as $row)
                <div class="rounded-xl border p-4" style="background-color:#1E2A5E30; border-color:#1E2A5E;">
                    <p class="text-[10px] font-semibold uppercase tracking-widest text-slate-500">{{ $row['label'] }}</p>
                    <p class="mt-2 text-2xl font-bold" style="color:#F5A623;">
                        LKR {{ number_format($mrr[$row['key']]) }}
                    </p>
                    <p class="mt-1 text-xs text-slate-500">
                        {{ $row['clients'] }} clients × LKR {{ number_format($row['price']) }}
                    </p>
                </div>
            @endforeach
        </div>
    </div>
</x-admin-layout>
