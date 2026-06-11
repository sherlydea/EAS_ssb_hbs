@extends('admin.layouts.app')

@section('content')

<style>

.page-header h2{
    font-size:48px;
    font-weight:700;
    color:#1A2238;
    margin-bottom:5px;
}

.page-desc{
    color:#666;
    margin-bottom:35px;
}

.form-card{
    background:white;
    border-radius:28px;
    padding:40px;
    box-shadow:0 4px 12px rgba(0,0,0,.05);
}

.form-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:24px;
}

.form-group{
    display:flex;
    flex-direction:column;
}

.form-group label{
    font-size:15px;
    font-weight:600;
    color:#1A2238;
    margin-bottom:8px;
}

.form-control{
    height:54px;
    border:none;
    background:#F5F1E8;
    border-radius:16px;
    padding:0 18px;
    font-size:14px;
    outline:none;
    box-sizing: border-box;
}

/* Kustomisasi Dropdown Agar Panah Tidak Terlalu Mepet */
.form-select{
    appearance:none;
    -webkit-appearance:none;
    -moz-appearance:none;

    padding-right:50px;

    background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='%231A2238' viewBox='0 0 16 16'%3E%3Cpath d='M1.5 5.5l6 6 6-6' stroke='%231A2238' stroke-width='2' fill='none'/%3E%3C/svg%3E");

    background-repeat:no-repeat;
    background-position:right 18px center;
    cursor: pointer;
}

.action-buttons{
    margin-top:35px;
    display:flex;
    gap:15px;
}

.btn-submit{
    background:#650018;
    color:white;
    border:none;
    padding:14px 28px;
    border-radius:999px;
    font-weight:700;
    cursor:pointer;
    font-size:14px;
    transition: .2s;
}

.btn-submit:hover{
    background:#4d0012;
}

.btn-back{
    background:#999;
    color:white;
    text-decoration:none;
    padding:14px 28px;
    border-radius:999px;
    font-weight:700;
    font-size:14px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: .2s;
}

.btn-back:hover{
    background:#777;
}

.alert-danger{
    background:#ffe5e5;
    color:#c00;
    padding:15px;
    border-radius:12px;
    margin-bottom:20px;
}

@media(max-width:768px){
    .form-grid{
        grid-template-columns:1fr;
    }
    .btn-submit, .btn-back {
        width: 100%;
        text-align: center;
    }
}

</style>

<div class="page-header">
    <h2>Edit Pelatih</h2>
    <p class="page-desc">
        Perbarui data pelatih SSB HBS.
    </p>
</div>

@if ($errors->any())
    <div class="alert-danger">
        <ul style="margin:0;padding-left:20px;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="form-card">

    <form action="{{ route('admin.pelatih.update', $pelatih->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-grid">

            <div class="form-group">
                <label>Nama Pelatih</label>
                <input
                    type="text"
                    name="nama"
                    id="nama"
                    class="form-control"
                    value="{{ old('nama', $pelatih->nama) }}"
                    required>
            </div>

            <div class="form-group">
                <label>Lisensi</label>
                <select name="lisensi" class="form-control form-select" required>
                    <option value="">Pilih Lisensi</option>
                    <option value="Nasional B" {{ old('lisensi', $pelatih->lisensi) == 'Nasional B' ? 'selected' : '' }}>
                        Nasional B
                    </option>
                    <option value="Nasional C" {{ old('lisensi', $pelatih->lisensi) == 'Nasional C' ? 'selected' : '' }}>
                        Nasional C
                    </option>
                    <option value="Nasional D" {{ old('lisensi', $pelatih->lisensi) == 'Nasional D' ? 'selected' : '' }}>
                        Nasional D
                    </option>
                </select>
            </div>

            <div class="form-group">
                <label>No HP</label>
                <input
                    type="text"
                    name="no_hp"
                    id="no_hp"
                    class="form-control"
                    value="{{ old('no_hp', $pelatih->no_hp) }}"
                    required>
            </div>

        </div>

        <div class="action-buttons">
            <button type="submit" class="btn-submit">
                Update Pelatih
            </button>

            <a href="{{ route('admin.pelatih.index') }}" class="btn-back">
                Kembali
            </a>
        </div>

    </form>

</div>

<script>
document.querySelector('form').addEventListener('submit', function(e){

    let nama = document.getElementById('nama').value.trim();
    let hp   = document.getElementById('no_hp').value.trim();

    if(nama === ''){
        alert('Nama pelatih wajib diisi');
        e.preventDefault();
        return;
    }

    if(!/^[0-9]+$/.test(hp)){
        alert('No HP harus angka');
        e.preventDefault();
        return;
    }

    if(hp.length < 10){
        alert('No HP minimal 10 digit');
        e.preventDefault();
        return;
    }

});
</script>

@endsection