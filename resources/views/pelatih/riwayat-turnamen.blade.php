@extends('pelatih.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="font-weight-bold text-dark">Riwayat Siswa Terdaftar Turnamen</h2>
        <a href="{{ route('pelatih.turnamen.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left mr-1"></i> Kembali ke Turnamen
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead class="thead-light">
                        <tr>
                            <th>No</th>
                            <th>Turnamen</th>
                            <th>Nama Siswa</th>
                            <th>Kategori</th>
                            <th>Tanggal Daftar</th>
                            <th>Status Pembayaran</th>
                            <th>Status Turnamen</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($riwayat as $index => $row)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $row->nama_turnamen }}</td>
                            <td>{{ $row->nama_siswa }}</td>
                            <td>{{ $row->kategori_latihan }}</td>
                            <td>{{ \Carbon\Carbon::parse($row->created_at)->format('d M Y') }}</td>
                            <td>
                                @if($row->status_pembayaran == 'Lunas')
                                    <span class="badge badge-success">Lunas</span>
                                @elseif($row->status_pembayaran == 'Menunggu Konfirmasi')
                                    <span class="badge badge-warning">Menunggu</span>
                                @else
                                    <span class="badge badge-secondary">Belum Bayar</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge {{ $row->status_turnamen == 'Aktif' ? 'badge-primary' : 'badge-info' }}">
                                    {{ $row->status_turnamen }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('pelatih.turnamen.peserta.show', $row->id) }}" 
                                       class="btn btn-sm btn-info" title="View">
                                       <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('pelatih.turnamen.peserta.edit', $row->id) }}" 
                                       class="btn btn-sm btn-warning" title="Edit">
                                       <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('pelatih.turnamen.hapusPeserta', [$row->turnamen_id, $row->siswa_id]) }}" 
                                          method="POST" 
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus peserta ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">Belum ada data riwayat peserta turnamen.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .table td { vertical-align: middle; }
    .badge { padding: 0.5em 0.75em; }
    .btn-group form { display: inline-block; margin-left: 5px; }
</style>
@endsection