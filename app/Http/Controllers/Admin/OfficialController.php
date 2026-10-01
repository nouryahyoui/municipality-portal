<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Official;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;

class OfficialController extends Controller
{
    public function index()
    {
        $officials = Official::with(['department', 'user'])->paginate(20);
        return view('admin.officials.index', compact('officials'));
    }

    public function create()
    {
        $departments = Department::active()->get();
        $users = User::all();
        return view('admin.officials.form', ['official' => new Official(), 'departments' => $departments, 'users' => $users]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'department_id' => 'required|exists:departments,id',
            'position_fr' => 'required|string|max:255',
            'position_en' => 'required|string|max:255',
            'position_ar' => 'required|string|max:255',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'office_location' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
            'photo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('officials', 'public');
        }

        Official::create($validated);

        return redirect()->route('admin.officials.index')
            ->with('success', 'Officiel créé avec succès');
    }

    public function edit(Official $official)
    {
        $departments = Department::active()->get();
        $users = User::all();
        return view('admin.officials.form', compact('official', 'departments', 'users'));
    }

    public function update(Request $request, Official $official)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'department_id' => 'required|exists:departments,id',
            'position_fr' => 'required|string|max:255',
            'position_en' => 'required|string|max:255',
            'position_ar' => 'required|string|max:255',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'office_location' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
            'photo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('officials', 'public');
        }

        $official->update($validated);

        return redirect()->route('admin.officials.index')
            ->with('success', 'Officiel mis à jour avec succès');
    }

    public function destroy(Official $official)
    {
        $official->delete();
        return redirect()->route('admin.officials.index')
            ->with('success', 'Officiel supprimé avec succès');
    }
}