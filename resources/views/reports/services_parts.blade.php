@extends('reports.layout')

@section('report_content')
    
    <div class="grid gap-6 lg:grid-cols-2">
        
        {{-- Most Common Services --}}
        <div class="rounded-2xl border border-[var(--app-border)] bg-[var(--app-surface)] overflow-hidden flex flex-col">
            <div class="p-6 border-b border-[var(--app-border)]">
                <h3 class="text-sm font-bold text-[var(--app-text)]">Top Performed Services</h3>
                <p class="mt-1 text-xs text-[var(--app-muted)]">Services completed most often in this period.</p>
            </div>
            <div class="overflow-x-auto flex-1">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="border-b border-[var(--app-border)] bg-[var(--app-bg)] text-[var(--app-muted)]">
                            <th class="px-6 py-4 font-medium">Service Name</th>
                            <th class="px-6 py-4 font-medium text-center">Times Performed</th>
                            <th class="px-6 py-4 font-medium text-right">Revenue Generated</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[var(--app-border)] text-[var(--app-text)]">
                        @forelse($services as $service)
                            <tr class="transition hover:bg-[var(--app-bg)]">
                                <td class="px-6 py-4 font-medium">{{ $service->name }}</td>
                                <td class="px-6 py-4 text-center">{{ $service->count }}</td>
                                <td class="px-6 py-4 text-right">Rs. {{ number_format($service->total_revenue) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-8 text-center text-[var(--app-muted)]">No services performed in this period.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Most Used Parts --}}
        <div class="rounded-2xl border border-[var(--app-border)] bg-[var(--app-surface)] overflow-hidden flex flex-col">
            <div class="p-6 border-b border-[var(--app-border)]">
                <h3 class="text-sm font-bold text-[var(--app-text)]">Top Parts Used</h3>
                <p class="mt-1 text-xs text-[var(--app-muted)]">Parts consumed most frequently in this period.</p>
            </div>
            <div class="overflow-x-auto flex-1">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="border-b border-[var(--app-border)] bg-[var(--app-bg)] text-[var(--app-muted)]">
                            <th class="px-6 py-4 font-medium">Part Name</th>
                            <th class="px-6 py-4 font-medium text-center">Quantity Used</th>
                            <th class="px-6 py-4 font-medium text-right">Revenue Generated</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[var(--app-border)] text-[var(--app-text)]">
                        @forelse($parts as $part)
                            <tr class="transition hover:bg-[var(--app-bg)]">
                                <td class="px-6 py-4 font-medium">{{ $part->name }}</td>
                                <td class="px-6 py-4 text-center">{{ $part->total_quantity }}</td>
                                <td class="px-6 py-4 text-right">Rs. {{ number_format($part->total_revenue) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-8 text-center text-[var(--app-muted)]">No parts used in this period.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

@endsection
