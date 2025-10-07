@extends('layouts.main')
@section('title', 'Edit User')

@section('content')
<section class="section custom-section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-8 col-lg-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4>Edit User</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('user.update', $user->id) }}" method="POST">
                            @csrf
                            @method('PUT') {{-- Method untuk update --}}

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="form-group">
                                <label for="name">Nama User</label>
                                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $user->name) }}">
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $user->email) }}">
                            </div>

                            <div class="form-group">
                                <label for="roles">Role</label>
                                <select id="roles" name="roles" class="form-control">
                                    <option value="admin" {{ $user->roles == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="guru" {{ $user->roles == 'guru' ? 'selected' : '' }}>Guru</option>
                                    <option value="siswa" {{ $user->roles == 'siswa' ? 'selected' : '' }}>Siswa</option>
                                    <option value="orangtua" {{ $user->roles == 'orangtua' ? 'selected' : '' }}>Orang Tua</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="password">Password Baru</label>
                                <input type="password" id="password" name="password" class="form-control">
                                <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah password.</small>
                            </div>

                            <div class="card-footer text-right">
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                <a href="{{ route('user.index') }}" class="btn btn-secondary">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection