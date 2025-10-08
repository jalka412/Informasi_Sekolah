<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class JadwalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('jadwals')->truncate();
        Schema::enableForeignKeyConstraints();

        DB::table('jadwals')->insert([
            [
                'kelas_id' => 1,
                'mapel_id' => 1,
                'hari' => 'Senin',
                'dari_jam' => '07:00:00',
                'sampai_jam' => '08:00:00',
            ],
            [
                'kelas_id' => 2,
                'mapel_id' => 2,
                'hari' => 'Selasa',
                'dari_jam' => '07:00:00',
                'sampai_jam' => '08:00:00',
            ],
        ]);
    }
}