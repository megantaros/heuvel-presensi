
@extends('layouts.print')

@section('content')
<div class="content">
    <h4>Data Kehadiran</h4>

    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 20px; gap:10px;">
        <table>
            <tr>
                <td style="background-color: #f1f1f1; font-weight: 600;">Nama</td>
                <td><strong>{{ $user->nama }}</strong></td>
            </tr>
            <tr>
                <td style="background-color: #f1f1f1; font-weight: 600;">NIP</td>
                <td>{{ $user->nip }}</td>
            </tr>
            <tr>
                <td style="background-color: #f1f1f1; font-weight: 600;">Email</td>
                <td>{{ $user->email }}</td>
            </tr>
            <tr>
                <td style="background-color: #f1f1f1; font-weight: 600;">Jabatan</td>
                <td>{{ $user->jabatan->nama_jabatan }}</td>
            </tr>
        </table>               
        <table>
            <tr>
                <td style="background-color: #f1f1f1; font-weight: 600;">Jumlah Kehadiran</td>
                <td><strong>{{ $count }} Hari</strong></td>
            </tr>
            <tr>
                <td style="background-color: #f1f1f1; font-weight: 600;">Jumlah Jam Terlambat</td>
                <td><strong>{{ $totalLateHours }} Jam</strong></td>
            </tr>
            <tr>
                <td style="background-color: #f1f1f1; font-weight: 600;">Potongan Gaji</td>
                <td style="font-size: 18px; color: red;"><strong>{{ $salaryCuts }}</strong></td>
            </tr>
        </table>               
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Waktu Masuk</th>
                <th>Keterlambatan</th>
                <th>Waktu Pulang</th>
                <th>Total Jam Kerja</th>
            </tr>
        </thead>
        <tbody>
            @php
                $no = 0;
            @endphp
            @foreach ($data as $item)
                <tr>
                    <td>{{ $no + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->locale('id')->translatedFormat('l, d F Y') }}</td>
                    <td>{{ $item->waktu_masuk }}</td>
                    <td>{{ $item->total_jam_terlambat }} Jam</td>
                    <td>{{ $item->waktu_keluar ?? '-' }}</td>
                    <td>{{ $item->total_waktu_kerja ?? '-' }} Jam</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection