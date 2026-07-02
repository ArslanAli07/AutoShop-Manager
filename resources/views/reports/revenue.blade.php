@extends('reports.layout')

@section('report_content')
    
    {{-- Summary Cards --}}
    <div class="mb-8 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
        <div class="rounded-2xl border border-[var(--app-border)] bg-[var(--app-surface)] p-6">
            <h3 class="text-sm font-medium text-[var(--app-muted)]">Money Collected</h3>
            <p class="mt-2 text-2xl font-bold text-[var(--app-text)]">Rs. {{ number_format($totalRevenue) }}</p>
        </div>
        <div class="rounded-2xl border border-[var(--app-border)] bg-[var(--app-surface)] p-6">
            <h3 class="text-sm font-medium text-[var(--app-muted)]">Total Invoiced (Includes Unpaid)</h3>
            <p class="mt-2 text-2xl font-bold text-[var(--app-text)]">Rs. {{ number_format($totalInvoiced) }}</p>
        </div>
        <div class="rounded-2xl border border-[var(--app-border)] bg-[var(--app-surface)] p-6">
            <h3 class="text-sm font-medium text-[var(--app-muted)]">Average Job Value</h3>
            <p class="mt-2 text-2xl font-bold text-[var(--app-text)]">Rs. {{ number_format($avgJobValue) }}</p>
        </div>
    </div>

    {{-- Line Chart --}}
    <div class="mb-8 rounded-2xl border border-[var(--app-border)] bg-[var(--app-surface)] p-6">
        <h3 class="mb-4 text-sm font-bold text-[var(--app-text)]">Revenue Trend</h3>
        <div class="relative h-72 w-full">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>

    {{-- Jobs Table --}}
    <div class="rounded-2xl border border-[var(--app-border)] bg-[var(--app-surface)] overflow-hidden">
        <div class="p-6 border-b border-[var(--app-border)]">
            <h3 class="text-sm font-bold text-[var(--app-text)]">Jobs in this Period</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b border-[var(--app-border)] bg-[var(--app-bg)] text-[var(--app-muted)]">
                        <th class="px-6 py-4 font-medium">Date</th>
                        <th class="px-6 py-4 font-medium">Job Number</th>
                        <th class="px-6 py-4 font-medium">Customer</th>
                        <th class="px-6 py-4 font-medium text-right">Amount Paid</th>
                        <th class="px-6 py-4 font-medium text-right">Payment Status</th>
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
                            <td class="px-6 py-4">{{ $job->customer->name }}</td>
                            <td class="px-6 py-4 text-right font-medium">Rs. {{ number_format($job->amount_paid) }}</td>
                            <td class="px-6 py-4 text-right">
                                <x-payment-badge :status="$job->payment_status" />
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-[var(--app-muted)]">No jobs found in this period.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('revenueChart').getContext('2d');
            
            // Get root CSS variables for colors to make it theme-aware
            const style = getComputedStyle(document.body);
            const accentColor = style.getPropertyValue('--app-accent').trim() || '#E8C84A';
            const gridColor = style.getPropertyValue('--app-border').trim() || '#E5E7EB';
            const textColor = style.getPropertyValue('--app-muted').trim() || '#6B7280';

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($chartData['labels']) !!},
                    datasets: [{
                        label: 'Money Collected (Rs.)',
                        data: {!! json_encode($chartData['data']) !!},
                        borderColor: accentColor,
                        backgroundColor: accentColor + '20', // Add transparency
                        borderWidth: 2,
                        tension: 0.3,
                        fill: true,
                        pointBackgroundColor: accentColor,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            padding: 12,
                            titleFont: { size: 13, family: "'Inter', sans-serif" },
                            bodyFont: { size: 14, weight: 'bold', family: "'Inter', sans-serif" },
                            callbacks: {
                                label: function(context) {
                                    return 'Rs. ' + context.parsed.y.toLocaleString();
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false,
                                drawBorder: false
                            },
                            ticks: {
                                color: textColor,
                                font: { family: "'IBM Plex Sans', sans-serif" }
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: gridColor,
                                drawBorder: false
                            },
                            ticks: {
                                color: textColor,
                                font: { family: "'IBM Plex Sans', sans-serif" },
                                callback: function(value) {
                                    if (value >= 1000) {
                                        return value / 1000 + 'k';
                                    }
                                    return value;
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection
