<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClientRequest;
use App\Models\AuditLog;
use App\Models\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClientController extends Controller
{
    public function index(): View
    {
        $query = Client::query();

        if ($search = request('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('company_name', 'like', "%{$search}%")
                  ->orWhere('client_access_code', 'like', "%{$search}%");
            });
        }

        $status = request('status');
        if ($status && in_array($status, ['active', 'trial', 'suspended'], true)) {
            $query->where('status', $status);
        }

        $plan = request('plan');
        if ($plan && in_array($plan, ['small', 'medium', 'large'], true)) {
            $query->where('plan', $plan);
        }

        $vertical = request('vertical');
        if ($vertical) {
            $query->where('vertical', $vertical);
        }

        $counts = [
            'total'     => Client::count(),
            'active'    => Client::where('status', 'active')->count(),
            'trial'     => Client::where('status', 'trial')->count(),
            'suspended' => Client::where('status', 'suspended')->count(),
        ];

        $clients  = $query->latest()->paginate(10)->withQueryString();
        $verticals = Client::whereNotNull('vertical')->distinct()->orderBy('vertical')->pluck('vertical');

        return view('clients.index', compact('clients', 'counts', 'verticals'));
    }

    public function create(): View
    {
        return view('clients.create');
    }

    public function store(StoreClientRequest $request): RedirectResponse
    {
        $data   = $this->normalizeClientPayload($request->validated());
        $client = Client::create($data);

        AuditLog::record(
            'create',
            'client',
            $client->id,
            $client->name,
            "New client — {$client->plan} plan, {$client->status} status, code {$client->client_access_code} issued"
        );

        return redirect()->route('clients.index')->with('status', 'Client created successfully.');
    }

    public function edit(Client $client): View
    {
        return view('clients.edit', compact('client'));
    }

    public function update(StoreClientRequest $request, Client $client): RedirectResponse
    {
        $old  = $client->only(['plan', 'status']);
        $data = $this->normalizeClientPayload($request->validated());
        $client->update($data);

        $changes = [];
        if ($old['plan'] !== $client->plan) {
            $changes[] = "Plan: {$old['plan']} → {$client->plan}";
        }
        if ($old['status'] !== $client->status) {
            $changes[] = "Status: {$old['status']} → {$client->status}";
        }

        AuditLog::record(
            'update',
            'client',
            $client->id,
            $client->name,
            empty($changes) ? 'Client details updated' : implode(', ', $changes)
        );

        return redirect()->route('clients.index')->with('status', 'Client updated successfully.');
    }

    public function updateStatus(Request $request, Client $client): RedirectResponse
    {
        $newStatus = $request->validate([
            'status' => ['required', 'in:active,trial,suspended'],
        ])['status'];

        $oldStatus = $client->status;
        $client->update([
            'status' => $newStatus,
            'mrr'    => $newStatus === 'suspended' ? 0 : ($client->mrr ?: $this->planMrr($client->plan)),
        ]);

        $actionMap = [
            'active'    => 'activate',
            'suspended' => 'suspend',
            'trial'     => 'update',
        ];

        AuditLog::record(
            $actionMap[$newStatus] ?? 'update',
            'client',
            $client->id,
            $client->name,
            "Status: {$oldStatus} → {$newStatus}"
        );

        return back()->with('status', "Client status updated to {$newStatus}.");
    }

    public function destroy(Client $client): RedirectResponse
    {
        $name = $client->name;
        $id   = $client->id;

        $client->delete();

        AuditLog::record('delete', 'client', $id, $name, "Client deleted");

        return redirect()->route('clients.index')->with('status', "Client \"{$name}\" deleted.");
    }

    public function regenerateCode(Client $client): RedirectResponse
    {
        $year    = now()->year;
        $segment = strtoupper(preg_replace('/[^A-Z0-9]/', '', $client->name));
        $segment = substr($segment, 0, 5);
        $segment = str_pad($segment, 5, 'X');
        $rand    = str_pad((string) rand(0, 9999), 4, '0', STR_PAD_LEFT);
        $newCode = "BS-{$segment}-{$rand}";

        $client->update(['client_access_code' => $newCode]);

        AuditLog::record(
            'regen_code',
            'client',
            $client->id,
            $client->name,
            "Code regenerated → {$newCode}"
        );

        return back()->with('status', "Access code regenerated: {$newCode}");
    }

    private function normalizeClientPayload(array $data): array
    {
        $plan    = $data['plan'] ?? 'medium';
        $pricing = match ($plan) {
            'small' => ['user_limit' => 5,  'mrr' => 1800],
            'large' => ['user_limit' => 50, 'mrr' => 12500],
            default => ['user_limit' => 10, 'mrr' => 4800],
        };

        $data['status']       = $data['status'] ?? 'active';
        $data['vertical']     = $data['vertical'] ?? ($data['business_type'] ?? null);
        $data['display_name'] = $data['display_name'] ?? ($data['name'] ?? null);
        $data['users']        = $data['users'] ?? 0;
        $data['user_limit']   = $data['user_limit'] ?? $pricing['user_limit'];
        $data['mrr']          = $data['mrr'] ?? $pricing['mrr'];
        $data['joined_at']    = $data['joined_at'] ?? now();

        return $data;
    }

    private function planMrr(string $plan): int
    {
        return match ($plan) {
            'small' => 1800,
            'large' => 12500,
            default => 4800,
        };
    }
}
