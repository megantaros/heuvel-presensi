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
            <video id="video" class="mx-auto" width="280" height="280" autoplay></video>
            <form id="attendanceForm" class="mx-auto" action="/absen" method="POST">
                @csrf
                <input type="hidden" name="latitude" id="latitude">
                <input type="hidden" name="longitude" id="longitude">
                <input type="hidden" name="foto" id="image">
                @switch($status)
                    @case('working')
                    <div class="d-flex justify-content-center align-items-center gap-1">
                        {{-- <button type="submit" class="btn btn-outline-primary">Absen Pulang</button> --}}
                        <button id="snap" class="btn btn-danger">Absen Pulang</button>
                    </div>
                    @break

                    @case('not_coming')
                    <div class="d-flex justify-content-center align-items-center gap-1">
                        {{-- <button type="submit" class="btn btn-primary">Absen Masuk</button> --}}
                        <button id="snap" class="btn btn-success">Absen Masuk</button>
                    </div>
                    @break

                    @default
                        <button type="button" class="btn btn-outline-success">Selamat Istirahat</button>
                @endswitch
            </form>
            <canvas 
                id="canvas" 
                class="mx-auto" 
                width="480" 
                height="480" 
                style="display: none;"
            ></canvas>
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

        // Mendapatkan elemen untuk latitude dan longitude
        const latitudeInput = document.getElementById('latitude');
        const longitudeInput = document.getElementById('longitude');

        // Mendapatkan lokasi pengguna
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition((position) => {
                latitudeInput.value = position.coords.latitude;
                longitudeInput.value = position.coords.longitude;
            }, (error) => {
                console.error("Error getting location: ", error);
            });
        } else {
            console.error("Geolocation is not supported by this browser.");
        }

        // Mengakses elemen HTML untuk kamera
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const snap = document.getElementById('snap');
        const imageInput = document.getElementById('image');

        // Meminta akses ke kamera
        navigator.mediaDevices.getUserMedia({ video: true })
            .then(stream => {
                video.srcObject = stream;
            })
            .catch(err => {
                console.error("Error accessing camera: ", err);
            });

        // Menangkap gambar saat tombol diklik
        snap.addEventListener('click', () => {
            const context = canvas.getContext('2d');
            context.drawImage(video, 0, 0, 640, 480);
            const imageData = canvas.toDataURL('image/png');
            imageInput.value = imageData;
        });

        // Menambahkan SweetAlert untuk konfirmasi form submit
        document.getElementById('attendanceForm').addEventListener('submit', (e) => {
            e.preventDefault(); // Mencegah form dikirim secara langsung

            if (!imageInput.value) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please take a picture first!',
                });
                return;
            }

            Swal.fire({
                title: 'Are you sure?',
                text: "You are about to submit your attendance.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, submit it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    e.target.submit();
                }
            });
        });
    </script>
@endsection
