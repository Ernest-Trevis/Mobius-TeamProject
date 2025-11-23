<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class PatientController extends Controller
{
    /**
     * Show paginated list of patients with optional search.
     */
    public function index(Request $request)
    {
        $q = $request->query('q');

        $patients = User::where('role', 'patient')
            ->when($q, function ($query) use ($q) {
                $query->where(function($sub) use ($q) {
                    $sub->where('first_name', 'like', "%{$q}%")
                        ->orWhere('last_name', 'like', "%{$q}%")
                        ->orWhere('email', 'like', "%{$q}%")
                        ->orWhere('phone', 'like', "%{$q}%");
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(12) // change page size here
            ->withQueryString();

        return view('patients.index', compact('patients','q'));
    }
}
