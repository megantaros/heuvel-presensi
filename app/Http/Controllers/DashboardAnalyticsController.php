<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardAnalyticsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        /** @var \Illuminate\Database\Eloquent\Builder */
        $query = (new Absen())->newQuery()
            ->where('id_user', auth()->user()->id);

        $chart = $query->selectRaw('COUNT(*) as jumlah_absen, MONTH(tanggal) as bulan')
            ->groupBy(DB::raw("MONTH(tanggal)"))
            ->limit(6)
            ->get()
            ->reverse();

        $chart->transform(function($item) {
            $item->bulan = date("M", strtotime("2022-$item->bulan-01"));
            return $item;
        });

        $query = (new Absen())->newQuery()
            ->where('id_user', auth()->user()->id)
            ->where('tanggal', '>=', date('Y-m-') . '01');

        $totalLateHours = $query->selectRaw('sum(total_jam_terlambat) as late_hours')
            ->groupBy("id_user")->first()?->late_hours;

        $query = (new Absen())->newQuery()
            ->where('id_user', auth()->user()->id)
            ->where('tanggal', '>=', date('Y-m-') . '01');

        $count = $query->count();

        return view('dashboard.dashboard', [
            'chart' => $chart,
            'totalLateHours' => $totalLateHours,
            'count' => $count,
        ]);
    }
}
