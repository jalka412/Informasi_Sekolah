<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class JurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Disable foreign key checks
        Schema::disableForeignKeyConstraints();

        // Kosongkan tabel dulu untuk menghindari duplikat
        DB::table('jurusans')->truncate();

        // Re-enable foreign key checks
        Schema::enableForeignKeyConstraints();

        DB::table('jurusans')->insert([
            ['nama_jurusan' => 'IPA'],
            ['nama_jurusan' => 'IPS'],
            ['nama_jurusan' => 'TKJ'], // Teknik Komputer dan Jaringan
            ['nama_jurusan' => 'RPL'], // Rekayasa Perangkat Lunak
            ['nama_jurusan' => 'TSM'], // Teknik dan Bisnis Sepeda Motor
            ['nama_jurusan' => 'AKL'], // Akuntansi dan Keuangan Lembaga
            ['nama_jurusan' => 'OTKP'], // Otomatisasi dan Tata Kelola Perkantoran
            ['nama_jurusan' => 'BDP'], // Bisnis Daring dan Pemasaran
            ['nama_jurusan' => 'MM'], // Multimedia
        ]);
    }
}
