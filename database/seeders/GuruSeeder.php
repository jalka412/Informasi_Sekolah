<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class GuruSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('gurus')->truncate();
        Schema::enableForeignKeyConstraints();

        DB::table('gurus')->insert([
            [
                'nama' => 'Budi Santoso',
                'nip' => '1234567890',
                'mapel_id' => 1,
                'no_telp' => '081234567890',
                'alamat' => 'Jl. Budi Santoso',
            ],
            [
                'nama' => 'Gunawan Efendi',
                'nip' => '0987654321',
                'mapel_id' => 2,
                'no_telp' => '089876543210',
                'alamat' => 'Jl. Gunawan Efendi',
            ],
        ]);
    }
}