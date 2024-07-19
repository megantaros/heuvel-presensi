@extends('layouts.app')

@php
    use Carbon\Carbon;

    function formatTanggal($tanggal) {
        return Carbon::parse($tanggal)
                     ->locale('id') // Set locale ke Bahasa Indonesia
                     ->translatedFormat('l, d F Y'); // Format tanggal
    }
@endphp


@section('content')
    <div class="container-xl pt-4">
        @if (session('status'))
            <div class="alert alert-success alert-dismissible mb-4" role="alert">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="card">
            <div class="card-header">
                <h5 class="">Riwayat Kehadiran</h5>
                <form>
                    <div class="d-flex flex-wrap py-4">
                        <div class="col col-sm-6 col-lg-5">
                            <div class="row">
                                <label class="text-sm-end col-sm-4 col-form-label" for="since">Dari:</label>
                                <div class="col-sm-8">
                                    <div class="input-group input-group-merge">
                                        <input type="date" required class="form-control" id="since" name="since" value="{{ request()->input('since') }}" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col col-sm-6 col-lg-5 mb-2">
                            <div class="row">
                                <label class="text-sm-end col-sm-4 col-form-label" for="until">Sampai:</label>
                                <div class="col-sm-8">
                                    <div class="input-group input-group-merge">
                                        <input type="date" required class="form-control" id="until" name="until" value="{{ request()->input('until') }}" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col col-lg-2 d-flex">
                            <button type="submit" class="ms-sm-auto mb-auto btn btn-primary">Filter</button>
                            <button type="button" onclick="window.location.href = '/history'" class="ms-2 mb-auto btn btn-outline-primary">Reset</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body">
                <div class="table-responsive text-nowrap pb-2">
                    <table class="table table-striped mb-5">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Foto</th>
                                <th>Tanggal</th>
                                <th>Waktu Masuk</th>
                                <th>Keterlambatan</th>
                                <th>Waktu Pulang</th>
                                <th>Lokasi</th>
                                <th>Total Jam Kerja</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $loop->iteration + $data->perPage() * ($data->currentPage() - 1) }}</td>
                                    <td>
                                        <img src="{{ asset('uploads/' . $item->foto) }}" alt="Foto" class="rounded" width="100" height="100">
                                    </td>
                                    <td>{{ formatTanggal($item->tanggal) }}</td>
                                    <td>{{ $item->waktu_masuk }}</td>
                                    <td>{{ $item->total_jam_terlambat }} Jam</td>
                                    <td>{{ $item->waktu_keluar ?? '-' }}</td>
                                    <td>
                                        <a href="https://www.google.com/maps/search/?api=1&query={{ $item->latitude }},{{ $item->longitude }}" target="_blank">
                                            <i class="fas fa-map-marker-alt"></i>
                                            Lihat di Maps
                                        </a>
                                    </td>
                                    <td>{{ $item->total_waktu_kerja ? $item->total_waktu_kerja . ' Jam' : '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $data->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
