<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center rounded-lg bg-amber-400 px-5 py-2.5 text-sm font-semibold text-slate-950 shadow-sm shadow-amber-400/25 transition hover:bg-amber-300 focus:outline-none focus:ring-2 focus:ring-amber-400 focus:ring-offset-2 focus:ring-offset-slate-900 active:bg-amber-500 disabled:opacity-50']) }}>
    {{ $slot }}
</button>
