
# Sistem Informasi Sekolah

Sistem informasi sekolah berbasis laravel 11 dengan template dashboard
[Stisla](https://getstisla.com/)
## Authors

- [Pascal Adnan](https://www.github.com/lacsapadnan)


## Fitur

- CRUD Jurusan
- CRUD Mata Pelajaran
- CRUD Guru
- CRUD Kelas
- CRUD User
- CRUD Materi
- CRUD Tugas & Jawaban
- CRUD Jadwal Sekolah


## Screenshots

![Login](https://i.ibb.co/QrvFVsq/download.png)

![Dashboard](https://i.ibb.co/4Vvff5F/Screenshot-3.jpg)


## Instalasi

clone project atau download

```bash
  git clone https://github.com/lacsapadnan/Sistem-Informasi-Sekolah.git
  cd Sistem-Informasi-Sekolah
  npm install
  composer install
  cp .env.example .env
```

Buka `.env` dan atur database anda
```bash
  DB_PORT=3306
  DB_DATABASE=laravel
  DB_USERNAME=root
  DB_PASSWORD=
```

Install website
```bash
  php artisan key:generate
  php artisan migrate --seed
```

Jalankan website
```bash
  php artisan serve
```
## Default akun untuk testing

Admin
```bash
  email : admin@mail.com
  password : admin123
```

Guru
```bash
  email : budi@mail.com
  password : budi123

  email : gunawan@mail.com
  password : gunawan123
```

Siswa
```bash
  email : kevin@mail.com
  password : kevin123

  email : siska@mail.com
  password : siska123
```
## Update Selanjutnya

(Free Version)
- Fitur Pengumuman Sekolah ✅
- Role Orang tua (Lihat pengumpulan tugas) ✅
- Pengaturan ✅

(Premium Version)
- Premium Template Metronic ✅
- Fitur Absensi ✅
- Fitur Kuis atau Ujian ✅
- Fitur Tabungan Siswa ✅
- Fitur Pembayaran Sekolah ✅
- Payment Gateway (Midtrans, Xendit, Tripay, dll) ✅(Currently Xendit Integrated)
- Role Orangtua (Lihat absensi, nilai) ✅
- Fitur e-rapot ✅
- Fitur nilai tugas ✅


## DEMO PREMIUM

https://sekolah.karsagroup.id

Admin
```bash
  email : admin@mail.com
  password : password
```

## PEMBELIAN

~~Promo 10/10 Orang Pertama **500rb**~~
Promo 15/20 Kloter Berikutnya **750rb**

Hubungi 
- https://wa.me/6282244793613
- http://instagram.com/lacsapadnan
