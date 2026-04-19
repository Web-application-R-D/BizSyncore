@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'block w-full rounded-lg border border-slate-700 bg-slate-950/70 px-3 py-2.5 text-sm text-slate-100 shadow-sm transition placeholder:text-slate-500 focus:border-amber-400 focus:outline-none focus:ring-2 focus:ring-amber-400/25 disabled:cursor-not-allowed disabled:bg-slate-900 disabled:text-slate-500']) }}>
