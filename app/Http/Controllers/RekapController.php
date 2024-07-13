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
    public function show(Request $request, User $user)
    {
        // Inisialisasi query builder
        $query = (new Absen())->newQuery()
            ->where('id_user', $user->id)
            ->orderBy('tanggal', 'desc');

        // Tambahkan filter tanggal jika ada
        if ($request->input('since') && $request->input('until')) {
            $query->whereBetween('tanggal', [$request->input('since'), $request->input('until')]);
        }

        // Ambil data dengan paginasi
        $data = $query->paginate(35);

        // Tambahkan parameter query string untuk paginasi jika ada filter tanggal
        if ($request->input('since') && $request->input('until')) {
            $data->appends([
                'since' => $request->input('since'),
                'until' => $request->input('until')
            ]);
        }

        // Clone query builder untuk menghitung total jam terlambat dan jumlah data
        $summaryQuery = clone $query;

        // Hitung total jam terlambat
        $totalLateHours = $summaryQuery->sum('total_jam_terlambat');

        // Hitung jumlah data
        $count = $summaryQuery->count();

        // Hitung potongan gaji berdasarkan total jam terlambat
        $salaryCutPerHour = Setting::find('potongan_gaji_per_jam')?->value ?? 0;
        $salaryCuts = $totalLateHours * $salaryCutPerHour;
        $salaryCuts = "Rp " . number_format($salaryCuts, 0, ',', '.');

        // Return view dengan data yang telah dihitung
        return view('rekapitulasi.show', [
            'user' => $user,
            'data' => $data,
            'totalLateHours' => $totalLateHours,
            'count' => $count,
            'salaryCuts' => $salaryCuts,
        ]);
    }

    public function printShow(Request $request, $id)
    {
        $user = User::find($id);

        // Inisialisasi query builder
        $query = (new Absen())->newQuery()
            ->where('id_user', $user->id)
            ->orderBy('tanggal', 'desc');

        // Tambahkan filter tanggal jika ada
        if ($request->input('since') && $request->input('until')) {
            $query->whereBetween('tanggal', [$request->input('since'), $request->input('until')]);
        }

        // Ambil data tanpa paginasi
        $data = $query->get();

        // Clone query builder untuk menghitung total jam terlambat dan jumlah data
        $summaryQuery = clone $query;

        // Hitung total jam terlambat
        $totalLateHours = $summaryQuery->sum('total_jam_terlambat');

        // Hitung jumlah data
        $count = $summaryQuery->count();

        // Hitung potongan gaji berdasarkan total jam terlambat
        $salaryCutPerHour = Setting::find('potongan_gaji_per_jam')?->value ?? 0;
        $salaryCuts = $totalLateHours * $salaryCutPerHour;
        $salaryCuts = "Rp " . number_format($salaryCuts, 0, ',', '.');

        // Return view dengan data yang telah dihitung
        return view('print.get-rekapitulasi', [
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

        // $pdf = app('dompdf.wrapper');
        // $pdf->loadView('print.rekapitulasi', [
        //     'users' => $users,
        //     'results' => $result,
        // ]);

        // return $pdf->stream('rekapitulasi.pdf');

        return view('print.rekapitulasi', [
            'users' => $users,
            'results' => $result,
        ]);
    }
}