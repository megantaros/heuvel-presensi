<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use App\Models\User;
use \Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $query = User::query();

        if ($search) {
            $query->where('nama', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%")
                ->orWhere('nip', 'like', "%$search%")
                ->orWhereHas('jabatan', function ($query) use ($search) {
                    $query->where('nama_jabatan', 'like', "%$search%");
                });
        }

        return view('users.users', [
            'users' => $query->with('jabatan')->latest()->paginate()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create', [
            'jabatan' => Jabatan::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:8',
            'nip' => 'nullable',
            'divisi' => 'nullable',
            'id_jabatan' => 'required|exists:jabatan,id',
        ]);

        User::create($validated);

        return redirect('/users')->with('status', 'Data karyawan berhasil disimpan!');

    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('users.create', [
            'user' => $user,
            'jabatan' => Jabatan::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'nama' => 'required',
            'email' => 'required',
            'password' => 'nullable|min:8',
            'nip' => 'nullable',
            'divisi' => 'nullable',
            'id_jabatan' => 'required|exists:jabatan,id',
        ]);

        if (!$validated['password']) {
            unset($validated['password']);
        }

        $user->update($validated);

        // $user->fill($validated);
        // $user->save();

        // $superUser = Jabatan::where('nama_jabatan', 'Produksi')
        //     ->orWhere('nama_jabatan', 'Admin Keuangan')
        //     ->orWhere('nama_jabatan', 'Staff Admin Keuangan')
        //     ->get()
        //     ->pluck('id')
        //     ->toArray();

        // if (Arr::has($superUser, $validated['id_jabatan'])) {
        //     $user->assignRole('super_user');
        // } else {
        //     $user->removeRole('super_user');
        // }

        return redirect('/users')->with('status', 'Data karyawan berhasil disimpan!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::where('id', $id)->first();

        $user->delete();

        return redirect('/users')->with('status', 'Data karyawan berhasil dihapus!');
    }

    public function print()
    {
        $users = User::with('jabatan')->get();

        // $pdf = PDF::loadView('print.karyawan', compact('users'));
        // $pdf->setPaper('A4', 'potrait');
        // $pdf->set_option('isRemoteEnabled', true);
        // return $pdf->download('data-karyawan.pdf');
        return view('print.karyawan', compact('users'));
    }
}