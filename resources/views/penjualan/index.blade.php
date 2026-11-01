@extends('layouts.app')

@section('title', 'Daftar Penjualan')

@section('content')
<div class="topbar">
    <div>
        <h1>Penjualan</h1>
        <p class="muted">Kelola transaksi penjualan sederhana.</p>
    </div>
    <a class="btn btn-primary" href="{{ route('penjualan.create') }}">+ Tambah Transaksi</a>
</div>

<div class="grid summary-grid" style="margin-bottom: 20px;">
    <div class="card" style="margin-bottom: 0;">
        <div class="muted">Total omzet (Selesai)</div>
        <div class="metric" style="font-size: 20px;">Rp {{ number_format((float) $totalOmzet, 0, ',', '.') }}</div>
    </div>
    <div class="card" style="margin-bottom: 0;">
        <div class="muted">Selesai</div>
        <div class="metric">{{ $ringkasan['Selesai'] }}</div>
    </div>
    <div class="card" style="margin-bottom: 0;">
        <div class="muted">Pending</div>
        <div class="metric">{{ $ringkasan['Pending'] }}</div>
    </div>
    <div class="card" style="margin-bottom: 0;">
        <div class="muted">Batal</div>
        <div class="metric">{{ $ringkasan['Batal'] }}</div>
    </div>
</div>

<div class="card">
    <form method="GET" action="{{ route('penjualan.index') }}" class="actions" style="align-items: end;">
        <div style="flex: 1; min-width: 200px;">
            <label for="q">Cari</label>
            <input id="q" name="q" value="{{ request('q') }}" placeholder="Kode, pelanggan, atau produk">
        </div>
        <div style="min-width: 160px;">
            <label for="filter_status">Status</label>
            <select id="filter_status" name="status">
                <option value="">Semua</option>
                @foreach (['Selesai', 'Pending', 'Batal'] as $s)
                    <option value="{{ $s }}" @selected(request('status') === $s)>{{ $s }}</option>
                @endforeach
            </select>
        </div>
        <button class="btn btn-primary" type="submit">Cari</button>
        <a class="btn" href="{{ route('penjualan.index') }}">Reset</a>
    </form>
</div>

<div class="card">
    <table>
        <thead>
            <tr>
                <th>Kode</th>
                <th>Tanggal</th>
                <th>Pelanggan</th>
                <th>Produk</th>
                <th>Total</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($penjualan as $item)
                <tr>
                    <td>{{ $item->kode_transaksi }}</td>
                    <td>{{ $item->tanggal->format('d/m/Y') }}</td>
                    <td>{{ $item->nama_pelanggan }}</td>
                    <td>{{ $item->nama_produk }}</td>
                    <td>Rp {{ number_format((float) $item->total, 0, ',', '.') }}</td>
                    <td><span class="badge badge-{{ strtolower($item->status) }}">{{ $item->status }}</span></td>
                    <td>
                        <div class="actions">
                            <a class="btn" href="{{ route('penjualan.show', $item) }}">Detail</a>
                            <a class="btn" href="{{ route('penjualan.edit', $item) }}">Edit</a>
                            <form
                                action="{{ route('penjualan.destroy', $item) }}"
                                method="POST"
                                onsubmit="return confirm('Hapus transaksi ini?')"
                            >
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" type="submit">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="muted">Belum ada transaksi.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 16px;">
        {{ $penjualan->links() }}
    </div>
</div>
@endsection