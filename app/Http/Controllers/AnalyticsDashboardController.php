<?php

namespace App\Http\Controllers;

use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AnalyticsDashboardController extends Controller
{
    public function index()
    {
        return view('analytics.dashboard');
    }

    public function visits(Request $request)
    {
        $period = $request->query('period', 'day');

        // маппим период на дату начала выборки
        $from = match ($period) {
            'hour'  => Carbon::now()->subHour(),
            'month' => Carbon::now()->subMonth(),
            default => Carbon::now()->subDay(),
        };

        $data = Visit::query()
            ->where('created_at', '>=', $from)
            ->selectRaw('city, COUNT(*) as count')
            ->groupBy('city')
            ->orderByDesc('count')
            ->get();

        return response()->json($data);
    }
}
