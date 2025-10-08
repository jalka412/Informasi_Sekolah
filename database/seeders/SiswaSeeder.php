<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('siswas')->truncate();
        Schema::enableForeignKeyConstraints();

        DB::table('siswas')->insert([
            [
                'nama' => 'Kevin Hartanto',
                'nis' => '123454321',
                'kelas_id' => 1,
                'telp' => '081234567890',
                'alamat' => 'Jl. Kevin Hartanto',
            ],
            [
                'nama' => 'Siska Saraswati',
                'nis' => '543212345',
                'kelas_id' => 2,
                'telp' => '089876543210',
                'alamat' => 'Jl. Siska Saraswati',
            ],
        ]);
    }
}