<?php

namespace App\Http\Controllers;

use App\Models\SalesPage;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $userId = $request->user()->id;

        return view('dashboard', [
            'totalPages' => SalesPage::where('user_id', $userId)->count(),
            'readyPages' => SalesPage::where('user_id', $userId)->where('status', 'ready')->count(),
            'recentPages' => SalesPage::where('user_id', $userId)->latest()->take(5)->get(),
        ]);
    }
}
