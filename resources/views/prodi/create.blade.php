@extends('layout')

@section('content')
    <div class="container">
        <div class="row pt-4">
            <div class="col">
                <h2>Form Prodi</h2>
                @if (session()->has('info'))
                    <div class="alert alert-success">
                        {{ session()->get('info') }}
                    </div>
                @endif
                <form action="{{ url('prodi/store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">

                        <label for="nama" id="name" class="form-control">Nama</label>
                        <input type="text" name="name" id="name" class="form-control"
                            value="{{ old('nama') }}">
                        @error('name')
                            <div class="text-danger"> {{ $message }}</div>
                        @enderror
                        <label for="foto">Foto/Logo</label>
                        <input type="file" name="foto" id="foto" class="form-control">
                        @error('foto')
                            <div class="text-danger"> {{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary mt-2">Simpan</button>
                </form>
            </div>
        </div>
    </div>
@endsection
