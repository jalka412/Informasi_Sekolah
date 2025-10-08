<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Guru;

class PlaceholderGuruSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Guru::updateOrCreate(
            ['nip' => 'GURU-PLACEHOLDER'], // Unique identifier
            [
                'nama' => 'Belum Ditentukan',
                'mapel_id' => 1, // Assuming a mapel with ID 1 exists.
                'no_telp' => '0000',
                'alamat' => '-',
            ]
        );
    }
}