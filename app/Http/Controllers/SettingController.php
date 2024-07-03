<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('settings.settings', ['settings' => Setting::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'jam_masuk' => 'required',
            'jam_pulang' => 'required',
            'potongan_gaji_per_jam' => 'required|numeric',
        ]);

        $jamMasuk = Setting::firstOrNew(['key' => 'jam_masuk']);
        $jamPulang = Setting::firstOrNew(['key' => 'jam_pulang']);
        $potongan = Setting::firstOrNew(['key' => 'potongan_gaji_per_jam']);

        $jamMasuk->value = $validated['jam_masuk'];
        $jamPulang->value = $validated['jam_pulang'];
        $potongan->value = $validated['potongan_gaji_per_jam'];

        $jamMasuk->save();
        $jamPulang->save();
        $potongan->save();

        return redirect()->back()->with('status', 'Data berhasil tersimpan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Setting $setting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Setting $setting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Setting $setting)
    {
        //
    }
}
