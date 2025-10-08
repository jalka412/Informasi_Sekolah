<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('kelas')->truncate();
        Schema::enableForeignKeyConstraints();

        DB::table('kelas')->insert([
            [
                'nama_kelas' => 'X IPA 1',
                'jurusan_id' => 1,
                'guru_id' => 1,
            ],
            [
                'nama_kelas' => 'X IPS 1',
                'jurusan_id' => 2,
                'guru_id' => 2,
            ],
        ]);
    }
}