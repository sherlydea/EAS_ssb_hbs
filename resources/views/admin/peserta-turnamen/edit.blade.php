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
    padding:35px;
    box-shadow:0 4px 12px rgba(0,0,0,.05);
}

.form-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:25px;
}

.form-group{
    display:flex;
    flex-direction:column;
}

.form-group label{
    font-size:14px;
    font-weight:600;
    margin-bottom:8px;
    color:#1A2238;
}

.form-input{
    height:54px;
    border:none;
    background:#F5F1E8;
    border-radius:14px;
    padding:0 18px;
    font-size:14px;
    outline:none;
    box-sizing: border-box;
}

/* Kustomisasi Tampilan Dropdown Select Arrow */
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

.form-actions{
    margin-top:35px;
    display:flex;
    gap:15px;
}

.btn-save{
    background:#650018;
    color:white;
    text-decoration:none;
    border:none;
    padding:14px 30px;
    border-radius:999px;
    font-weight:700;
    cursor:pointer;
    font-size:14px;
    transition: .2s;
}

.btn-save:hover{
    background:#7d0020;
}

.btn-back{
    background:#999;
    color:white;
    text-decoration:none;
    padding:14px 30px;
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
    .btn-save, .btn-back {
        width: 100%;
        text-align: center;
    }
}
</style>

<div class="page-header">
    <h2>Edit Peserta Turnamen</h2>
    <p class="page-desc">
        Perbarui data pendaftaran, pemilihan turnamen, maupun beban biaya peserta SSB HBS.
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

    <form action="{{ route('admin.peserta-turnamen.update', $peserta->id) }}" method="POST" id="editPesertaForm">
        @csrf
        @method('PUT')

        <div class="form-grid">

            <div class="form-group">
                <label for="siswa_id">Nama Siswa</label>
                <select name="siswa_id" id="siswa_id" class="form-input form-select" required>
                    <option value="">Pilih Siswa</option>
                    @foreach($siswas as $siswa)
                        <option value="{{ $siswa->id }}" {{ old('siswa_id', $peserta->siswa_id) == $siswa->id ? 'selected' : '' }}>
                            {{ $siswa->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="turnamen_id">Turnamen Mandat</label>
                <select name="turnamen_id" id="turnamen_id" class="form-input form-select" required>
                    <option value="">Pilih Turnamen</option>
                    @foreach($turnamens as $turnamen)
                        <option value="{{ $turnamen->id }}" {{ old('turnamen_id', $peserta->turnamen_id) == $turnamen->id ? 'selected' : '' }}>
                            {{ $turnamen->nama_turnamen }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="biaya">Biaya Pendaftaran (Rp)</label>
                <input 
                    type="number" 
                    name="biaya" 
                    id="biaya" 
                    class="form-input" 
                    value="{{ old('biaya', $peserta->biaya) }}" 
                    placeholder="Contoh: 150000"
                    min="0"
                    required>
            </div>

        </div>

        <div class="form-actions">
            <button type="submit" class="btn-save">
                Update Peserta
            </button>

            <a href="{{ route('admin.peserta-turnamen.index') }}" class="btn-back">
                Kembali
            </a>
        </div>

    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('editPesertaForm');
    
    if (form) {
        form.addEventListener('submit', function (e) {
            let siswa = document.getElementById('siswa_id').value;
            let turnamen = document.getElementById('turnamen_id').value;
            let biaya = document.getElementById('biaya').value.trim();

            if (siswa === '') {
                alert('Silakan pilih siswa terlebih dahulu.');
                e.preventDefault();
                return;
            }

            if (turnamen === '') {
                alert('Silakan pilih turnamen destinasi.');
                e.preventDefault();
                return;
            }

            if (biaya === '' || isNaN(biaya) || parseFloat(biaya) < 0) {
                alert('Nilai isian beban biaya turnamen tidak valid!');
                e.preventDefault();
                return;
            }
        });
    }
});
</script>

@endsection