@extends('admin.layouts.app')

@section('content')

<style>

.form-card{
    background:white;
    padding:30px;
    border-radius:20px;
    max-width:800px;
    box-shadow:0 4px 12px rgba(0,0,0,.05);
}

.form-group{
    margin-bottom:20px;
}

.form-group label{
    display:block;
    margin-bottom:8px;
    font-weight:600;
}

.form-control{
    width:100%;
    padding:12px;
    border:1px solid #ddd;
    border-radius:10px;
}

.btn-save{
    background:#650018;
    color:white;
    border:none;
    padding:12px 24px;
    border-radius:10px;
    cursor:pointer;
    font-weight:600;
}

</style>

<h1 style="margin-bottom:25px;">
    Edit Data Siswa
</h1>

<div class="form-card">

<form action="{{ route('admin.siswas.update', $siswa->id) }}"
      method="POST">

    @csrf
    @method('PUT')

    <div class="form-group">
        <label>Nama Siswa</label>
        <input type="text"
               name="nama"
               class="form-control"
               value="{{ old('nama', $siswa->nama) }}">
    </div>

    <div class="form-group">
        <label>Kategori Latihan</label>

        <select name="kategori_latihan"
                class="form-control">

            <option value="U-10"
            {{ $siswa->kategori_latihan=='U-10' ? 'selected' : '' }}>
                U-10
            </option>

            <option value="U-13"
            {{ $siswa->kategori_latihan=='U-13' ? 'selected' : '' }}>
                U-13
            </option>

            <option value="U-15"
            {{ $siswa->kategori_latihan=='U-15' ? 'selected' : '' }}>
                U-15
            </option>

            <option value="U-18"
            {{ $siswa->kategori_latihan=='U-18' ? 'selected' : '' }}>
                U-18
            </option>

        </select>
    </div>

    <div class="form-group">
        <label>Nomor HP</label>
        <input type="text"
               name="no_hp"
               class="form-control"
               value="{{ old('no_hp', $siswa->no_hp) }}">
    </div>

    <div class="form-group">
        <label>Nama Orang Tua</label>
        <input type="text"
               name="nama_orang_tua"
               class="form-control"
               value="{{ old('nama_orang_tua', $siswa->nama_orang_tua) }}">
    </div>

    <div class="form-group">
        <label>Alamat</label>

        <textarea
            name="alamat"
            rows="4"
            class="form-control">{{ old('alamat', $siswa->alamat) }}</textarea>
    </div>

    <button type="submit" class="btn-save">
        Simpan Perubahan
    </button>

</form>

</div>

@endsection