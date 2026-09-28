<?php

namespace App\Http\Controllers;

use App\Models\Pattern;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('user.dashboard');
    }

    public function user()
    {
        return view('dashboards.user', [
            'patternsCount' => Pattern::where('user_id', auth()->id())->count(),
        ]);
    }

    public function admin()
    {
        return view('dashboards.admin', [
            'usersCount' => User::count(),
            'patternsCount' => Pattern::count(),
            'publicPatternsCount' => Pattern::where('is_public', true)->count(),
            'featuredCount' => Pattern::where('is_featured', true)->count(),
        ]);
    }
}