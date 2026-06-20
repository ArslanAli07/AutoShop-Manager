<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $now   = Carbon::now();

        // ── Stat Cards ──────────────────────────────────────────
        $activeJobs = Job::whereIn('status', ['received', 'in_progress', 'ready'])->count();

        $todayRevenue = Job::whereDate('updated_at', $today)
            ->whereIn('payment_status', ['paid', 'partial'])
            ->sum('amount_paid');

        $monthRevenue = Job::whereMonth('date_in', $now->month)
            ->whereYear('date_in', $now->year)
            ->whereIn('payment_status', ['paid', 'partial'])
            ->sum('amount_paid');

        $unpaidJobs   = Job::whereIn('payment_status', ['unpaid', 'partial'])->get();
        $unpaidCount  = $unpaidJobs->count();
        $unpaidTotal  = 0;

        foreach ($unpaidJobs as $j) {
            $labor        = DB::table('job_services')->where('job_id', $j->id)->sum('labor_cost');
            $parts        = DB::table('job_parts')->where('job_id', $j->id)->sum('total_price');
            $balance      = ($labor + $parts) - $j->amount_paid;
            $unpaidTotal += max(0, $balance);
        }

        // ── Active Jobs Table ────────────────────────────────────
        $activeJobsList = Job::with(['customer', 'car'])
            ->whereIn('status', ['received', 'in_progress', 'ready'])
            ->orderBy('date_in', 'asc')
            ->limit(8)
            ->get();

        // ── Recent Receipts ──────────────────────────────────────
        $recentJobs = Job::with(['customer', 'car'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // ── Top Customers by visit count ─────────────────────────
        $topCustomers = Customer::withCount('jobs')
            ->withSum('jobs', 'amount_paid')
            ->orderBy('jobs_count', 'desc')
            ->limit(5)
            ->get();

        // ── Total counts for overview ────────────────────────────
        $totalCustomers = Customer::count();
        $totalJobs      = Job::count();

        return view('dashboard.index', compact(
            'activeJobs',
            'todayRevenue',
            'monthRevenue',
            'unpaidCount',
            'unpaidTotal',
            'activeJobsList',
            'recentJobs',
            'topCustomers',
            'totalCustomers',
            'totalJobs'
        ));
    }
}
