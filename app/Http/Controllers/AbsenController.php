<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AbsenController extends Controller
{
    public function __invoke()
    {
        $today = Absen::where('tanggal', date('Y-m-d'))
            ->where('id_user', auth()->user()->id)
            ->latest()
            ->first();

        return view('absensi.absen', [
            'status' => $today?->waktu_keluar ? 'done' : ($today?->waktu_masuk ? 'working' : 'not_coming') // NOSONAR
        ]);
    }

    public function absen()
    {
        // user object
        /** @var User */
        $user = auth()->user();

        // variable
        $now = Carbon::now();
        $jamMasuk = Carbon::parse(date('Y-m-d') . ' ' . Setting::find('jam_masuk')?->value);

        // time validation
        if ($now < $jamMasuk) {
            return redirect()->back()->with('status', 'Bukan waktu presensi!');
        }

        // Absen object
        $today = Absen::where('tanggal', date('Y-m-d'))
            ->where('id_user', $user->id)
            ->latest()
            ->first();

        // validation
        if ($today?->id && $today->waktu_keluar) {
            return redirect()->back()->with('status', 'Anda sudah melakukan presensi hari ini!');
        }

        // absen pulang
        if ($today?->id && !$today->waktu_keluar) {
            return $this->absenPulang($today);
        }

        // absen masuk
        return $this->absenMasuk($user, $jamMasuk);
    }

    private function absenMasuk(User $user, Carbon $jamMasuk)
    {
        $keterlambatan = $jamMasuk->diffInHours(Carbon::now());
        $keteranganTerlambat = 'Terlambat ' . $keterlambatan . ' jam' . ($keterlambatan > 0 ? '' : ' ' . $jamMasuk->diffInMinutes(Carbon::now()) . ' menit');

        Absen::create([
            'waktu_masuk' => date('H:i:s'),
            'tanggal' => date('Y-m-d'),
            'id_user' => $user->id,
            'total_jam_terlambat' => $keterlambatan,
            'keterangan' => $keterlambatan > 0 ? $keteranganTerlambat : '-'
        ]);

        return redirect()->back()->with('status', 'Anda berhasil melakukan presensi!');
    }

    private function absenPulang(Absen $today)
    {
        $jamPulang = Setting::find('jam_pulang')?->value;
        $jamPulangParsed = Carbon::parse(date('Y-m-d') . ' ' . $jamPulang);

        // $totalJam = Carbon::parse(date('Y-m-d') . ' ' . $today->waktu_masuk)
        //     ->diffInHours(date('H:i:s'));
        $totalJam = Carbon::parse(date('Y-m-d') . ' ' . $today->waktu_masuk)
            ->diffInHours($jamPulangParsed);

        if ($jamPulangParsed < Carbon::now()) {
            $today->waktu_keluar = $jamPulang;
        } else {
            $today->waktu_keluar = date('H:i:s');
        }

        $today->total_waktu_kerja = $totalJam;
        $today->save();

        return redirect()->back()->with('status', 'Anda berhasil melakukan presensi!');
    }

    public function history(Request $request)
    {
        /** @var \Illuminate\Database\Eloquent\Builder */
        $query = (new Absen())->newQuery()
            ->where('id_user', auth()->user()->id)
            ->orderBy('tanggal', 'desc');

        if ($request->input('since') && $request->input('until')) {
            $query = $query
                ->where('tanggal', '>=', $request->input('since'))
                ->where('tanggal', '<=', $request->input('until'));
        }

        $history = $query->paginate(35);

        if ($request->input('since') && $request->input('until')) {
            $history->appends([
                'since' => $request->input('since'),
                'until' => $request->input('until')
            ]);
        }

        return view('absensi.history', ['data' => $history]);
    }
}