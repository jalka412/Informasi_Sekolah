<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MapelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('mapels')->truncate();
        Schema::enableForeignKeyConstraints();

        DB::table('mapels')->insert([
            [
                'nama_mapel' => 'Biologi',
                'jurusan_id' => 1, // Assumes Jurusan with id 1 (IPA) exists
            ],
            [
                'nama_mapel' => 'Ekonomi',
                'jurusan_id' => 2, // Assumes Jurusan with id 2 (IPS) exists
            ],
        ]);
    }
}