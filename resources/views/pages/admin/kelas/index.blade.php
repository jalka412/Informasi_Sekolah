@extends('layouts.main')
@section('title', 'List Kelas')

@section('content')
    <section class="section custom-section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h4>List Kelas</h4>
                            <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"><i class="nav-icon fas fa-folder-plus"></i>&nbsp; Tambah Data Kelas</button>
                        </div>
                        <div class="card-body">
                            @include('partials.alert')
                            <div id="accordion">
                                @foreach ($jurusan as $j)
                                <div class="accordion">
                                    <div class="accordion-header" role="button" data-toggle="collapse" data-target="#panel-body-{{ $j->id }}" aria-expanded="true">
                                        <h4>Jurusan: {{ $j->nama_jurusan }} ({{ $j->kelas->count() }} kelas)</h4>
                                    </div>
                                    <div class="accordion-body collapse show" id="panel-body-{{ $j->id }}" data-parent="#accordion">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-md">
                                                <thead>
                                                    <tr>
                                                        <th>Nama Kelas</th>
                                                        <th>Wali Kelas</th>
                                                        <th>Jumlah Siswa</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($j->kelas->sortBy('nama_kelas') as $kelas)
                                                        <tr>
                                                            <td>{{ $kelas->nama_kelas }}</td>
                                                            <td>{{ $kelas->guru?->nama ?? '-' }}</td>
                                                            <td>{{ $kelas->siswa->count() }} siswa</td>
                                                            <td>
                                                                <div class="d-flex">
                                                                    <a href="{{ route('kelas.show', $kelas->id) }}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i> &nbsp; Lihat Siswa</a>
                                                                    <a href="{{ route('kelas.edit', $kelas->id) }}" class="btn btn-success btn-sm ml-2"><i class="fas fa-edit"></i> &nbsp; Edit</a>
                                                                    <form method="POST" action="{{ route('kelas.destroy', $kelas->id) }}">
                                                                        @csrf
                                                                        @method('delete')
                                                                        <button class="btn btn-danger btn-sm show_confirm ml-2" data-toggle="tooltip" title='Delete'><i class="fas fa-trash-alt"></i> &nbsp; Hapus</button>
                                                                    </form>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="4" class="text-center">Belum ada kelas untuk jurusan ini.</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                
                {{-- MODAL UNTUK TAMBAH DATA KELAS --}}
                <div class="modal fade" tabindex="-1" role="dialog" id="exampleModal">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Tambah Data Kelas</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('kelas.store') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            @if ($errors->any())
                                                <div class="alert alert-danger alert-dismissible show fade">
                                                    <div class="alert-body">
                                                        <button class="close" data-dismiss="alert">
                                                            <span>&times;</span>
                                                        </button>
                                                        @foreach ($errors->all() as $error )
                                                            {{ $error }}
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif

                                            <div class="form-group">
                                                <label for="nama_kelas">Nama Kelas</label>
                                                <input type="text" id="nama_kelas" name="nama_kelas" class="form-control @error('nama_kelas') is-invalid @enderror" placeholder="Contoh: X TSM 1" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="jurusan_id">Jurusan</label>
                                                <select id="jurusan_id" name="jurusan_id" class="form-control" required>
                                                    <option value="">-- Pilih Jurusan --</option>
                                                    @foreach ($jurusan as $j)
                                                        <option value="{{ $j->id }}">{{ $j->nama_jurusan }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            {{-- ## BAGIAN YANG DIUBAH ## --}}
                                            <div class="form-group">
                                                <label for="guru_id_select">Wali Kelas</label>
                                                <select id="guru_id_select" name="guru_id" class="form-control @error('guru_id') is-invalid @enderror" required>
                                                    <option value="">-- Pilih Wali Kelas --</option>
                                                    
                                                    {{-- Loop hanya guru yang tersedia (dari controller) --}}
                                                    @foreach ($availableGurus as $guru)
                                                        <option value="{{ $guru->id }}">{{ $guru->nama }}</option>
                                                    @endforeach

                                                    <option value="" disabled>─ ─ ─ ─ ─ ─ ─ ─ ─</option>
                                                    {{-- Opsi pintas untuk menambah guru baru --}}
                                                    <option value="add_new_guru" class="text-primary font-weight-bold">
                                                        + Tambah Guru Baru
                                                    </option>
                                                </select>
                                            </div>
                                            {{-- ## BATAS BAGIAN YANG DIUBAH ## --}}

                                        </div>
                                    </div>
                                    <div class="modal-footer bg-whitesmoke br">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')
    <script type="text/javascript">
        $('.show_confirm').click(function(event) {
            var form =  $(this).closest("form");
            var name = $(this).data("name");
            event.preventDefault();
            swal({
                title: `Yakin ingin menghapus data ini?`,
                text: "Data akan terhapus secara permanen!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    form.submit();
                }
            });
        });
    </script>

    {{-- ## SCRIPT BARU UNTUK PINTASAN ## --}}
    <script>
        $(document).ready(function() {
            $('#guru_id_select').change(function() {
                if ($(this).val() === 'add_new_guru') {
                    // Arahkan ke halaman tambah guru
                     window.location.href = "{{ route('guru.index') }}?action=add";
                }
            });
        });
    </script>
@endpush