<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\View\View;

class AuditLogController extends Controller
{
    public function index(): View
    {
        $query = AuditLog::with('user')->latest();

        if ($search = request('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('target_name', 'like', "%{$search}%")
                  ->orWhere('change_detail', 'like', "%{$search}%")
                  ->orWhere('action', 'like', "%{$search}%");
            });
        }

        if ($action = request('action')) {
            $query->where('action', $action);
        }

        if ($adminId = request('admin')) {
            $query->where('user_id', $adminId);
        }

        $logs   = $query->paginate(20)->withQueryString();
        $admins = AuditLog::with('user')
            ->select('user_id')
            ->distinct()
            ->whereNotNull('user_id')
            ->get()
            ->pluck('user')
            ->filter();

        $actions = AuditLog::select('action')->distinct()->orderBy('action')->pluck('action');

        return view('audit-log.index', compact('logs', 'admins', 'actions'));
    }
}
