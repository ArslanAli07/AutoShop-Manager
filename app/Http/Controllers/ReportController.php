<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    private function getDateRange(Request $request)
    {
        $period = $request->input('period', 'month');
        $now = Carbon::now();

        switch ($period) {
            case 'today':
                return [$now->copy()->startOfDay(), $now->copy()->endOfDay()];
            case 'week':
                return [$now->copy()->startOfWeek(), $now->copy()->endOfWeek()];
            case 'year':
                return [$now->copy()->startOfYear(), $now->copy()->endOfYear()];
            case 'month':
            default:
                return [$now->copy()->startOfMonth(), $now->copy()->endOfMonth()];
        }
    }

    public function revenue(Request $request)
    {
        [$startDate, $endDate] = $this->getDateRange($request);
        $period = $request->input('period', 'month');

        $jobs = Job::with(['customer', 'services', 'parts'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'desc')
            ->get();
            
        $totalRevenue = $jobs->sum('amount_paid'); 
        
        $totalInvoiced = $jobs->sum(function($job) {
            return $job->services->sum('labor_cost') + $job->parts->sum(fn($p) => $p->quantity * $p->unit_price);
        });

        $avgJobValue = $jobs->count() > 0 ? $totalInvoiced / $jobs->count() : 0;

        $chartData = ['labels' => [], 'data' => []];
        $grouped = $jobs->groupBy(function($job) {
            return $job->created_at->format('Y-m-d');
        });

        $currentDate = $startDate->copy();
        
        // If period is year, group by month instead of day
        if ($period === 'year') {
            $grouped = $jobs->groupBy(function($job) {
                return $job->created_at->format('Y-m');
            });
            $currentMonth = $startDate->copy();
            while($currentMonth <= $endDate) {
                $monthStr = $currentMonth->format('Y-m');
                $monthJobs = $grouped->get($monthStr, collect());
                $chartData['labels'][] = $currentMonth->format('M');
                $chartData['data'][] = $monthJobs->sum('amount_paid');
                $currentMonth->addMonth();
            }
        } else {
            while($currentDate <= $endDate) {
                $dateStr = $currentDate->format('Y-m-d');
                $dayJobs = $grouped->get($dateStr, collect());
                $chartData['labels'][] = $currentDate->format('M d');
                $chartData['data'][] = $dayJobs->sum('amount_paid');
                $currentDate->addDay();
            }
        }

        return view('reports.revenue', compact('jobs', 'totalRevenue', 'totalInvoiced', 'avgJobValue', 'chartData', 'period'));
    }

    public function outstanding(Request $request)
    {
        $jobs = Job::with(['customer', 'car', 'services', 'parts'])
            ->whereIn('payment_status', ['unpaid', 'partial'])
            ->orderBy('created_at', 'desc')
            ->get();
            
        $totalOutstanding = 0;
        foreach($jobs as $job) {
            $total = $job->services->sum('labor_cost') + $job->parts->sum(fn($p) => $p->quantity * $p->unit_price);
            $balance = max(0, $total - $job->amount_paid);
            $job->balance_due = $balance;
            $job->total_amount = $total;
            $totalOutstanding += $balance;
        }

        return view('reports.outstanding', compact('jobs', 'totalOutstanding'));
    }

    public function jobStatus(Request $request)
    {
        [$startDate, $endDate] = $this->getDateRange($request);
        $period = $request->input('period', 'month');

        $jobs = Job::whereBetween('created_at', [$startDate, $endDate])->get();
        
        $statusCounts = [
            'received' => $jobs->where('status', 'received')->count(),
            'in_progress' => $jobs->where('status', 'in_progress')->count(),
            'ready' => $jobs->where('status', 'ready')->count(),
            'delivered' => $jobs->where('status', 'delivered')->count(),
            'cancelled' => $jobs->where('status', 'cancelled')->count(),
        ];

        return view('reports.job_status', compact('statusCounts', 'period'));
    }

    public function servicesParts(Request $request)
    {
        [$startDate, $endDate] = $this->getDateRange($request);
        $period = $request->input('period', 'month');

        $services = DB::table('job_services')
            ->join('jobs', 'job_services.job_id', '=', 'jobs.id')
            ->leftJoin('service_presets', 'job_services.service_preset_id', '=', 'service_presets.id')
            ->whereBetween('jobs.created_at', [$startDate, $endDate])
            ->select(
                DB::raw('COALESCE(service_presets.name, job_services.description) as name'),
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(job_services.labor_cost) as total_revenue')
            )
            ->groupByRaw('COALESCE(service_presets.name, job_services.description)')
            ->orderByDesc('count')
            ->limit(10)
            ->get();

        $parts = DB::table('job_parts')
            ->join('jobs', 'job_parts.job_id', '=', 'jobs.id')
            ->leftJoin('parts_reference', 'job_parts.parts_reference_id', '=', 'parts_reference.id')
            ->whereBetween('jobs.created_at', [$startDate, $endDate])
            ->select(
                DB::raw('COALESCE(parts_reference.name, job_parts.part_name) as name'),
                DB::raw('SUM(job_parts.quantity) as total_quantity'),
                DB::raw('SUM(job_parts.quantity * job_parts.unit_price) as total_revenue')
            )
            ->groupByRaw('COALESCE(parts_reference.name, job_parts.part_name)')
            ->orderByDesc('total_quantity')
            ->limit(10)
            ->get();

        return view('reports.services_parts', compact('services', 'parts', 'period'));
    }
}
