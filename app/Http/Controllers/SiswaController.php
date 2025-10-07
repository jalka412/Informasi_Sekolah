<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;

// Tambahkan use statement untuk fitur Impor & Ekspor
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\SiswaImport;
use App\Exports\SiswaTemplateExport; // Ganti jika Anda membuat template khusus absensi

class SiswaController extends Controller
{
    /**
     * Menampilkan daftar semua siswa.
     */
    public function index()
    {
        // Menggunakan with('kelas') untuk performa lebih baik dan mencegah error
        $siswas = Siswa::with('kelas')->OrderBy('nama', 'asc')->get();
        $kelas = Kelas::all();
        return view('pages.admin.siswa.index', compact('siswas', 'kelas'));
    }

    /**
     * Menyimpan siswa baru dari form modal.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required',
            'nis' => 'required|unique:siswas',
            'telp' => 'required',
            'alamat' => 'required',
            'kelas_id' => 'required', // Pastikan ID kelas dikirim
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $fotoPath = $request->file('foto')->store('images/siswa', 'public');

        Siswa::create([
            'nama' => $request->nama,
            'nis' => $request->nis,
            'telp' => $request->telp,
            'alamat' => $request->alamat,
            'kelas_id' => $request->kelas_id,
            'foto' => $fotoPath,
        ]);

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil ditambahkan');
    }

    /**
     * [BARU] Method untuk menangani proses impor dari file absensi.
     */
    public function import(Request $request)
{
    // 1. Validasi hanya untuk file saja
    $request->validate([
        'file' => 'required|mimes:csv,xls,xlsx',
    ]);

    try {
        // 2. Lakukan impor, tidak perlu kirim kelas_id lagi
        Excel::import(new SiswaImport, $request->file('file'));

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil diimpor!');
    } catch (\Exception $e) {
        // Beri pesan error yang lebih detail untuk debugging
        return redirect()->route('siswa.index')->with('error', 'Terjadi kesalahan. Pastikan kolom "kelas_id" diisi dengan ID Angka yang valid. Pesan: ' . $e->getMessage());
    }
}

    /**
     * [BARU] Method untuk download template.
     * (Saat ini kita tidak pakai, tapi baik untuk disimpan)
     */
    public function exportTemplate()
    {
        // Jika Anda ingin membuat template untuk format absensi,
        // Anda perlu membuat class Export baru yang sesuai.
        // Untuk saat ini, kita bisa menonaktifkannya jika tidak dipakai.
        return Excel::download(new SiswaTemplateExport, 'template_siswa.xlsx');
    }


    // ... (Sisa method Anda: show, edit, update, destroy) ...
    
    public function show($id)
    {
        $id = Crypt::decrypt($id);
        $siswas = Siswa::findOrFail($id);
        return view('pages.admin.siswa.profile', compact('siswa'));
    }

    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $kelas = Kelas::all();
        $siswas = Siswa::findOrFail($id);
        return view('pages.admin.siswa.edit', compact('siswa', 'kelas'));
    }

    public function update(Request $request, Siswa $siswas)
    {
        if ($request->nis != $siswas->nis) {
            $this->validate($request, ['nis' => 'unique:siswas']);
        }
        
        $dataToUpdate = $request->only(['nama', 'nis', 'telp', 'alamat', 'kelas_id']);

        if ($request->hasFile('foto')) {
            if ($siswas->foto && File::exists(storage_path('app/public/' . $siswas->foto))) {
                File::delete(storage_path('app/public/' . $siswas->foto));
            }
            $dataToUpdate['foto'] = $request->file('foto')->store('images/siswa', 'public');
        }

        $siswas->update($dataToUpdate);

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil diubah');
    }

    public function destroy($id)
    {
        $siswas = Siswa::find($id);
        if ($siswas->foto && File::exists(storage_path('app/public/' . $siswas->foto))) {
            File::delete(storage_path('app/public/' . $siswas->foto));
        }
        $siswas->delete();
        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil dihapus');
    }
}