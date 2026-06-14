@extends('admin.layouts.app')

@section('content')

<style>

.page-wrapper{
    max-width:1200px;
    margin:auto;
}

.detail-card{
    background:#fff;
    border-radius:30px;
    overflow:hidden;
    box-shadow:0 10px 30px rgba(0,0,0,.08);
}

.detail-header{
    padding:30px;
    border-bottom:1px solid #eee;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.detail-title{
    display:flex;
    align-items:center;
    gap:15px;
    font-size:30px;
    font-weight:700;
    color:#1A2238;
}

.detail-icon{
    width:55px;
    height:55px;
    background:#650018;
    color:white;
    border-radius:12px;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:22px;
}

.close-btn{
    text-decoration:none;
    font-size:30px;
    color:#444;
}

.content-body{
    padding:35px;
}

.info-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:30px;
    margin-bottom:40px;
}

.section-title{
    font-size:15px;
    letter-spacing:2px;
    text-transform:uppercase;
    color:#6A5200;
    margin-bottom:15px;
    font-weight:700;
}

.info-box{
    background:#F8F4EC;
    border:1px solid #E6DCC8;
    border-radius:24px;
    padding:25px;
}

.info-row{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:20px;
}

.info-label{
    font-size:13px;
    color:#777;
    margin-bottom:5px;
}

.info-value{
    font-size:28px;
    font-weight:700;
    color:#1A2238;
}

.info-small{
    font-size:18px;
    font-weight:600;
}

.status-badge{
    background:#F8E7A3;
    color:#7A5A00;
    padding:10px 18px;
    border-radius:999px;
    font-weight:700;
    display:inline-block;
}

.status-lunas{
    background:#D4EDDA;
    color:#155724;
}

.status-ditolak{
    background:#F8D7DA;
    color:#721C24;
}

.bukti-wrapper{
    background:#F8F4EC;
    border:1px solid #E6DCC8;
    border-radius:24px;
    padding:20px;
}

.preview-box{
    border:2px dashed #CFC3AF;
    border-radius:18px;
    text-align:center;
    padding:20px;
    background:#FCFAF5;
}

.preview-box img{
    max-width:100%;
    max-height:400px;
    object-fit:contain;
    border-radius:12px;
}

.file-box{
    margin-top:15px;
    background:white;
    border-radius:15px;
    padding:15px;
    display:flex;
    align-items:center;
    gap:15px;
}

.file-name{
    font-weight:700;
}

