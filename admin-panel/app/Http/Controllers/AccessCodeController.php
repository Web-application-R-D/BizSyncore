<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AccessCodeController extends Controller
{
    public function index(): View
    {
        $query = Client::query()->select([
            'id', 'name', 'vertical', 'client_access_code', 'status', 'joined_at', 'updated_at',
        ]);

        if ($search = request('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('client_access_code', 'like', "%{$search}%");
            });
        }

        $statusFilter = request('status');
        if ($statusFilter && in_array($statusFilter, ['active', 'trial', 'suspended'], true)) {
            $query->where('status', $statusFilter);
        }

        $counts = [
            'total'     => Client::count(),
            'active'    => Client::where('status', 'active')->count(),
            'suspended' => Client::where('status', 'suspended')->count(),
        ];

        $clients = $query->latest('updated_at')->paginate(15)->withQueryString();

        return view('access-codes.index', compact('clients', 'counts'));
    }

    public function regen(Client $client): RedirectResponse
    {
        $year    = now()->year;
        $segment = strtoupper(preg_replace('/[^A-Z0-9]/', '', $client->name));
        $segment = str_pad(substr($segment, 0, 5), 5, 'X');
        $rand    = str_pad((string) rand(0, 9999), 4, '0', STR_PAD_LEFT);
        $newCode = "BS-{$segment}-{$rand}";

        $client->update(['client_access_code' => $newCode]);

        AuditLog::record(
            'regen_code',
            'client',
            $client->id,
            $client->name,
            "Code regenerated for {$client->name} → {$newCode}"
        );

        return back()->with('status', "Access code regenerated: {$newCode}");
    }

    public function toggleStatus(Client $client): RedirectResponse
    {
        $newStatus = $client->status === 'suspended' ? 'active' : 'suspended';
        $oldStatus = $client->status;
        $client->update(['status' => $newStatus]);

        AuditLog::record(
            $newStatus === 'suspended' ? 'suspend' : 'activate',
            'client',
            $client->id,
            $client->name,
            "Status: {$oldStatus} → {$newStatus}"
        );

        return back()->with('status', "Code status changed to {$newStatus}.");
    }
}
