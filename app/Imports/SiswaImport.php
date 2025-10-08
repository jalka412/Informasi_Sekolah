<?php

namespace App\Imports;

use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Guru;
use App\Models\Jurusan; // <-- Tambahkan ini

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

            $placeholderGuru = Guru::where('nip', 'GURU-PLACEHOLDER')->first();

            $kelas = Kelas::create([
                'nama_kelas' => $namaKelas,
                'jurusan_id' => $jurusanId,
                'guru_id'    => $placeholderGuru->id, // Use the placeholder guru's ID
            ]);
        }
        // --- BATAS LOGIKA KELAS ---

        if (Siswa::where('nis', $row['nis'])->exists()) {
            return null;
        }

        $jenisKelamin = (!empty($row['jenis_kelamin']) && strtoupper(trim($row['jenis_kelamin'])) == 'L') ? 'Laki-laki' : 'Perempuan';

        return new Siswa([
            'nama'          => $row['nama'],
            'nis'           => $row['nis'],
            'kelas_id'      => $kelas->id,
            'telp'          => !empty($row['telp']) ? $row['telp'] : 'Belum Diisi',
            'alamat'        => !empty($row['alamat']) ? $row['alamat'] : 'Belum Diisi',
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