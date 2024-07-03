## User

| Email                  | Password | Jabatan      | Akses semua fitur |
| ---------------------- | -------- | ------------ | ----------------- |
| admin@absen.app        | password | Admin        | ya                |
| admin.sosmed@absen.app | password | Admin Sosmed | tidak             |
| manager@absen.app      | password | Manager      | ya                |
| kasir@absen.app        | password | Kasir        | tidak             |
| stokis@absen.app       | password | Stokis       | tidak             |

## Cara Setup Aplikasi

Untuk menjalankan aplikasi ini, dibutuhkan PHP versi 8.1 dan database MySQL.

1. Install dependensi Composer:

```bash
composer install
```

2. Install dependensi JS:

```bash
npm install
```

3. Copy file `env.example` dan paste dengan nama `.env`
4. Generate app key:

```bash
php artisan key:generate
```

5. Sesuaikan koneksi database di file `.env`
6. Jalankan migrasi database:

```bash
php artisan migrate
```

7. Jalankan Seeder:

```bash
php artisan db:seed
```

8. Jalankan aplikasi:

```bash
npm run build
```
```bash
cd public
```
```bash
php -S localhost:8000
```