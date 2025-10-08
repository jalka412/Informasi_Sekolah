@extends('layouts.main')
@section('title', 'Data Siswa Kelas ' . $kelas->nama_kelas)

@section('content')
    <section class="section custom-section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('kelas.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Siswa Kelas: {{ $kelas->nama_kelas }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('kelas.index') }}">Kelas</a></div>
                <div class="breadcrumb-item">Data Siswa</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Wali Kelas: {{ $kelas->guru?->nama ?? '-' }} | Jurusan: {{ $kelas->jurusan?->nama_jurusan ?? '-' }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-2">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Siswa</th>
                                            <th>NIS</th>
                                            <th>No. Telepon</th>
                                            <th>Alamat</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($kelas->siswa->sortBy('nama') as $siswa)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $siswa->nama }}</td>
                                                <td>{{ $siswa->nis }}</td>
                                                <td>{{ $siswa->telp }}</td>
                                                <td>{{ $siswa->alamat }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">Belum ada siswa di kelas ini.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
