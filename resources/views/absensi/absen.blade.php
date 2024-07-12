@extends('layouts.app')


@section('content')
    <div class="container-xl pt-4">
        @if (session('status'))
            <div class="alert alert-success alert-dismissible" role="alert">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @elseif (session('error'))
            <div class="alert alert-danger alert-dismissible" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="d-flex flex-column p-4">
            <h2 id="clock" class="fs-1 text-center my-5"></h2>
            <p class="text-center fs-5">Jam Kerja: 09:00 - 16:00</p>
            <form class="mx-auto" action="/absen" method="POST">
                @switch($status)
                    @case('working')
                        @csrf
                        <button type="submit" class="btn btn-outline-primary">Absen Pulang</button>
                    @break

                    @case('not_coming')
                        @csrf
                        <button type="submit" class="btn btn-primary">Absen Masuk</button>
                    @break

                    @default
                        <button type="button" class="btn btn-outline-success">Selamat Istirahat</button>
                @endswitch
            </form>
        </div>
    </div>

    <script>
        const displayClock = document.getElementById('clock');

        function updateClock() {
            // Mendapatkan waktu saat ini
            var currentTime = new Date();

            // Mendapatkan komponen jam, menit, dan detik
            var hours = currentTime.getHours();
            var minutes = currentTime.getMinutes();
            var seconds = currentTime.getSeconds();

            // Menambahkan 0 di depan jika nilai jam, menit, atau detik kurang dari 10
            hours = (hours < 10 ? "0" : "") + hours;
            minutes = (minutes < 10 ? "0" : "") + minutes;
            seconds = (seconds < 10 ? "0" : "") + seconds;

            // Menampilkan waktu di elemen dengan id "clock"
            displayClock.innerText = hours + ":" + minutes + ":" + seconds;
        }

        // Memperbarui waktu setiap detik
        setInterval(updateClock, 100);

        // Memanggil fungsi pertama kali agar jam muncul segera
        updateClock();
    </script>
@endsection
