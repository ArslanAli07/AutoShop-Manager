@props(['status', 'variant' => 'compact'])

@if ($variant === 'compact')
    <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-semibold
        @if ($status === 'received') bg-blue-500/10 text-blue-500
        @elseif ($status === 'in_progress') bg-amber-500/10 text-amber-500
        @elseif ($status === 'ready') bg-emerald-500/10 text-emerald-500
        @elseif ($status === 'delivered') bg-gray-400/10 text-gray-400
        @else bg-red-500/10 text-red-400
        @endif">
        <span class="h-1.5 w-1.5 flex-shrink-0 rounded-full
            @if ($status === 'received') bg-blue-500
            @elseif ($status === 'in_progress') bg-amber-500
            @elseif ($status === 'ready') bg-emerald-500
            @elseif ($status === 'delivered') bg-gray-400
            @else bg-red-400
            @endif"></span>
        @if ($status === 'received') Car Received
        @elseif ($status === 'in_progress') Repairing
        @elseif ($status === 'ready') Ready for Pickup
        @elseif ($status === 'delivered') Delivered
        @else Cancelled
        @endif
    </span>
@else
    <span class="inline-flex items-center gap-2 rounded-xl border px-4 py-2 text-sm font-bold shadow-sm
        @if ($status === 'received') border-blue-500/30 bg-blue-500/10 text-blue-400
        @elseif ($status === 'in_progress') border-amber-500/30 bg-amber-500/10 text-amber-400
        @elseif ($status === 'ready') border-emerald-500/30 bg-emerald-500/10 text-emerald-400
        @elseif ($status === 'delivered') border-gray-500/30 bg-gray-500/10 text-gray-400
        @else border-red-500/30 bg-red-500/10 text-red-400
        @endif">
        @if ($status === 'received')
            <svg class="h-4 w-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 100-6 3 3 0 000 6z" />
            </svg>
            Car Received
        @elseif ($status === 'in_progress')
            <svg class="h-4 w-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z" />
            </svg>
            Repairing
        @elseif ($status === 'ready')
            <svg class="h-4 w-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Ready for Pickup
        @elseif ($status === 'delivered')
            <svg class="h-4 w-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M5 13l4 4L19 7" />
            </svg>
            Delivered
        @else
            <svg class="h-4 w-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M6 18L18 6M6 6l12 12" />
            </svg>
            Cancelled
        @endif
    </span>
@endif
