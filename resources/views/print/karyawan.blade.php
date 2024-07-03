@extends('layouts.print')

@section('content')
<div class="content">
    <h4>Data Karyawan</h4>
</div>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>NIP</th>
            <th>Email</th>
            <th>Jabatan</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $index => $user)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td><strong>{{ $user->nama }}</strong></td>
                <td>{{ $user->nip }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->jabatan->nama_jabatan }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection