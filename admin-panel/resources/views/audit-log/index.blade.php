<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <p class="text-xs font-semibold uppercase tracking-widest text-slate-500">Platform</p>
                <h1 class="mt-1 text-2xl font-bold tracking-tight text-white">Audit log</h1>
            </div>
            <button type="button"
                    class="rounded-lg border px-4 py-2 text-sm font-medium text-slate-300 transition hover:text-white"
                    style="border-color:#1E2A5E; background-color:#1E2A5E30;">
                Export CSV
            </button>
        </div>
    </x-slot>

    {{-- Filters --}}
    <form method="GET" action="{{ route('audit-log.index') }}"
          class="mb-6 flex flex-wrap gap-3">
        <div class="relative flex-1 min-w-56">
            <svg class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" name="search" placeholder="Search action, client, admin..."
                   value="{{ request('search') }}"
                   class="block w-full rounded-lg border py-2 pl-9 pr-4 text-sm placeholder:text-slate-500 focus:outline-none"
                   style="background-color:#161F38; border-color:#1E2A5E; color:#e2e8f0;">
        </div>

        <select name="action"
                class="rounded-lg border py-2 px-3 text-sm focus:outline-none"
                style="background-color:#161F38; border-color:#1E2A5E; color:#e2e8f0;"
                onchange="this.form.submit()">
            <option value="">All actions</option>
            @foreach ($actions as $action)
                <option value="{{ $action }}" {{ request('action') === $action ? 'selected' : '' }}>
                    {{ ucfirst(str_replace('_', ' ', $action)) }}
                </option>
            @endforeach
        </select>

        <select name="admin"
                class="rounded-lg border py-2 px-3 text-sm focus:outline-none"
                style="background-color:#161F38; border-color:#1E2A5E; color:#e2e8f0;"
                onchange="this.form.submit()">
            <option value="">All admins</option>
            @foreach ($admins as $admin)
                <option value="{{ $admin->id }}" {{ request('admin') == $admin->id ? 'selected' : '' }}>
                    {{ $admin->name }}
                </option>
            @endforeach
        </select>

        <button type="submit"
                class="rounded-lg border px-4 py-2 text-sm font-semibold text-slate-300 transition hover:text-white"
                style="border-color:#1E2A5E; background-color:#1E2A5E40;">
            Filter
        </button>
    </form>

    {{-- Log table --}}
    <div class="overflow-hidden rounded-2xl border" style="background-color:#161F38; border-color:#1E2A5E;">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                    <tr style="background-color:#1E2A5E30;">
                        <th class="px-5 py-3.5 text-left text-[10px] font-semibold uppercase tracking-widest text-slate-400">Timestamp</th>
                        <th class="px-5 py-3.5 text-left text-[10px] font-semibold uppercase tracking-widest text-slate-400">Admin</th>
                        <th class="px-5 py-3.5 text-left text-[10px] font-semibold uppercase tracking-widest text-slate-400">Action</th>
                        <th class="px-5 py-3.5 text-left text-[10px] font-semibold uppercase tracking-widest text-slate-400">Change detail</th>
                        <th class="px-5 py-3.5 text-left text-[10px] font-semibold uppercase tracking-widest text-slate-400">Target</th>
                    </tr>
                </thead>
                <tbody class="divide-y" style="border-color:#1E2A5E30;">
                    @forelse ($logs as $log)
                        @php
                            $actionStyles = match ($log->action) {
                                'create'      => ['bg' => '#22c55e15', 'color' => '#22c55e',  'label' => 'Create'],
                                'update'      => ['bg' => '#3b82f615', 'color' => '#60a5fa',  'label' => 'Update'],
                                'suspend'     => ['bg' => '#ef444415', 'color' => '#f87171',  'label' => 'Suspend'],
                                'activate'    => ['bg' => '#22c55e15', 'color' => '#22c55e',  'label' => 'Activate'],
                                'restore'     => ['bg' => '#22c55e15', 'color' => '#22c55e',  'label' => 'Restore'],
                                'delete'      => ['bg' => '#ef444415', 'color' => '#f87171',  'label' => 'Delete'],
                                'regen_code'  => ['bg' => '#F5A62315', 'color' => '#F5A623',  'label' => 'Regen code'],
                                'login'       => ['bg' => '#8b5cf615', 'color' => '#a78bfa',  'label' => 'Login'],
                                default       => ['bg' => '#1E2A5E40', 'color' => '#94a3b8',  'label' => ucfirst($log->action)],
                            };
                        @endphp
                        <tr onmouseover="this.style.backgroundColor='#1E2A5E20'" onmouseout="this.style.backgroundColor=''">
                            <td class="px-5 py-4 text-slate-400 whitespace-nowrap">
                                {{ $log->created_at->format('h:i:s A') }}
                                @if (!$log->created_at->isToday())
                                    <br><span class="text-xs text-slate-600">{{ $log->created_at->format('M d') }}</span>
                                @endif
                            </td>
                            <td class="px-5 py-4 font-semibold text-white whitespace-nowrap">
                                {{ $log->user ? Str::limit($log->user->name, 12) : '—' }}
                            </td>
                            <td class="px-5 py-4">
                                <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-bold"
                                      style="background-color:{{ $actionStyles['bg'] }}; color:{{ $actionStyles['color'] }};">
                                    {{ $actionStyles['label'] }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-slate-300 max-w-xs">
                                {{ $log->change_detail ?? '—' }}
                            </td>
                            <td class="px-5 py-4">
                                <div class="font-semibold text-white">{{ $log->target_name ?? '—' }}</div>
                                @if ($log->target_id)
                                    <div class="text-[10px] text-slate-600 font-mono">
                                        {{ $log->target_type }}:{{ $log->target_id }}
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-16 text-center text-slate-500">
                                No audit log entries yet. Actions will be recorded here as they happen.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($logs->hasPages())
            <div class="border-t px-5 py-3" style="border-color:#1E2A5E;">
                {{ $logs->links() }}
            </div>
        @endif
    </div>
</x-admin-layout>
