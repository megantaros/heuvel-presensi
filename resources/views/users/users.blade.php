@extends('layouts.app')

@section('content')
    <div class="container-xl pt-4">
        @if (session('status'))
            <div class="alert alert-success alert-dismissible mb-4" role="alert">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="card">
            <div class="d-flex flex-wrap justify-content-between">
                <h5 class="card-header">Data Karyawan</h5>
                <div class="my-auto mx-3 d-flex align-items-center gap-2">
                    <form action="{{ route('users.index', request()->query()) }}" class="input-group" method="GET">
                        <input type="text" name="search" class="form-control" placeholder="Cari karyawan" aria-label="Cari karyawan">
                        <button class="btn btn-outline-secondary" type="submit" id="button-addon2">
                            <i class="bx bx-search"></i>
                        </button>
                    </form>
                    <a href="{{ route('users.index') }}" class="btn btn-secondary">
                        <i class="bx bx-refresh"></i>
                    </a>
                    <a role="button" href="{{ route('print.karyawan') }}" class="btn btn-danger">
                        <i class='bx bxs-file-pdf'></i>
                    </a>
                    <a href="/users/create" class="btn btn-primary">
                        <i class="bx bx-plus"></i>
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive text-nowrap pb-5">
                    <table class="table table-striped mb-5">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Jabatan</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration + $users->perPage() * ($users->currentPage() - 1) }}</td>
                                    <td><strong>{{ $user->nama }}</strong>
                                    </td>
                                    <td>{{ $user->jabatan->nama_jabatan }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="/users/{{ $user->id }}/edit"><i
                                                        class="bx bx-edit-alt me-1"></i> Edit</a>
                                                <a onclick="setUser({{ $user }})" class="dropdown-item"
                                                    data-bs-toggle="modal" data-bs-target="#smallModal"><i
                                                        class="bx bx-trash-alt me-1"></i> Hapus</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="smallModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <form class="modal-content" id="formDeleteUser" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel2">Hapus Data Karyawan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda ingin menghapus akun dan data milik <strong><span id="textDeleteUser"></span></strong>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let user = {};
        const formDelete = document.getElementById('formDeleteUser');
        const text = document.getElementById('textDeleteUser');

        const setUser = (userData) => {
            user = userData;

            formDeleteUser.setAttribute('action', `/users/${user.id}`)
            text.innerHTML = user.nama;
        }
    </script>
@endsection