.footer-action{
    background:#F8F4EC;
    padding:30px;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.back-btn{
    background:#650018;
    color:white;
    border:none;
    padding:14px 30px;
    border-radius:999px;
    font-weight:700;
    text-decoration:none;
}

.btn-group{
    display:flex;
    gap:15px;
}

.reject-btn{
    background:#D81919;
    color:white;
    border:none;
    padding:14px 28px;
    border-radius:999px;
    cursor:pointer;
    font-weight:700;
}

.accept-btn{
    background:#167A2E;
    color:white;
    border:none;
    padding:14px 28px;
    border-radius:999px;
    cursor:pointer;
    font-weight:700;
}

.note-box{
    margin-top:25px;
    background:#FFF4F4;
    border-left:5px solid #D81919;
    padding:20px;
    border-radius:12px;
}

.modal{
    display:none;
    position:fixed;
    inset:0;
    background:rgba(0,0,0,.5);
    z-index:9999;
}

.modal-content{
    background:white;
    width:600px;
    max-width:95%;
    margin:120px auto;
    border-radius:20px;
    padding:30px;
}

.modal-content h3{
    margin-bottom:20px;
}

.modal-content textarea{
    width:100%;
    height:150px;
    border:1px solid #ddd;
    border-radius:12px;
    padding:15px;
    resize:none;
}

.modal-footer{
    display:flex;
    justify-content:flex-end;
    gap:10px;
    margin-top:20px;
}

.cancel-btn{
    border:none;
    background:#ddd;
    padding:12px 22px;
    border-radius:10px;
    cursor:pointer;
}

.submit-reject{
    border:none;
    background:#D81919;
    color:white;
    padding:12px 22px;
    border-radius:10px;
    cursor:pointer;
}

@media(max-width:900px){

    .info-grid{
        grid-template-columns:1fr;
    }

    .footer-action{
        flex-direction:column;
        gap:20px;
    }
}

</style>

<div class="page-wrapper">

    <div class="detail-card">

        <div class="detail-header">
            <div class="detail-title">
                <div class="detail-icon">
                    <i class="fas fa-money-check-alt"></i>
                </div>
                Detail Pembayaran SPP
            </div>
            <a href="{{ route('admin.pembayaran.index') }}" class="close-btn">
                ×
            </a>
        </div>

        <div class="content-body">

            @if(session('success'))
            <div style="margin-bottom:20px;padding:15px;border-radius:10px;background:#D4EDDA;color:#155724;">
                {{ session('success') }}
            </div>
            @endif

            <div class="info-grid">

                <div>
                    <div class="section-title">
                        Data Siswa
                    </div>

                    <div class="info-box">
                        <div class="info-label">
                            Nama Siswa
                        </div>
                        <div class="info-value">
                            {{ $tagihan->siswa->nama }}
                        </div>

                        <br>

                        <div class="info-row">
                            <div>
                                <div class="info-label">
                                    Kategori
                                </div>
                                <div class="info-small">
                                    {{ $tagihan->siswa->kategori_latihan }}
                                </div>
                            </div>

                            <div>
                                <div class="info-label">
                                    Nomor HP
                                </div>
                                <div class="info-small">
                                    {{ $tagihan->siswa->no_hp }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="section-title">
                        Data Tagihan
                    </div>

                    <div class="info-box">
                        <div class="info-row">
                            <div>
                                <div class="info-label">
                                    Periode
                                </div>
                                <div class="info-small">
                                    {{ $tagihan->bulan }} {{ $tagihan->tahun }}
                                </div>
                            </div>

                            <div>
                                @if($tagihan->status == 'Menunggu Verifikasi')
                                    <span class="status-badge">
                                        {{ $tagihan->status }}
                                    </span>
                                @elseif($tagihan->status == 'Lunas')
                                    <span class="status-badge status-lunas">
                                        {{ $tagihan->status }}
                                    </span>
                                @else
                                    <span class="status-badge status-ditolak">
                                        {{ $tagihan->status }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <br>

                        <div class="info-row">
                            <div>
                                <div class="info-label">
                                    Nominal
                                </div>
                                <div class="info-small">
                                    Rp {{ number_format($tagihan->nominal,0,',','.') }}
                                </div>
                            </div>

                            <div>
                                <div class="info-label">
                                    Tanggal Upload
                                </div>
                                <div class="info-small">
                                    {{ $tagihan->tanggal_bayar
                                        ? \Carbon\Carbon::parse($tagihan->tanggal_bayar)->format('d M Y')
                                        : '-' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($tagihan->status == 'Ditolak' && $tagihan->catatan_admin)
                    <div class="note-box">
                        <strong>Alasan Penolakan:</strong>
                        <br><br>
                        {{ $tagihan->catatan_admin }}
                    </div>
                    @endif
                </div>

            </div>

            <div class="section-title">
                Bukti Pembayaran
            </div>

            <div class="bukti-wrapper">
                <div class="preview-box">
                    @if($tagihan->bukti_pembayaran)
                        <img src="{{ asset('uploads/bukti_pembayaran/'.$tagihan->bukti_pembayaran) }}" alt="Bukti Pembayaran">
                    @else
                        <div style="padding:80px;color:#999;">
                            Bukti pembayaran tidak ditemukan
                        </div>
                    @endif
                </div>

                <div class="file-box">
                    <div>
                        <div class="file-name">
                            Bukti Transfer SPP
                        </div>
                        <small style="color:#777;">
                            {{ basename($tagihan->bukti_pembayaran) }}
                        </small>
                    </div>
                </div>
            </div>

        </div>

        <div class="footer-action">
            <a href="{{ route('admin.pembayaran.index') }}" class="back-btn">
                Kembali
            </a>

            @if($tagihan->status == 'Menunggu Verifikasi')
            <div class="btn-group">
                <button type="button" class="reject-btn" onclick="openRejectModal()">
                    Tolak Pembayaran
                </button>

                <form action="{{ route('admin.pembayaran.terima',$tagihan->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="accept-btn">
                        Terima Pembayaran
                    </button>
                </form>
            </div>
            @endif
        </div>

    </div>

</div>

<div class="modal" id="rejectModal">
    <div class="modal-content">
        <form method="POST" action="{{ route('admin.pembayaran.tolak',$tagihan->id) }}">
            @csrf
            <h3>Alasan Penolakan</h3>
            <textarea name="catatan_admin" required placeholder="Masukkan alasan penolakan..."></textarea>

            <div class="modal-footer">
                <button type="button" class="cancel-btn" onclick="closeRejectModal()">
                    Batal
                </button>
                <button type="submit" class="submit-reject">
                    Tolak Pembayaran
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openRejectModal(){
    document.getElementById('rejectModal').style.display='block';
}

function closeRejectModal(){
    document.getElementById('rejectModal').style.display='none';
}
</script>

@endsection