<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // 1. Ambil semua ID guru yang sudah menjadi wali kelas
        $assignedGuruIds = Kelas::pluck('guru_id')->all();

        // 2. Ambil data guru yang ID-nya TIDAK ADA dalam daftar yang sudah ditugaskan
        $availableGurus = Guru::whereNotIn('id', $assignedGuruIds)->get();

        // 3. Ambil data lain yang dibutuhkan oleh view
        $kelas = Kelas::OrderBy('nama_kelas', 'asc')->get();
        $jurusan = Jurusan::all();

        // 4. Kirim semua data yang dibutuhkan ke view
        return view('pages.admin.kelas.index', compact('kelas', 'jurusan', 'availableGurus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nama_kelas' => 'required',
            'jurusan_id' => 'required',
            'guru_id' => 'required|unique:kelas,guru_id',
        ], [
            'guru_id.unique' => 'Guru ini sudah menjadi wali kelas lain.',
        ]);

        Kelas::create($request->all());

        return redirect()->route('kelas.index')->with('success', 'Data kelas berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // $id = Crypt::decrypt($id);
        $kelas = Kelas::findOrFail($id);
        $guru = Guru::all();
        return view('pages.admin.kelas.edit', compact('kelas', 'guru'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'guru_id' => 'required|unique:kelas'
        ], [
            'guru_id.unique' => 'Guru sudah memiliki kelas'
        ]);

        $data = $request->all();
        $kelas = Kelas::findOrFail($id);
        $kelas->update($data);

        return redirect()->route('kelas.index')->with('success', 'Data kelas berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Kelas::find($id)->delete();
        return back()->with('success', 'Data kelas berhasil dihapus!');
    }
}
