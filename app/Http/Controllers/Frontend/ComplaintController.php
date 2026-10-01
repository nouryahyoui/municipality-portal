<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Reclamation;
use App\Models\Citoyen;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    /**
     * Display complaints form
     */
    public function create()
    {
        return view('frontend.eservices.complaint-create');
    }

    /**
     * Store a newly created complaint
     */
    public function store(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'sujet' => 'required|string|max:255',
            'message' => 'required|string|min:10',
            'email' => 'required|email',
            'phone' => 'nullable|phone',
            'priorite' => 'required|in:haute,moyenne,faible',
            'attachments' => 'nullable|array|max:3',
            'attachments.*' => 'file|max:5120', // 5MB
        ]);

        // Get or create citizen
        $citoyen = Citoyen::where('email', $validated['email'])->first();
        if (!$citoyen) {
            $citoyen = Citoyen::create([
                'email' => $validated['email'],
                'NomPrenom' => $request->input('nom_prenom') ?? 'Anonymous',
                'Tel' => $validated['phone'] ?? null,
                'CIN' => 'ANONYMOUS',
                'Login' => str()->random(10),
                'password' => bcrypt(str()->random(12)),
            ]);
        }

        // Handle file uploads
        $attachments = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $attachments[] = $file->store('complaints', 'public');
            }
        }

        // Create complaint
        $complaint = Reclamation::create([
            'CodeReclamation' => Reclamation::generateCode(),
            'Sujet' => $validated['sujet'],
            'TextMessage' => $validated['message'],
            'IdCitoyen' => $citoyen->id,
            'Priorite' => $validated['priorite'],
            'PiecesJointes' => $attachments ?: null,
            'DateReclamation' => now(),
        ]);

        return redirect()->route('complaints.show', $complaint->id)
            ->with('success', __('messages.complaint_submitted'));
    }

    /**
     * Display complaint status
     */
    public function show($id)
    {
        $complaint = Reclamation::findOrFail($id);

        return view('frontend.eservices.complaint-show', compact('complaint'));
    }

    /**
     * Display my complaints (for authenticated users)
     */
    public function myComplaints()
    {
        // Implementation depends on authentication system
        $complaints = collect();

        return view('frontend.eservices.my-complaints', compact('complaints'));
    }
}
