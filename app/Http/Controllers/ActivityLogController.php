<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class ActivityLogController extends Controller
{
    public function activityLog(Request $request)
    {
        $filter = $request->query('filter');
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        // Base query
        $query = Activity::query()->orderBy('id', 'desc');

        // Apply filters based on the selected filter
        if ($filter) {
            switch ($filter) {
                case 'today':
                    $query->whereDate('created_at', Carbon::today());
                    break;

                case 'yesterday':
                    $query->whereDate('created_at', Carbon::yesterday());
                    break;

                case 'this_week':
                    $query->whereBetween('created_at', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ]);
                    break;

                case 'last_week':
                    $query->whereBetween('created_at', [
                        Carbon::now()->subWeek()->startOfWeek(),
                        Carbon::now()->subWeek()->endOfWeek()
                    ]);
                    break;

                case 'this_month':
                    $query->whereMonth('created_at', Carbon::now()->month);
                    break;

                case 'last_month':
                    $query->whereMonth('created_at', Carbon::now()->subMonth()->month);
                    break;

                case 'custom':
                    if ($startDate && $endDate) {
                        $query->whereDate('created_at', '>=', $startDate)
                            ->whereDate('created_at', '<=', $endDate);
                    }
                    break;
            }
        }

        // Fetch the logs based on the query
        $logs = $query->paginate(10);

        return view('activity_log.index', compact('logs', 'filter', 'startDate', 'endDate'));
    }

    public function adminLogingLog(Request $request)
    {
        $filter = $request->query('filter');
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        // Base query
        $query = Activity::query()->where('properties->role', 'admin')->orderBy('id', 'desc');

        // Apply filters based on the selected filter
        if ($filter) {
            switch ($filter) {
                case 'today':
                    $query->whereDate('created_at', Carbon::today());
                    break;

                case 'yesterday':
                    $query->whereDate('created_at', Carbon::yesterday());
                    break;

                case 'this_week':
                    $query->whereBetween('created_at', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ]);
                    break;

                case 'last_week':
                    $query->whereBetween('created_at', [
                        Carbon::now()->subWeek()->startOfWeek(),
                        Carbon::now()->subWeek()->endOfWeek()
                    ]);
                    break;

                case 'this_month':
                    $query->whereMonth('created_at', Carbon::now()->month);
                    break;

                case 'last_month':
                    $query->whereMonth('created_at', Carbon::now()->subMonth()->month);
                    break;

                case 'custom':
                    if ($startDate && $endDate) {
                        $query->whereDate('created_at', '>=', $startDate)
                            ->whereDate('created_at', '<=', $endDate);
                    }
                    break;
            }
        }

        // Fetch the logs based on the query
        $logs = $query->get();
        return view('activity_log.admin-logging', compact('logs', 'filter', 'startDate', 'endDate'));
    }
    public function customerLogingLog(Request $request)
    {
        $filter = $request->query('filter');
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        // Base query
        $query = Activity::query()->where('properties->role', 'customer')->orderBy('id', 'desc');

        // Apply filters based on the selected filter
        if ($filter) {
            switch ($filter) {
                case 'today':
                    $query->whereDate('created_at', Carbon::today());
                    break;

                case 'yesterday':
                    $query->whereDate('created_at', Carbon::yesterday());
                    break;

                case 'this_week':
                    $query->whereBetween('created_at', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ]);
                    break;

                case 'last_week':
                    $query->whereBetween('created_at', [
                        Carbon::now()->subWeek()->startOfWeek(),
                        Carbon::now()->subWeek()->endOfWeek()
                    ]);
                    break;

                case 'this_month':
                    $query->whereMonth('created_at', Carbon::now()->month);
                    break;

                case 'last_month':
                    $query->whereMonth('created_at', Carbon::now()->subMonth()->month);
                    break;

                case 'custom':
                    if ($startDate && $endDate) {
                        $query->whereDate('created_at', '>=', $startDate)
                            ->whereDate('created_at', '<=', $endDate);
                    }
                    break;
            }
        }

        // Fetch the logs based on the query
        $logs = $query->get();
        return view('activity_log.customer-logging', compact('logs', 'filter', 'startDate', 'endDate'));
    }
}
