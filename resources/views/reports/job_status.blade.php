@extends('reports.layout')

@section('report_content')
    
    <div class="mb-6">
        <h2 class="text-xl font-bold text-[var(--app-text)]">Job Status Overview</h2>
        <p class="text-sm text-[var(--app-muted)] mt-1">Snapshot of how many jobs are currently in each stage.</p>
    </div>

    {{-- Status Cards --}}
    <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-5">
        
        <div class="rounded-2xl border border-[var(--app-border)] bg-[var(--app-surface)] p-6">
            <div class="flex items-center gap-3 mb-2">
                <span class="flex h-3 w-3 rounded-full bg-blue-500"></span>
                <h3 class="text-sm font-medium text-[var(--app-muted)]">Received</h3>
            </div>
            <p class="text-3xl font-bold text-[var(--app-text)]">{{ $statusCounts['received'] }}</p>
        </div>

        <div class="rounded-2xl border border-[var(--app-border)] bg-[var(--app-surface)] p-6">
            <div class="flex items-center gap-3 mb-2">
                <span class="flex h-3 w-3 rounded-full bg-yellow-500"></span>
                <h3 class="text-sm font-medium text-[var(--app-muted)]">In Progress</h3>
            </div>
            <p class="text-3xl font-bold text-[var(--app-text)]">{{ $statusCounts['in_progress'] }}</p>
        </div>

        <div class="rounded-2xl border border-[var(--app-border)] bg-[var(--app-surface)] p-6">
            <div class="flex items-center gap-3 mb-2">
                <span class="flex h-3 w-3 rounded-full bg-orange-500"></span>
                <h3 class="text-sm font-medium text-[var(--app-muted)]">Ready</h3>
            </div>
            <p class="text-3xl font-bold text-[var(--app-text)]">{{ $statusCounts['ready'] }}</p>
        </div>

        <div class="rounded-2xl border border-[var(--app-border)] bg-[var(--app-surface)] p-6">
            <div class="flex items-center gap-3 mb-2">
                <span class="flex h-3 w-3 rounded-full bg-green-500"></span>
                <h3 class="text-sm font-medium text-[var(--app-muted)]">Delivered</h3>
            </div>
            <p class="text-3xl font-bold text-[var(--app-text)]">{{ $statusCounts['delivered'] }}</p>
        </div>

        <div class="rounded-2xl border border-[var(--app-border)] bg-[var(--app-surface)] p-6">
            <div class="flex items-center gap-3 mb-2">
                <span class="flex h-3 w-3 rounded-full bg-gray-500"></span>
                <h3 class="text-sm font-medium text-[var(--app-muted)]">Cancelled</h3>
            </div>
            <p class="text-3xl font-bold text-[var(--app-text)]">{{ $statusCounts['cancelled'] }}</p>
        </div>

    </div>

    {{-- Pipeline Visualization --}}
    <div class="mt-8 rounded-2xl border border-[var(--app-border)] bg-[var(--app-surface)] p-6 w-full">
        <div class="flex items-center justify-between mb-6 border-b border-[var(--app-border)] pb-4">
            <h3 class="text-sm font-extrabold uppercase tracking-widest text-[var(--app-muted)]">Pipeline</h3>
            <span class="text-xs font-bold text-[var(--app-muted)]">{{ array_sum($statusCounts) }} Total Jobs</span>
        </div>

        <div class="space-y-5 w-full">
            @php
                $max = max(1, array_sum($statusCounts));
                $stages = [
                    'received'    => ['color' => 'bg-blue-500',   'text' => 'text-blue-500',   'label' => 'Received'],
                    'in_progress' => ['color' => 'bg-yellow-500', 'text' => 'text-yellow-500', 'label' => 'In Progress'],
                    'ready'       => ['color' => 'bg-orange-500', 'text' => 'text-orange-500', 'label' => 'Ready'],
                    'delivered'   => ['color' => 'bg-green-500',  'text' => 'text-green-500',  'label' => 'Delivered'],
                    'cancelled'   => ['color' => 'bg-gray-400',   'text' => 'text-gray-400',   'label' => 'Cancelled'],
                ];
            @endphp

            @foreach($stages as $status => $meta)
                @php
                    $count = $statusCounts[$status];
                    $percentage = round(($count / $max) * 100);
                @endphp
                <div class="w-full">
                    {{-- Label Row --}}
                    <div class="flex items-center justify-between mb-2 w-full">
                        <div class="flex items-center gap-2">
                            <span class="inline-block h-2.5 w-2.5 rounded-full {{ $meta['color'] }}"></span>
                            <span class="text-sm font-bold text-[var(--app-text)]">{{ $meta['label'] }}</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="inline-flex min-w-[2rem] items-center justify-center rounded-lg border border-[var(--app-border)] bg-[var(--app-bg)] px-2.5 py-0.5 text-sm font-black text-[var(--app-text)]">{{ $count }}</span>
                        </div>
                    </div>
                    {{-- Progress Bar --}}
                    <div class="h-4 w-full rounded-full bg-[var(--app-bg)] overflow-hidden border border-[var(--app-border)]/40">
                        <div class="h-4 rounded-full {{ $meta['color'] }} transition-all duration-700 opacity-85"
                             style="width: {{ $percentage }}%"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection
