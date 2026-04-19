<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\View\View;

class AnalyticsController extends Controller
{
    public function index(): View
    {
        $counts = [
            'total'     => Client::count(),
            'active'    => Client::where('status', 'active')->count(),
            'trial'     => Client::where('status', 'trial')->count(),
            'suspended' => Client::where('status', 'suspended')->count(),
        ];

        $mrr = Client::where('status', 'active')->sum('mrr');

        $avgMrr = $counts['active'] > 0
            ? round($mrr / $counts['active'])
            : 0;

        $clientsByVertical = Client::selectRaw('vertical, count(*) as count')
            ->whereNotNull('vertical')
            ->groupBy('vertical')
            ->orderByDesc('count')
            ->limit(6)
            ->get();

        $planBreakdown = [
            'small'  => Client::where('plan', 'small')->where('status', 'active')->count(),
            'medium' => Client::where('plan', 'medium')->where('status', 'active')->count(),
            'large'  => Client::where('plan', 'large')->where('status', 'active')->count(),
        ];

        $recentClients = Client::latest('joined_at')->limit(5)->get();

        $health = [
            ['label' => 'Master Admin API', 'value' => '99.98%', 'state' => 'Healthy', 'ok' => true],
            ['label' => 'Code resolver',    'value' => '99.99%', 'state' => 'Healthy', 'ok' => true],
            ['label' => 'Database cluster', 'value' => '100%',   'state' => 'Healthy', 'ok' => true],
            ['label' => 'File storage (CDN)','value' => '100%',  'state' => 'Healthy', 'ok' => true],
            ['label' => 'Email delivery',   'value' => '97.2%',  'state' => 'Monitor', 'ok' => null],
        ];

        return view('analytics.index', compact(
            'counts', 'mrr', 'avgMrr', 'clientsByVertical', 'planBreakdown', 'recentClients', 'health'
        ));
    }
}
