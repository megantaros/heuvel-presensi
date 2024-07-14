@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @foreach ($errors->all() as $message)
            <div class="alert alert-warning alert-dismissible" role="alert">
                {{ $message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endforeach
        <!-- Basic Layout & Basic with Icons -->
        <div class="row">
            <!-- Basic with Icons -->
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">{{ isset($user) ? 'Edit' : 'Input' }} Data Karyawan</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ isset($user) ? route('users.update', $user->id) : route('users.store') }}" method="POST">
                            @csrf
                            @if (isset($user))
                                @method('PUT')
                            @endif
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Name</label>
                                <div class="col-sm-10">
                                    <div class="input-group input-group-merge">
                                        <span id="basic-icon-default-fullname2"
                                            class="@error('nama') border-danger @enderror input-group-text"><i
                                                class="bx bx-user"></i></span>
                                        <input type="text" class="@error('nama') is-invalid @enderror form-control"
                                            id="basic-icon-default-fullname" placeholder="John Doe" aria-label="John Doe"
                                            aria-describedby="basic-icon-default-fullname2" name="nama"
                                            value="{{ isset($user) ? $user->nama : old('nama') }}" />
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="basic-icon-default-nip">NIP</label>
                                <div class="col-sm-10">
                                    <div class="input-group input-group-merge">
                                        <span id="basic-icon-default-nip2"
                                            class="@error('nip') border-danger @enderror input-group-text"><i
                                                class="bx bx-buildings"></i></span>
                                        <input maxlength="10" minlength="10" type="text" id="basic-icon-default-nip"
                                            class="@error('nip') is-invalid @enderror form-control" placeholder="NIP"
                                            name="nip" aria-describedby="basic-icon-default-nip2"
                                            value="{{ isset($user) ? $user->nip : old('nip') }}" />
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="basic-icon-default-email">Email</label>
                                <div class="col-sm-10">
                                    <div class="input-group input-group-merge">
                                        <span class="@error('email') border-danger @enderror input-group-text"><i
                                                class="bx bx-envelope"></i></span>
                                        <input type="text" id="basic-icon-default-email"
                                            class="form-control @error('email') is-invalid @enderror "
                                            placeholder="john.doe" aria-label="john.doe"
                                            aria-describedby="basic-icon-default-email2" name="email"
                                            value="{{ isset($user) ? $user->email : old('email') }}" />
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="basic-icon-default-password">Password</label>
                                <div class="col-sm-10">
                                    <div class="input-group input-group-merge">
                                        <span id="basic-icon-default-password2"
                                            class="@error('password') border-danger @enderror input-group-text"><i
                                                class='bx bxs-key'></i></span>
                                        <input type="password" id="basic-icon-default-password"
                                            class="@error('password') is-invalid @enderror form-control phone-mask"
                                            placeholder="Password" aria-label="password"
                                            aria-describedby="basic-icon-default-password2" name="password" />
                                    </div>
                                    @if (isset($user))
                                        <div class="form-text">Kosongkan jika tidak ingin mengubah password</div>
                                    @endif
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="basic-icon-default-divisi">Jabatan</label>
                                <div class="col-sm-10">
                                    <div class="input-group input-group-merge">
                                        <select required id="defaultSelect" name="id_jabatan"
                                            class="form-select @error('id_jabatan') is-invalid @enderror ">
                                            @foreach ($jabatan as $item)
                                                <option value="{{ $item->id }}" @selected(isset($user) ? $user->id_jabatan === $item->id : old('id_jabatan') === $item->id)>
                                                    {{ $item->nama_jabatan }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-end">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
