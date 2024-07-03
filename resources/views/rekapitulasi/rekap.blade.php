@extends('layouts.app')

@section('content')
    <div class="container-xl container-p-y">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Rekapitulasi per Orang</h5>
                <div class="my-auto d-flex align-items-center gap-2">
                    <form action="{{ route('recap', request()->query()) }}" class="input-group" method="GET">
                        <input type="text" name="search" class="form-control" placeholder="Cari karyawan" aria-label="Cari karyawan">
                        <button class="btn btn-outline-secondary" type="submit" id="button-addon2">
                            <i class="bx bx-search"></i>
                        </button>
                    </form>
                    <a href="{{ route('recap') }}" class="btn btn-secondary">
                        <i class="bx bx-refresh"></i>
                    </a>
                    <a role="button" href="{{ route('print.rekapitulasi') }}" class="btn btn-danger">
                        <i class='bx bxs-file-pdf'></i>
                    </a>
                    <a href="/users/create" class="btn btn-primary">
                        <i class="bx bx-plus"></i>
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive text-nowrap pb-2">
                    <table class="table table-hover mb-5">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Jabatan</th>
                                <th>Total Jam Masuk</th>
                                <th>Total Jam Terlambat</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($results as $index => $user)
                                <tr role="button" onclick="window.location.href = '/recap/{{ $user['id'] }}'">
                                    <td>{{ $index + 1 + $users->perPage() * ($users->currentPage() - 1) }}</td>
                                    <td><strong>{{ $user['nama'] }}</strong></td>
                                    <td>{{ $user['jabatan'] }}</td>
                                    <td>{{ $user['jumlah'] }} Jam</td>
                                    <td>{{ $user['total_jam_terlambat'] }} Jam</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
