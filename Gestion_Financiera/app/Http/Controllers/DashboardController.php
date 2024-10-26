<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->role === 'admin') {
            return view('dashboard.admin');
        } elseif ($user->role === 'student') {
            return view('dashboard.student');
        } elseif ($user->role === 'teacher') {
            return view('dashboard.teacher');
        } else {
            abort(403); 
        }
    }
}