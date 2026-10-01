<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\CitizenRequest;
use App\Models\Complaint;
use App\Models\MunicipalService;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function requestForm()
    {
        $services = MunicipalService::where('is_active', true)->get();
        return view('public.services.request', compact('services'));
    }

    public function submitRequest(Request $request)
    {
        $validated = $request->validate([
         'service_id' => 'required|exists:municipal_services,id',
            'description_fr' => 'required|string|min:10',
            'priority' => 'required|in:low,medium,high',
            'attachments' => 'nullable|file|max:5120',
        ]);

        $requestNumber = 'REQ-' . date('Y') . '-' . str_pad(CitizenRequest::count() + 1, 4, '0', STR_PAD_LEFT);

        CitizenRequest::create([
            'request_number' => $requestNumber,
            'user_id' => auth()->id(),
            'service_id' => $validated['service_id'] ?? null,
            'description_fr' => $validated['description_fr'],
            'description_en' => $validated['description_fr'],
            'description_ar' => $validated['description_fr'],
            'priority' => $validated['priority'],
            'status' => 'pending',
        ]);

        return redirect()->route('home')
            ->with('success', 'Votre demande a été soumise avec succès. Numéro: ' . $requestNumber);
    }

    public function complaintForm()
    {
        return view('public.services.complaint');
    }

    public function submitComplaint(Request $request)
    {
        $validated = $request->validate([
            'category' => 'required|string',
            'description_fr' => 'required|string|min:10',
            'priority' => 'required|in:low,medium,high',
            'location' => 'nullable|string',
        ]);

        $complaintNumber = 'CMP-' . date('Y') . '-' . str_pad(Complaint::count() + 1, 4, '0', STR_PAD_LEFT);

        Complaint::create([
            'complaint_number' => $complaintNumber,
            'user_id' => auth()->id(),
            'category' => $validated['category'],
            'description_fr' => $validated['description_fr'],
            'description_en' => $validated['description_fr'],
            'description_ar' => $validated['description_fr'],
            'priority' => $validated['priority'],
            'location' => $validated['location'] ?? null,
            'status' => 'new',
        ]);

        return redirect()->route('home')
            ->with('success', 'Votre plainte a été soumise avec succès. Numéro: ' . $complaintNumber);
    }
}