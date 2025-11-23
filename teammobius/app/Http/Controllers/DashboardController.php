<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Show the dashboard for the signed-in user.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // quick stats for example
        $totalUsers = User::count();
        $totalPatients = User::where('role','patient')->count();
        $totalDoctors = User::where('role','doctor')->count();

        // If user is a doctor, show their patients (example: all patients for now)
        $patients = User::where('role', 'patient')
                        ->orderBy('created_at', 'desc')
                        ->limit(10)
                        ->get(['id','first_name','last_name','email','phone','created_at']);

        return view('dashboard.index', compact('user','totalUsers','totalPatients','totalDoctors','patients'));
    }
}
