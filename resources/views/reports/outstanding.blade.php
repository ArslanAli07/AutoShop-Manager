@extends('reports.layout')

@section('report_content')
    
    {{-- Summary Cards --}}
    <div class="mb-8 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
        <div class="rounded-2xl border border-[var(--app-border)] bg-[var(--app-surface)] p-6">
            <h3 class="text-sm font-medium text-[var(--app-muted)]">Total Outstanding</h3>
            <p class="mt-2 text-2xl font-bold text-red-600 dark:text-red-400">Rs. {{ number_format($totalOutstanding) }}</p>
        </div>
        <div class="rounded-2xl border border-[var(--app-border)] bg-[var(--app-surface)] p-6">
            <h3 class="text-sm font-medium text-[var(--app-muted)]">Unpaid / Partial Jobs</h3>
            <p class="mt-2 text-2xl font-bold text-[var(--app-text)]">{{ $jobs->count() }}</p>
        </div>
    </div>

    {{-- Outstanding Jobs Table --}}
    <div class="rounded-2xl border border-[var(--app-border)] bg-[var(--app-surface)] overflow-hidden">
        <div class="p-6 border-b border-[var(--app-border)]">
            <h3 class="text-sm font-bold text-[var(--app-text)]">Jobs with Pending Balances</h3>
            <p class="mt-1 text-xs text-[var(--app-muted)]">Showing all time unpaid and partially paid jobs.</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b border-[var(--app-border)] bg-[var(--app-bg)] text-[var(--app-muted)]">
                        <th class="px-6 py-4 font-medium">Date</th>
                        <th class="px-6 py-4 font-medium">Job Number</th>
                        <th class="px-6 py-4 font-medium">Customer</th>
                        <th class="px-6 py-4 font-medium">Vehicle</th>
                        <th class="px-6 py-4 font-medium text-right">Total Amount</th>
                        <th class="px-6 py-4 font-medium text-right">Amount Paid</th>
                        <th class="px-6 py-4 font-medium text-right text-red-600 dark:text-red-400">Balance Due</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[var(--app-border)] text-[var(--app-text)]">
                    @forelse($jobs as $job)
                        <tr class="transition hover:bg-[var(--app-bg)]">
                            <td class="px-6 py-4">{{ $job->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4">
                                <a href="{{ route('jobs.show', $job->id) }}" class="font-medium text-[var(--app-accent)] hover:underline">
                                    {{ $job->job_number }}
                                </a>
                            </td>
                            <td class="px-6 py-4">
                                <div>{{ $job->customer->name }}</div>
                                <div class="text-xs text-[var(--app-muted)]">{{ $job->customer->phone }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div>{{ $job->car->plate_number }}</div>
                                <div class="text-xs text-[var(--app-muted)]">{{ $job->car->make }} {{ $job->car->model }}</div>
                            </td>
                            <td class="px-6 py-4 text-right">Rs. {{ number_format($job->total_amount) }}</td>
                            <td class="px-6 py-4 text-right">Rs. {{ number_format($job->amount_paid) }}</td>
                            <td class="px-6 py-4 text-right font-bold text-red-600 dark:text-red-400">Rs. {{ number_format($job->balance_due) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-[var(--app-muted)]">
                                <span class="text-xl">🎉</span><br>
                                <span class="mt-2 block">No outstanding balances found!</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
