<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <p class="text-xs font-semibold uppercase tracking-widest text-slate-500">Management</p>
                <h1 class="mt-1 text-2xl font-bold tracking-tight text-white">Client management</h1>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-sm text-slate-500">{{ $counts['total'] }} total clients</span>
                <a href="{{ route('clients.create') }}"
                   class="inline-flex items-center rounded-lg px-4 py-2 text-sm font-semibold shadow-lg transition"
                   style="background-color:#F5A623; color:#0F1729;">
                    + New client
                </a>
            </div>
        </div>
    </x-slot>

    @if (session('status'))
        <div class="mb-6 flex items-center gap-3 rounded-xl border border-emerald-500/30 bg-emerald-500/10 px-4 py-3 text-sm text-emerald-300">
            <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            {{ session('status') }}
        </div>
    @endif

    {{-- Stats cards --}}
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4 mb-6">
        @foreach ([
            ['label' => 'Total',     'value' => $counts['total'],     'color' => '#e2e8f0'],
            ['label' => 'Active',    'value' => $counts['active'],    'color' => '#22c55e'],
            ['label' => 'Trial',     'value' => $counts['trial'],     'color' => '#F5A623'],
            ['label' => 'Suspended', 'value' => $counts['suspended'], 'color' => '#f87171'],
        ] as $card)
            <div class="rounded-2xl border p-5" style="background-color:#161F38; border-color:#1E2A5E;">
                <p class="text-[10px] font-semibold uppercase tracking-widest text-slate-500">{{ $card['label'] }}</p>
                <p class="mt-2 text-3xl font-bold" style="color:{{ $card['color'] }};">{{ $card['value'] }}</p>
            </div>
        @endforeach
    </div>

    {{-- Filters --}}
    <div class="rounded-2xl border p-5 mb-4" style="background-color:#161F38; border-color:#1E2A5E;">
        <form method="GET" action="{{ route('clients.index') }}" class="space-y-4">
            <div class="grid gap-4 lg:grid-cols-3">
                <div class="relative">
                    <svg class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" name="search" placeholder="Search client name, company..."
                           value="{{ request('search') }}"
                           class="block w-full rounded-lg border py-2.5 pl-9 pr-4 text-sm placeholder:text-slate-500 focus:outline-none focus:ring-2"
                           style="background-color:#0F1729; border-color:#1E2A5E; color:#e2e8f0;">
                </div>
                <select name="plan"
                        class="block w-full rounded-lg border px-3 py-2.5 text-sm focus:outline-none"
                        style="background-color:#0F1729; border-color:#1E2A5E; color:#e2e8f0;">
                    <option value="">All plans</option>
                    <option value="small"  {{ request('plan') === 'small'  ? 'selected' : '' }}>Small</option>
                    <option value="medium" {{ request('plan') === 'medium' ? 'selected' : '' }}>Medium</option>
                    <option value="large"  {{ request('plan') === 'large'  ? 'selected' : '' }}>Large</option>
                </select>
                <select name="vertical"
                        class="block w-full rounded-lg border px-3 py-2.5 text-sm focus:outline-none"
                        style="background-color:#0F1729; border-color:#1E2A5E; color:#e2e8f0;">
                    <option value="">All verticals</option>
                    @foreach ($verticals as $v)
                        <option value="{{ $v }}" {{ request('vertical') === $v ? 'selected' : '' }}>{{ $v }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('clients.index') }}"
                   class="inline-flex rounded-full px-3 py-1 text-xs font-semibold transition"
                   style="{{ !request('status') ? 'background-color:#F5A62320; color:#F5A623;' : 'background-color:#1E2A5E30; color:#94a3b8;' }}">
                    All ({{ $counts['total'] }})
                </a>
                <a href="{{ route('clients.index', ['status' => 'active']) }}"
                   class="inline-flex rounded-full px-3 py-1 text-xs font-semibold transition"
                   style="{{ request('status') === 'active' ? 'background-color:#22c55e20; color:#22c55e;' : 'background-color:#1E2A5E30; color:#94a3b8;' }}">
                    Active ({{ $counts['active'] }})
                </a>
                <a href="{{ route('clients.index', ['status' => 'trial']) }}"
                   class="inline-flex rounded-full px-3 py-1 text-xs font-semibold transition"
                   style="{{ request('status') === 'trial' ? 'background-color:#F5A62320; color:#F5A623;' : 'background-color:#1E2A5E30; color:#94a3b8;' }}">
                    Trial ({{ $counts['trial'] }})
                </a>
                <a href="{{ route('clients.index', ['status' => 'suspended']) }}"
                   class="inline-flex rounded-full px-3 py-1 text-xs font-semibold transition"
                   style="{{ request('status') === 'suspended' ? 'background-color:#ef444420; color:#f87171;' : 'background-color:#1E2A5E30; color:#94a3b8;' }}">
                    Suspended ({{ $counts['suspended'] }})
                </a>
                <button type="submit" class="ml-auto inline-flex rounded-full px-3 py-1 text-xs font-semibold transition"
                        style="background-color:#1E2A5E; color:#e2e8f0;">
                    Apply filter
                </button>
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="overflow-hidden rounded-2xl border" style="background-color:#161F38; border-color:#1E2A5E;">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                    <tr style="background-color:#1E2A5E30;">
                        <th class="w-6 px-5 py-3.5">
                            <input type="checkbox" class="rounded" style="border-color:#1E2A5E; background-color:#0F1729;">
                        </th>
                        <th class="px-5 py-3.5 text-left text-[10px] font-semibold uppercase tracking-widest text-slate-400">Client</th>
                        <th class="px-5 py-3.5 text-left text-[10px] font-semibold uppercase tracking-widest text-slate-400">Access code</th>
                        <th class="px-5 py-3.5 text-left text-[10px] font-semibold uppercase tracking-widest text-slate-400">Plan</th>
                        <th class="px-5 py-3.5 text-left text-[10px] font-semibold uppercase tracking-widest text-slate-400">Users</th>
                        <th class="px-5 py-3.5 text-left text-[10px] font-semibold uppercase tracking-widest text-slate-400">Status</th>
                        <th class="px-5 py-3.5 text-left text-[10px] font-semibold uppercase tracking-widest text-slate-400">Joined</th>
                        <th class="px-5 py-3.5 text-left text-[10px] font-semibold uppercase tracking-widest text-slate-400">MRR</th>
                        <th class="px-5 py-3.5 text-left text-[10px] font-semibold uppercase tracking-widest text-slate-400">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y" style="border-color:#1E2A5E30;">
                    @forelse ($clients as $client)
                        <tr class="transition" onmouseover="this.style.backgroundColor='#1E2A5E20'" onmouseout="this.style.backgroundColor=''">
                            <td class="px-5 py-4">
                                <input type="checkbox" class="rounded" style="border-color:#1E2A5E; background-color:#0F1729;">
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg text-xs font-bold"
                                         style="background-color:#F5A62315; color:#F5A623;">
                                        {{ strtoupper(substr($client->name, 0, 2)) }}
                                    </div>
                                    <div class="min-w-0">
                                        <div class="truncate font-semibold text-white">{{ $client->name }}</div>
                                        <div class="truncate text-xs text-slate-500">
                                            {{ $client->vertical ?? $client->company_name ?? '—' }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-4">
                                <code class="rounded-md px-2.5 py-1 font-mono text-xs font-semibold"
                                      style="background-color:#F5A62315; color:#F5A623;">
                                    {{ $client->client_access_code }}
                                </code>
                            </td>
                            <td class="px-5 py-4">
                                <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-semibold capitalize"
                                      style="background-color:#1E2A5E; color:#e2e8f0;">
                                    {{ $client->plan ?? '—' }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-sm text-slate-400">
                                {{ $client->users }}/{{ $client->user_limit }}
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
                            <td class="px-5 py-4 text-sm text-slate-400 whitespace-nowrap">
                                {{ $client->joined_at?->format('M Y') ?? '—' }}
                            </td>
                            <td class="px-5 py-4 font-semibold whitespace-nowrap"
                                style="color:{{ $client->mrr > 0 ? '#22c55e' : '#94a3b8' }};">
                                {{ $client->mrr > 0 ? 'LKR ' . number_format($client->mrr, 0) : '—' }}
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex flex-wrap gap-1.5">
                                    <a href="{{ route('clients.edit', $client) }}"
                                       class="rounded-lg border px-2.5 py-1 text-xs font-semibold transition"
                                       style="border-color:#F5A62340; background-color:#F5A62315; color:#F5A623;">
                                        Edit
                                    </a>

                                    @if ($client->status === 'active')
                                        <form method="POST" action="{{ route('clients.updateStatus', $client) }}">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status" value="suspended">
                                            <button type="submit"
                                                    class="rounded-lg border px-2.5 py-1 text-xs font-semibold transition"
                                                    style="border-color:#ef444440; background-color:#ef444415; color:#f87171;">
                                                Suspend
                                            </button>
                                        </form>
                                    @elseif ($client->status === 'trial')
                                        <form method="POST" action="{{ route('clients.updateStatus', $client) }}">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status" value="active">
                                            <button type="submit"
                                                    class="rounded-lg border px-2.5 py-1 text-xs font-semibold transition"
                                                    style="border-color:#22c55e40; background-color:#22c55e15; color:#22c55e;">
                                                Activate
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('clients.updateStatus', $client) }}">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status" value="suspended">
                                            <button type="submit"
                                                    class="rounded-lg border px-2.5 py-1 text-xs font-semibold transition"
                                                    style="border-color:#ef444440; background-color:#ef444415; color:#f87171;">
                                                Reject
                                            </button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('clients.updateStatus', $client) }}">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status" value="active">
                                            <button type="submit"
                                                    class="rounded-lg border px-2.5 py-1 text-xs font-semibold transition"
                                                    style="border-color:#22c55e40; background-color:#22c55e15; color:#22c55e;">
                                                Restore
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('clients.destroy', $client) }}"
                                              onsubmit="return confirm('Permanently delete {{ addslashes($client->name) }}?')">
                                            @csrf @method('DELETE')
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
                            <td colspan="9" class="px-5 py-16 text-center">
                                <div class="mx-auto max-w-sm">
                                    <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl"
                                         style="background-color:#1E2A5E30;">
                                        <svg class="h-7 w-7 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                    </div>
                                    <p class="text-sm font-medium text-slate-300">No clients found</p>
                                    <a href="{{ route('clients.create') }}"
                                       class="mt-4 inline-flex items-center rounded-lg px-4 py-2 text-sm font-semibold transition"
                                       style="background-color:#F5A623; color:#0F1729;">
                                        + New client
                                    </a>
                                </div>
                            </td>
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
