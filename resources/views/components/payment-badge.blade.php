@props(['status', 'variant' => 'compact'])

@if ($variant === 'compact')
    <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-semibold
        @if ($status === 'paid') bg-emerald-500/10 text-emerald-500
        @elseif ($status === 'partial') bg-amber-500/10 text-amber-400
        @else bg-red-500/10 text-red-400
        @endif">
        <span class="h-1.5 w-1.5 flex-shrink-0 rounded-full
            @if ($status === 'paid') bg-emerald-400
            @elseif ($status === 'partial') bg-amber-400
            @else bg-red-400
            @endif"></span>
        @if ($status === 'paid') Paid
        @elseif ($status === 'partial') Partial
        @else Unpaid
        @endif
    </span>
@else
    <span class="inline-flex items-center gap-2 rounded-xl border px-4 py-2 text-sm font-bold shadow-sm
        @if ($status === 'paid') border-emerald-500/30 bg-emerald-500/10 text-emerald-400
        @elseif ($status === 'partial') border-amber-500/30 bg-amber-500/10 text-amber-400
        @else border-red-500/30 bg-red-500/10 text-red-400
        @endif">
        @if ($status === 'paid')
            <svg class="h-4 w-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.5"
                stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M5 13l4 4L19 7" />
            </svg>
            Fully Paid
        @elseif ($status === 'partial')
            <svg class="h-4 w-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.5"
                stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2" />
            </svg>
            Partially Paid
        @else
            <svg class="h-4 w-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.5"
                stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M6 18L18 6M6 6l12 12" />
            </svg>
            Unpaid
        @endif
    </span>
@endif
