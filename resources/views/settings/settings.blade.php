@extends('layouts.app')

@section('content')
    <div class="container-xxl container-p-y">
        @foreach ($errors->all() as $message)
            <div class="alert alert-warning alert-dismissible" role="alert">
                {{ $message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endforeach
        @if (session('status'))
            <div class="alert alert-success alert-dismissible" role="alert">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="card">
            <!-- Let all your things have their places; let each part of your business have its time. - Benjamin Franklin -->
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Pengaturan Sistem</h5>
            </div>
            <div class="card-body">
                <form action="/settings" method="POST">
                    @csrf
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Jam Masuk</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span id="basic-icon-default-masuk"
                                    class="@error('jam_masuk') border-danger @enderror input-group-text"><i
                                        class="bx bx-user"></i></span>
                                <input required type="time" class="@error('jam_masuk') is-invalid @enderror form-control"
                                    id="basic-icon-default-fullname" placeholder="John Doe" aria-label="John Doe"
                                    aria-describedby="basic-icon-default-masuk" name="jam_masuk"
                                    value="{{ $settings->firstWhere('key', 'jam_masuk')?->value }}" />
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Jam Pulang</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span id="basic-icon-default-pulang"
                                    class="@error('jam_pulang') border-danger @enderror input-group-text"><i
                                        class="bx bx-home"></i></span>
                                <input required type="time" class="@error('jam_pulang') is-invalid @enderror form-control"
                                    id="basic-icon-default-fullname" placeholder="John Doe" aria-label="John Doe"
                                    aria-describedby="basic-icon-default-pulang" name="jam_pulang"
                                    value="{{ $settings->firstWhere('key', 'jam_pulang')?->value }}" />
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Potongan Gaji per Jam</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span id="basic-icon-default-potongan"
                                    class="@error('potongan_gaji_per_jam') border-danger @enderror input-group-text">Rp</span>
                                <input required type="number" class="@error('potongan_gaji_per_jam') is-invalid @enderror form-control"
                                    id="basic-icon-default-fullname" placeholder="John Doe" aria-label="John Doe"
                                    aria-describedby="basic-icon-default-potongan" name="potongan_gaji_per_jam"
                                    value="{{ $settings->firstWhere('key', 'potongan_gaji_per_jam')?->value }}" />
                            </div>
                        </div>
                    </div>
                    <div class="d-flex">
                        <button type="submit" class="ms-auto btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
