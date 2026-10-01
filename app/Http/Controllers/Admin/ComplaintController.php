<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\User;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    /**
     * Display a listing of complaints.
     */
    public function index(Request $request)
    {
        $status = $request->query('status');
        $priority = $request->query('priority');

        // Relations: complainant + assignedTo
        $query = Complaint::with(['complainant', 'assignedTo']);

        // Filter by status
        if ($status) {
            $query->where('status', $status);
        }

        // Filter by priority
        if ($priority) {
            $query->where('priority', $priority);
        }

        // Get complaints
        $complaints = $query
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // Statistics
        $stats = [
            'new' => Complaint::where('status', 'new')->count(),
            'in_investigation' => Complaint::where('status', 'in_investigation')->count(),
            'resolved' => Complaint::where('status', 'resolved')->count(),
            'total' => Complaint::count(),
        ];

        return view(
            'admin.complaints.index',
            compact('complaints', 'stats')
        );
    }

    /**
     * Display a specific complaint.
     */
    public function show(Complaint $complaint)
    {
        // Load relationships
        $complaint->load([
            'complainant',
            'assignedTo'
        ]);

        // Get users/officials for assignment
        $officials = User::all();

        return view(
            'admin.complaints.show',
            compact('complaint', 'officials')
        );
    }

    /**
     * Assign complaint to an official.
     */
    public function assign(Request $request, Complaint $complaint)
    {
        $validated = $request->validate([
            'assigned_to' => [
                'required',
                'exists:users,id',
            ],
        ]);

        $complaint->update([
            'assigned_to' => $validated['assigned_to'],
            'assigned_at' => now(),
            'status' => 'in_investigation',
        ]);

        return redirect()
            ->back()
            ->with('success', 'Plainte assignée avec succès');
    }

    /**
     * Respond to a complaint.
     */
    public function respond(Request $request, Complaint $complaint)
    {
        $validated = $request->validate([
            'response' => [
                'required',
                'string',
            ],
        ]);

        $complaint->update([
            'response' => $validated['response'],
            'status' => 'resolved',
            'resolved_at' => now(),
        ]);

        return redirect()
            ->back()
            ->with('success', 'Réponse soumise avec succès');
    }

    /**
     * Close a complaint.
     */
    public function close(Complaint $complaint)
    {
        $complaint->update([
            'status' => 'closed',
        ]);

        return redirect()
            ->back()
            ->with('success', 'Plainte clôturée avec succès');
    }

    /**
     * Display complaint statistics.
     */
    public function statistics()
    {
        $stats = [
            'total' => Complaint::count(),
            'new' => Complaint::where('status', 'new')->count(),
            'in_investigation' => Complaint::where('status', 'in_investigation')->count(),
            'resolved' => Complaint::where('status', 'resolved')->count(),
            'dismissed' => Complaint::where('status', 'dismissed')->count(),
            'closed' => Complaint::where('status', 'closed')->count(),
        ];

        return view(
            'admin.complaints.statistics',
            compact('stats')
        );
    }
}