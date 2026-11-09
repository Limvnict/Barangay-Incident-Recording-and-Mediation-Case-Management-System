<?php
namespace App\Http\Controllers\Resident;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller {
    public function edit() { return view('resident.profile'); }

    public function update(Request $r) {
        $data = $r->validate([
            'name'    => 'required|string|max:255',
            'phone'   => ['required', 'regex:/^09[0-9]{9}$/'],
            'address' => 'nullable|string|max:255',
            'purok'   => 'nullable|string|max:50',
        ]);
        $r->user()->update($data);
        return back()->with('success', 'Profile updated.');
    }
}
