<?php

namespace App\Imports;

use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\User;
use App\Models\Jurusan; // <-- Tambahkan ini
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;

class SiswaImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        if (empty($row['nama']) || empty($row['kelas']) || empty($row['nis'])) {
            return null;
        }

        // --- LOGIKA PENCARIAN & PEMBUATAN KELAS BARU ---
        $namaKelas = trim($row['kelas']);
        $kelas = Kelas::whereRaw('LOWER(nama_kelas) = ?', [strtolower($namaKelas)])->first();

        // Jika kelas TIDAK ditemukan, buat kelas baru
        if (!$kelas) {
            $jurusanId = $this->findJurusanId($namaKelas);

            // Jika jurusan tidak bisa ditebak, lewati siswa ini
            if (!$jurusanId) {
                return null; 
            }

            $kelas = Kelas::create([
                'nama_kelas' => $namaKelas,
                'jurusan_id' => $jurusanId,
                'guru_id'    => 1, // <-- !! GANTI ANGKA 1 DENGAN ID GURU "BELUM DITENTUKAN"
            ]);
        }
        // --- BATAS LOGIKA KELAS ---

        if (Siswa::where('nis', $row['nis'])->exists()) {
            return null;
        }
        
        $namaDepan = Str::lower(strtok($row['nama'], ' '));
        $email = $namaDepan . '.' . $row['nis'] . '@sekolah.sch.id';

        if (User::where('email', $email)->exists()) {
            $email = $namaDepan . '.' . $row['nis'] . rand(1, 99) . '@sekolah.sch.id';
        }

        $user = User::create([
            'name'     => $row['nama'],
            'email'    => $email,
            'password' => Hash::make('password'),
            'roles'    => 'siswa',
        ]);

        $jenisKelamin = (!empty($row['jenis_kelamin']) && strtoupper(trim($row['jenis_kelamin'])) == 'L') ? 'Laki-laki' : 'Perempuan';

        return new Siswa([
            'user_id'       => $user->id,
            'nama'          => $row['nama'],
            'nis'           => $row['nis'],
            'kelas_id'      => $kelas->id,
            'telp'          => $row['telp'] ?? null,
            'alamat'        => $row['alamat'] ?? null,
            'jenis_kelamin' => $jenisKelamin,
            'foto'          => 'images/siswa/default.png',
        ]);
    }

    /**
     * Fungsi pintar untuk menebak Jurusan ID dari nama kelas.
     */
    private function findJurusanId($namaKelas)
    {
        $jurusans = Jurusan::all();
        foreach ($jurusans as $jurusan) {
            // Jika nama jurusan (e.g., "TSM") ada di dalam nama kelas (e.g., "X TSM 1")
            if (str_contains(strtoupper($namaKelas), strtoupper($jurusan->nama_jurusan))) {
                return $jurusan->id;
            }
        }
        return null; // Return null jika tidak ada yang cocok
    }
}