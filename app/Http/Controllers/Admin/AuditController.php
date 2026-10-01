<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AuditController extends Controller
{
    public function index()
    {
        $entries = collect();

        try {
            $entries = \DB::table('telescope_entries')
                ->orderBy('created_at', 'desc')
                ->limit(50)
                ->get();
        } catch (\Exception $e) {
            $entries = collect();
        }

        $stats = [
            'total_users' => User::count(),
            'recent_users' => User::where('created_at', '>=', now()->subDays(7))->count(),
        ];

        return view('admin.audit.index', compact('entries', 'stats'));
    }
}