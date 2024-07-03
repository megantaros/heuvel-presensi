<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class RekapController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, User $user)
    {
        /** @var \Illuminate\Database\Eloquent\Builder */
        $query = (new Absen())->newQuery()
            ->where('id_user', $user->id)
            ->orderBy('tanggal', 'desc');

        if ($request->input('since') && $request->input('until')) {
            $query = $query
                ->where('tanggal', '>=', $request->input('since'))
                ->where('tanggal', '<=', $request->input('until'));
        }

        /** @var LengthAwarePaginator */
        $data = $query->paginate(35);

        if ($request->input('since') && $request->input('until')) {
            $data->appends([
                'since' => $request->input('since'),
                'until' => $request->input('until')
            ]);
        }

        $totalLateHours = $query->selectRaw('sum(total_jam_terlambat) as late_hours')
            ->first()?->late_hours;

        $count = $query->count();

        $salaryCuts = $totalLateHours * (Setting::find('potongan_gaji_per_jam')?->value ?? 0);
        $salaryCuts = "Rp " . number_format($salaryCuts, 0, ',', '.');

        return view('rekapitulasi.show', [
            'user' => $user,
            'data' => $data,
            'totalLateHours' => $totalLateHours,
            'count' => $count,
            'salaryCuts' => $salaryCuts,
        ]);
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $result = [];

        $query = User::join('jabatan', 'users.id_jabatan', '=', 'jabatan.id')
            ->select('users.*', 'jabatan.nama_jabatan')
            ->orderBy('users.id', 'asc');

        if ($search) {
            $query = $query->where('users.nama', 'like', "%$search%")
                ->orWhere('jabatan.nama_jabatan', 'like', "%$search%");
        }

        $users = $query->paginate();

        $absen = Absen::selectRaw('id_user, sum(total_jam_terlambat) as total_jam_terlambat, sum(total_waktu_kerja) as total_waktu_kerja')
            ->groupBy('id_user')
            ->get();

        foreach ($users as $user) {
            $absenUser = $absen->where('id_user', $user->id)->first();
            $totalLateHours = $absenUser->total_jam_terlambat ?? 0;
            $count = $absenUser->total_waktu_kerja ?? 0;

            $salaryCuts = $totalLateHours * (Setting::find('potongan_gaji_per_jam')->value ?? 0);
            $salaryCuts = "Rp " . number_format($salaryCuts, 0, ',', '.');

            $result[] = [
                'id' => $user->id,
                'nama' => $user->nama,
                'jabatan' => $user->nama_jabatan, // Assuming a relationship exists
                'jumlah' => $count,
                'total_jam_terlambat' => $totalLateHours,
                'potongan' => $salaryCuts,
            ];
        }

        return view('rekapitulasi.rekap', [
            'users' => $users,
            'results' => $result,
        ]);
    }

    public function print(Request $request)
    {
        $search = $request->input('search');
        $result = [];

        $query = User::join('jabatan', 'users.id_jabatan', '=', 'jabatan.id')
            ->select('users.*', 'jabatan.nama_jabatan')
            ->orderBy('users.id', 'asc');

        if ($search) {
            $query = $query->where('users.nama', 'like', "%$search%")
                ->orWhere('jabatan.nama_jabatan', 'like', "%$search%");
        }

        $users = $query->get();

        $absen = Absen::selectRaw('id_user, sum(total_jam_terlambat) as total_jam_terlambat, sum(total_waktu_kerja) as total_waktu_kerja')
            ->groupBy('id_user')
            ->get();

        foreach ($users as $user) {
            $absenUser = $absen->where('id_user', $user->id)->first();
            $totalLateHours = $absenUser->total_jam_terlambat ?? 0;
            $count = $absenUser->total_waktu_kerja ?? 0;

            $salaryCuts = $totalLateHours * (Setting::find('potongan_gaji_per_jam')->value ?? 0);
            $salaryCuts = "Rp " . number_format($salaryCuts, 0, ',', '.');

            $result[] = [
                'id' => $user->id,
                'nama' => $user->nama,
                'jabatan' => $user->nama_jabatan, // Assuming a relationship exists
                'jumlah' => $count,
                'total_jam_terlambat' => $totalLateHours,
                'potongan' => $salaryCuts,
            ];
        }

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('print.rekapitulasi', [
            'users' => $users,
            'results' => $result,
        ]);

        return $pdf->stream('rekapitulasi.pdf');
    }
}