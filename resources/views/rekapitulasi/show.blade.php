@extends('layouts.app')

@section('content')
    <div class="container-xl container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="m-0">Data Kehadiran <strong>{{ $user->nama }}</strong></h4>
            <a type="button" href="/recap/{{ $user->id }}/print" class="btn btn-primary">
                <i class="bx bxs-file-pdf"></i> Cetak
            </a>
        </div>
        <div class="d-flex row mb-4">
            <div class="col col-sm-4">
                <div class="card">
                    <div class="card-body">
                        <p>Jumlah Kehadiran</p>
                        <span class="text-primary fs-3">{{ $count }}x</span>
                    </div>
                </div>
            </div>
            <div class="col col-sm-4">
                <div class="card">
                    <div class="card-body">
                        <p>Total Jam Terlambat</p>
                        <span class="text-primary fs-3">{{ $totalLateHours }} Jam</span>
                    </div>
                </div>
            </div>
            <div class="col col-sm-4">
                <div class="card">
                    <div class="card-body">
                        <p>Potongan Gaji</p>
                        <span class="text-primary fs-3">{{ $salaryCuts }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
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
                            <button type="button" onclick="window.location.href = '/recap/{{ $user->id }}'" class="ms-2 mb-auto btn btn-outline-primary">Reset</button>
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
                                <th>Tanggal</th>
                                <th>Waktu Masuk</th>
                                <th>Keterlambatan</th>
                                <th>Waktu Pulang</th>
                                <th>Total Jam Kerja</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $loop->iteration + $data->perPage() * ($data->currentPage() - 1) }}</td>
                                    <td>{{ $item->tanggal }}</td>
                                    <td>{{ $item->waktu_masuk }}</td>
                                    <td>{{ $item->total_jam_terlambat }} Jam</td>
                                    <td>{{ $item->waktu_keluar ?? '-' }}</td>
                                    <td>{{ $item->total_waktu_kerja ?? '-' }} Jam</td>
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
