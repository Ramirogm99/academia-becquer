<?php

namespace App\Http\Controllers;

use App\Models\ClientCourse;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $start_month = Carbon::now()->startOfMonth();
        $end_month = Carbon::now()->endOfMonth();

        $revenueToday = ClientCourse::whereHas('payments', function ($query) {
            $query->whereDate('created_at', date('Y-m-d'));
        })->sum('total');
        $revenueMonth = ClientCourse::whereHas('payments', function ($query) use ($start_month, $end_month) {
            $query->whereBetween('created_at', [$start_month, $end_month]);
        })->sum('total');
        return view('home', ['revenueToday' => $revenueToday, 'revenueMonth' => $revenueMonth]);
    }
}
