<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\View\View;

class PlanController extends Controller
{
    public function index(): View
    {
        $plans = [
            'small' => [
                'label'    => 'Small',
                'price'    => 1800,
                'per'      => 'per month · billed monthly',
                'features' => [
                    ['label' => 'Up to 5 users',              'enabled' => true],
                    ['label' => 'Up to 2 POS terminals',      'enabled' => true],
                    ['label' => 'Basic sales reports',        'enabled' => true],
                    ['label' => 'Inventory management',       'enabled' => true],
                    ['label' => 'Advanced analytics',         'enabled' => false],
                    ['label' => 'Multi-outlet support',       'enabled' => false],
                    ['label' => 'API / webhook access',       'enabled' => false],
                    ['label' => 'Email support (48hr SLA)',   'enabled' => true],
                ],
            ],
            'medium' => [
                'label'    => 'Medium',
                'price'    => 4800,
                'per'      => 'per month · billed monthly',
                'popular'  => true,
                'features' => [
                    ['label' => 'Up to 10 users',             'enabled' => true],
                    ['label' => 'Up to 5 POS terminals',      'enabled' => true],
                    ['label' => 'Advanced reports + export',  'enabled' => true],
                    ['label' => 'Inventory management',       'enabled' => true],
                    ['label' => 'Advanced analytics',         'enabled' => true],
                    ['label' => 'Multi-outlet support',       'enabled' => false],
                    ['label' => 'API / webhook access',       'enabled' => false],
                    ['label' => 'Priority support (24hr SLA)','enabled' => true],
                ],
            ],
            'large' => [
                'label'    => 'Large',
                'price'    => 12500,
                'per'      => 'per month · billed monthly',
                'features' => [
                    ['label' => 'Up to 50 users',             'enabled' => true],
                    ['label' => 'Unlimited POS terminals',    'enabled' => true],
                    ['label' => 'Full analytics suite',       'enabled' => true],
                    ['label' => 'Inventory management',       'enabled' => true],
                    ['label' => 'Advanced analytics',         'enabled' => true],
                    ['label' => 'Multi-outlet support',       'enabled' => true],
                    ['label' => 'API / webhook access',       'enabled' => true],
                    ['label' => 'Dedicated support (4hr SLA)','enabled' => true],
                ],
            ],
        ];

        $clientCounts = Client::selectRaw('plan, count(*) as count')
            ->whereIn('status', ['active', 'trial'])
            ->groupBy('plan')
            ->pluck('count', 'plan');

        $mrr = [
            'small'  => ($clientCounts['small']  ?? 0) * 1800,
            'medium' => ($clientCounts['medium'] ?? 0) * 4800,
            'large'  => ($clientCounts['large']  ?? 0) * 12500,
        ];

        return view('plans.index', compact('plans', 'clientCounts', 'mrr'));
    }
}
