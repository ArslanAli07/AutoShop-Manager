@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'mt-1 w-full rounded-2xl border border-[var(--app-border)] bg-transparent px-4 py-3 outline-none focus:border-[var(--app-accent)] focus:ring-2 focus:ring-[var(--app-accent)]/20 transition shadow-sm']) !!}>
