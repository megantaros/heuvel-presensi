<?php

namespace Database\Seeders;

use App\Models\Absen;
use App\Models\Jabatan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $password = Hash::make('password');
        $punchIn = '09:34:00';
        $punchOut = '16:00:00';
        $diffLate = round(Carbon::parse('09:00:00')->diffInMinutes($punchIn) / 60);

        // Menghitung selisih waktu punch in dan punch out dalam jam
        $diffPunchInOut = round(Carbon::parse($punchIn)->diffInMinutes($punchOut) / 60);

        // Menghitung selisih waktu terlambat dalam menit
        $minutesLate = Carbon::parse('09:00:00')->diffInMinutes($punchIn);

        // Mengonversi menit terlambat ke jam dan menit
        $hoursLate = intdiv($minutesLate, 60);
        $remainingMinutesLate = $minutesLate % 60;

        // Membuat string keterangan
        $keterangan = "Terlambat $hoursLate jam $remainingMinutesLate menit";

        // Menampilkan hasil
        echo $keterangan;

        DB::beginTransaction();

        try {
            Jabatan::insert([
                ['id' => 1, 'nama_jabatan' => 'Produksi'],
                ['id' => 2, 'nama_jabatan' => 'Admin Keuangan'],
                ['id' => 3, 'nama_jabatan' => 'Staff Admin Keuangan'],
                ['id' => 4, 'nama_jabatan' => 'Designer'],
                ['id' => 5, 'nama_jabatan' => 'Graphic Designer'],
                ['id' => 6, 'nama_jabatan' => 'Content Creator'],
                ['id' => 7, 'nama_jabatan' => 'Staff Inventory'],
                ['id' => 8, 'nama_jabatan' => 'Admin Penjualan'],
                ['id' => 9, 'nama_jabatan' => 'Admin CS'],
                ['id' => 10, 'nama_jabatan' => 'Staff Photo & Video Grapher'],
                ['id' => 11, 'nama_jabatan' => 'Kebersihan'],
                ['id' => 12, 'nama_jabatan' => 'Host Live'],
                ['id' => 13, 'nama_jabatan' => 'Host Live Freelance'],
                ['id' => 14, 'nama_jabatan' => 'Head Store'],
                ['id' => 15, 'nama_jabatan' => 'Shopkeeper'],
            ]);

            $produksi = User::create([
                'nama' => 'Rudi Triana',
                'email' => 'produksi@gmail.com',
                'password' => $password,
                'nip' => '0000000001',
                'id_jabatan' => Jabatan::find(1)->id,
            ]);

            for ($i = 0; $i < 2; $i++) {
                Absen::create([
                    'id_user' => $produksi->id,
                    'tanggal' => Carbon::now()->subDays($i)->format('Y-m-d'),
                    'waktu_masuk' => $punchIn,
                    'waktu_keluar' => $punchOut,
                    'total_jam_terlambat' => $diffLate,
                    'total_waktu_kerja' => $diffPunchInOut,
                    'keterangan' => $keterangan,
                    'foto' => 'https://via.placeholder.com/150',
                    'latitude' => '-6.200000',
                    'longitude' => '106.816666',
                    'lokasi' => 'https://www.google.com/maps/search/?api=1&query=-6.200000,106.816666',
                    'jenis' => 'hadir',
                ]);
            }

            // $produksi->assignRole('super_user');

            $adminKeuangan = User::create(
                [
                    'nama' => 'Nadira Alisha Putri',
                    'email' => 'adminkeuangan@gmail.com',
                    'password' => $password,
                    'nip' => '0000000002',
                    'id_jabatan' => Jabatan::find(2)->id,
                ],
            );

            // $adminKeuangan->assignRole('super_user');

            for ($i = 0; $i < 2; $i++) {
                Absen::create([
                    'id_user' => $adminKeuangan->id,
                    'tanggal' => Carbon::now()->subDays($i)->format('Y-m-d'),
                    'waktu_masuk' => '09:34:09',
                    'waktu_keluar' => $punchOut,
                    'total_jam_terlambat' => $diffLate,
                    'total_waktu_kerja' => $diffPunchInOut,
                    'keterangan' => $keterangan,
                    'foto' => 'https://via.placeholder.com/150',
                    'latitude' => '-6.200000',
                    'longitude' => '106.816666',
                    'lokasi' => 'https://www.google.com/maps/search/?api=1&query=-6.200000,106.816666',
                    'jenis' => 'hadir',
                ]);
            }

            $staffAdminKeuangan = User::create([
                'nama' => 'Riska',
                'email' => 'staffadminkeuangan@gmail.com',
                'password' => $password,
                'nip' => '0000000003',
                'id_jabatan' => Jabatan::find(3)->id,
            ]);

            // $staffAdminKeuangan->assignRole('super_user');

            for ($i = 0; $i < 2; $i++) {
                Absen::create([
                    'id_user' => $staffAdminKeuangan->id,
                    'tanggal' => Carbon::now()->subDays($i)->format('Y-m-d'),
                    'waktu_masuk' => '09:34:09',
                    'waktu_keluar' => $punchOut,
                    'total_jam_terlambat' => $diffLate,
                    'total_waktu_kerja' => $diffPunchInOut,
                    'keterangan' => $keterangan,
                    'foto' => 'https://via.placeholder.com/150',
                    'latitude' => '-6.200000',
                    'longitude' => '106.816666',
                    'lokasi' => 'https://www.google.com/maps/search/?api=1&query=-6.200000,106.816666',
                    'jenis' => 'hadir',
                ]);
            }

            $designer = User::create([
                'nama' => 'Muh Dzikri Abi',
                'email' => 'designer@gmail.com',
                'password' => $password,
                'nip' => '0000000004',
                'id_jabatan' => Jabatan::find(4)->id,
            ]);

            for ($i = 0; $i < 2; $i++) {
                Absen::create([
                    'id_user' => $designer->id,
                    'tanggal' => Carbon::now()->subDays($i)->format('Y-m-d'),
                    'waktu_masuk' => '09:34:09',
                    'waktu_keluar' => $punchOut,
                    'total_jam_terlambat' => $diffLate,
                    'total_waktu_kerja' => $diffPunchInOut,
                    'keterangan' => $keterangan,
                    'foto' => 'https://via.placeholder.com/150',
                    'latitude' => '-6.200000',
                    'longitude' => '106.816666',
                    'lokasi' => 'https://www.google.com/maps/search/?api=1&query=-6.200000,106.816666',
                    'jenis' => 'hadir',
                ]);
            }

            // Before seeding, make sure to run the following command:

            // Jabatan::insert([
            //     ['id' => 1, 'nama_jabatan' => 'Admin'],
            //     ['id' => 2, 'nama_jabatan' => 'Admin Sosmed'],
            //     ['id' => 3, 'nama_jabatan' => 'Manajer'],
            //     ['id' => 4, 'nama_jabatan' => 'Kasir'],
            //     ['id' => 5, 'nama_jabatan' => 'Stokis'],
            // ]);

            // $admin = User::create([
            //     'nama' => fake()->name,
            //     'email' => 'admin@absen.app',
            //     'password' => $password,
            //     'nip' => '0000000001',
            //     'id_jabatan' => Jabatan::find(1)->id,
            // ]);

            // $admin->assignRole('super_user');

            // for ($i = 0; $i < 2; $i++) {
            //     Absen::create([
            //         'id_user' => $admin->id,
            //         'tanggal' => Carbon::now()->subDays($i)->format('Y-m-d'),
            //         'waktu_masuk' => $punchIn,
            //         'waktu_keluar' => $punchOut,
            //         'total_jam_terlambat' => $diffLate,
            //         'total_waktu_kerja' => $diffPunchInOut,
            //         'keterangan' => $keterangan,
            //     ]);
            // }

            // $adminSosmed = User::create([
            //     'nama' => fake()->name,
            //     'email' => 'admin.sosmed@absen.app',
            //     'password' => $password,
            //     'nip' => '0000000002',
            //     'id_jabatan' => Jabatan::find(2)->id,
            // ]);

            // for ($i = 0; $i < 2; $i++) {
            //     Absen::create([
            //         'id_user' => $adminSosmed->id,
            //         'tanggal' => Carbon::now()->subDays($i)->format('Y-m-d'),
            //         'waktu_masuk' => '09:34:09',
            //         'waktu_keluar' => $punchOut,
            //         'total_jam_terlambat' => $diffLate,
            //         'total_waktu_kerja' => $diffPunchInOut,
            //         'keterangan' => $keterangan,
            //     ]);
            // }

            // $manager = User::create([
            //     'nama' => fake()->name,
            //     'email' => 'manager@absen.app',
            //     'password' => $password,
            //     'nip' => '0000000003',
            //     'id_jabatan' => Jabatan::find(3)->id,
            // ]);

            // $manager->assignRole('super_user');

            // for ($i = 0; $i < 2; $i++) {
            //     Absen::create([
            //         'id_user' => $manager->id,
            //         'tanggal' => Carbon::now()->subDays($i)->format('Y-m-d'),
            //         'waktu_masuk' => '09:34:09',
            //         'waktu_keluar' => $punchOut,
            //         'total_jam_terlambat' => $diffLate,
            //         'total_waktu_kerja' => $diffPunchInOut,
            //         'keterangan' => $keterangan,
            //     ]);
            // }

            // $kasir = User::create([
            //     'nama' => fake()->name,
            //     'email' => 'kasir@absen.app',
            //     'password' => $password,
            //     'nip' => '0000000004',
            //     'id_jabatan' => Jabatan::find(4)->id,
            // ]);

            // for ($i = 0; $i < 2; $i++) {
            //     Absen::create([
            //         'id_user' => $kasir->id,
            //         'tanggal' => Carbon::now()->subDays($i)->format('Y-m-d'),
            //         'waktu_masuk' => '09:34:09',
            //         'waktu_keluar' => $punchOut,
            //         'total_jam_terlambat' => $diffLate,
            //         'total_waktu_kerja' => $diffPunchInOut,
            //         'keterangan' => $keterangan,
            //     ]);
            // }

            // $stokis = User::create([
            //     'nama' => fake()->name,
            //     'email' => 'stokis@absen.app',
            //     'password' => $password,
            //     'nip' => '0000000005',
            //     'id_jabatan' => Jabatan::find(5)->id,
            // ]);

            // for ($i = 0; $i < 2; $i++) {
            //     Absen::create([
            //         'id_user' => $stokis->id,
            //         'tanggal' => Carbon::now()->subDays($i)->format('Y-m-d'),
            //         'waktu_masuk' => '09:34:09',
            //         'waktu_keluar' => $punchOut,
            //         'total_jam_terlambat' => $diffLate,
            //         'total_waktu_kerja' => $diffPunchInOut,
            //         'keterangan' => $keterangan,
            //     ]);
            // }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}