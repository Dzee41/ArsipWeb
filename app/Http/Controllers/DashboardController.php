<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{
    Category,
    Archive,
    User,
};

use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $archives = Archive::with('category')->get();
        $totalArchives = $archives->count();
        $dateNow = Carbon::now('Asia/Jakarta')->isoFormat('dddd, D MMMM YYYY, HH:mm', 'id');
        $totalUsers = User::get()->count();
        $totalUsersActive = User::where('is_active', 1)->count();
        $totalCategory = Category::get()->count();

        // // Hitung total arsip dalam 7 hari terakhir
        // $startDate = Carbon::now('Asia/Jakarta')->subDays(7);
        // $endDate = Carbon::now('Asia/Jakarta');
        // $currentWeekArchives = Archive::whereBetween('created_at', [$startDate, $endDate])->count();

        // // Hitung total arsip dalam 7 hari sebelum 7 hari terakhir
        // $previousStartDate = Carbon::now('Asia/Jakarta')->subDays(14);
        // $previousEndDate = Carbon::now('Asia/Jakarta')->subDays(7);
        // $previousWeekArchives = Archive::whereBetween('created_at', [$previousStartDate, $previousEndDate])->count();

        // // Hitung persentase pertumbuhan
        // if ($previousWeekArchives > 0) {
        //     $percentageChange = (($currentWeekArchives - $previousWeekArchives) / $previousWeekArchives) * 100;
        // } else {
        //     // Jika tidak ada arsip sebelumnya, anggap pertumbuhan 100%
        //     $percentageChange = 100;
        // }

        // // Mengambil data laporan masuk dalam 7 hari terakhir
        // $reportData = Archive::select(
        //     DB::raw('DATE(created_at) as date'),
        //     DB::raw('count(*) as count')
        // )
        // ->whereBetween('created_at', [$startDate, $endDate])
        // ->groupBy('date')
        // ->orderBy('date', 'ASC')
        // ->get()
        // ->pluck('count', 'date')
        // ->toArray();

        // // Format data untuk Chart.js
        // $chartData = [
        //     'labels' => array_keys($reportData),
        //     'data' => array_values($reportData),
        // ];

        return view('home', [
            'archives' => $archives,
            'totalArchives' => $totalArchives,
            'dateNow' => $dateNow,
            'percentageChange' => 0,
            'totalUsers' => $totalUsers,
            'totalUsersActive' => $totalUsersActive,
            'totalCategory' => $totalCategory,
            // 'chartData' => $chartData
        ]);
    }
}
