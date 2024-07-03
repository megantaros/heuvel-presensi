@extends('layouts.print')

@section('content')
<div class="content">
    <h4>Data Rekapitulasi</h4>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Jabatan</th>
                <th>Total Jam Masuk</th>
                <th>Total Jam Terlambat</th>
                <th>Potongan Gaji</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($results as $index => $user)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td><strong>{{ $user['nama'] }}</strong></td>
                    <td>{{ $user['jabatan'] }}</td>
                    <td>{{ $user['jumlah'] }} Jam</td>
                    <td>{{ $user['total_jam_terlambat'] }} Jam</td>
                    <td>{{ $user['potongan'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection