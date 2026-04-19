<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <p class="text-xs font-semibold uppercase tracking-widest text-slate-500">Management</p>
                <h1 class="mt-1 text-2xl font-bold tracking-tight text-white">Access code management</h1>
            </div>
            <span class="text-xs text-slate-500">All codes are hashed in the database — display only</span>
        </div>
    </x-slot>

    @if (session('status'))
        <div class="mb-6 flex items-center gap-3 rounded-xl border border-emerald-500/30 bg-emerald-500/10 px-4 py-3 text-sm text-emerald-300">
            <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            {{ session('status') }}
        </div>
    @endif

    {{-- Stat cards --}}
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4 mb-6">
        @foreach ([
            ['label' => 'Total codes',    'value' => $counts['total'],     'sub' => 'One per client',          'color' => '#e2e8f0'],
            ['label' => 'Active codes',   'value' => $counts['active'],    'sub' => 'Resolving correctly',     'color' => '#22c55e'],
            ['label' => 'Suspended',      'value' => $counts['suspended'], 'sub' => 'Return 403 on lookup',    'color' => '#ef4444'],
            ['label' => 'Lookups today',  'value' => '—',                  'sub' => 'API resolve calls',       'color' => '#F5A623'],
        ] as $card)
            <div class="rounded-2xl border p-5" style="background-color:#161F38; border-color:#1E2A5E;">
                <p class="text-[10px] font-semibold uppercase tracking-widest text-slate-500">{{ $card['label'] }}</p>
                <p class="mt-2 text-3xl font-bold" style="color:{{ $card['color'] }};">{{ $card['value'] }}</p>
                <p class="mt-1 text-xs text-slate-500">{{ $card['sub'] }}</p>
            </div>
        @endforeach
    </div>

    {{-- Filters --}}
    <form method="GET" action="{{ route('access-codes.index') }}" class="mb-4 flex flex-wrap items-center gap-3">
        <div class="relative flex-1 min-w-48">
            <svg class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" name="search" placeholder="Search client or code..."
                   value="{{ request('search') }}"
                   class="block w-full rounded-lg border py-2 pl-9 pr-4 text-sm placeholder:text-slate-500 focus:outline-none focus:ring-2"
                   style="background-color:#161F38; border-color:#1E2A5E; color:#e2e8f0; --tw-ring-color:#F5A62340;">
        </div>
        <select name="status"
                class="rounded-lg border py-2 px-3 text-sm focus:outline-none"
                style="background-color:#161F38; border-color:#1E2A5E; color:#e2e8f0;"
                onchange="this.form.submit()">
            <option value="">All status</option>
            <option value="active"    {{ request('status') === 'active'    ? 'selected' : '' }}>Active</option>
            <option value="trial"     {{ request('status') === 'trial'     ? 'selected' : '' }}>Trial</option>
            <option value="suspended" {{ request('status') === 'suspended' ? 'selected' : '' }}>Suspended</option>
        </select>
        <button type="button" class="rounded-lg border px-4 py-2 text-sm font-medium text-slate-300 transition hover:text-white"
                style="border-color:#1E2A5E;">
            Export CSV
        </button>
    </form>

    {{-- Table --}}
    <div class="overflow-hidden rounded-2xl border" style="background-color:#161F38; border-color:#1E2A5E;">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                    <tr style="background-color:#1E2A5E30;">
                        <th class="px-5 py-3.5 text-left text-[10px] font-semibold uppercase tracking-widest text-slate-400">Access code</th>
                        <th class="px-5 py-3.5 text-left text-[10px] font-semibold uppercase tracking-widest text-slate-400">Client</th>
                        <th class="px-5 py-3.5 text-left text-[10px] font-semibold uppercase tracking-widest text-slate-400">Status</th>
                        <th class="px-5 py-3.5 text-left text-[10px] font-semibold uppercase tracking-widest text-slate-400">Generated</th>
                        <th class="px-5 py-3.5 text-left text-[10px] font-semibold uppercase tracking-widest text-slate-400">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y" style="border-color:#1E2A5E;">
                    @forelse ($clients as $client)
                        <tr class="transition" style="border-color:#1E2A5E40;"
                            onmouseover="this.style.backgroundColor='#1E2A5E20'" onmouseout="this.style.backgroundColor=''">
                            <td class="px-5 py-4">
                                <code class="rounded-md px-2.5 py-1 font-mono text-xs font-semibold"
                                      style="background-color:#F5A62315; color:#F5A623;">
                                    {{ $client->client_access_code }}
                                </code>
                            </td>
                            <td class="px-5 py-4">
                                <div class="font-semibold text-white">{{ $client->name }}</div>
                                <div class="text-xs text-slate-500">{{ $client->vertical ?? '—' }}</div>
                            </td>
                            <td class="px-5 py-4">
                                @if ($client->status === 'active')
                                    <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-semibold" style="background-color:#22c55e20; color:#22c55e;">Active</span>
                                @elseif ($client->status === 'trial')
                                    <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-semibold" style="background-color:#F5A62320; color:#F5A623;">Trial</span>
                                @else
                                    <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-semibold" style="background-color:#ef444420; color:#f87171;">Suspended</span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-sm text-slate-400">
                                {{ $client->joined_at?->format('M Y') ?? '—' }}
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex flex-wrap gap-2">
                                    {{-- Copy button (client-side) --}}
                                    <button type="button"
                                            onclick="navigator.clipboard.writeText('{{ $client->client_access_code }}').then(()=>{ this.textContent='Copied!'; setTimeout(()=>this.textContent='Copy',1500); })"
                                            class="rounded-lg border px-2.5 py-1 text-xs font-semibold text-slate-300 transition hover:text-white"
                                            style="border-color:#1E2A5E; background-color:#1E2A5E30;">
                                        Copy
                                    </button>

                                    {{-- Regenerate --}}
                                    @if ($client->status !== 'suspended')
                                        <form method="POST" action="{{ route('access-codes.regen', $client) }}">
                                            @csrf
                                            <button type="submit"
                                                    class="rounded-lg border px-2.5 py-1 text-xs font-semibold transition"
                                                    style="border-color:#F5A62340; background-color:#F5A62315; color:#F5A623;"
                                                    onmouseover="this.style.backgroundColor='#F5A62325'" onmouseout="this.style.backgroundColor='#F5A62315'">
                                                Regenerate
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Disable / Re-enable --}}
                                    <form method="POST" action="{{ route('access-codes.toggleStatus', $client) }}">
                                        @csrf
                                        @method('PATCH')
                                        @if ($client->status === 'suspended')
                                            <button type="submit"
                                                    class="rounded-lg border px-2.5 py-1 text-xs font-semibold transition"
                                                    style="border-color:#22c55e40; background-color:#22c55e15; color:#22c55e;">
                                                Re-enable
                                            </button>
                                        @else
                                            <button type="submit"
                                                    class="rounded-lg border px-2.5 py-1 text-xs font-semibold transition"
                                                    style="border-color:#ef444440; background-color:#ef444415; color:#f87171;"
                                                    onmouseover="this.style.backgroundColor='#ef444425'" onmouseout="this.style.backgroundColor='#ef444415'">
                                                Disable
                                            </button>
                                        @endif
                                    </form>

                                    @if ($client->status === 'suspended')
                                        <form method="POST" action="{{ route('clients.destroy', $client) }}"
                                              onsubmit="return confirm('Delete this client and their access code permanently?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="rounded-lg border px-2.5 py-1 text-xs font-semibold transition"
                                                    style="border-color:#ef444440; background-color:#ef444415; color:#f87171;">
                                                Delete
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-16 text-center text-slate-500">No access codes found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($clients->hasPages())
            <div class="border-t px-5 py-3" style="border-color:#1E2A5E;">
                {{ $clients->links() }}
            </div>
        @endif
    </div>
</x-admin-layout>
