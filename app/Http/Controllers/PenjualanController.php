<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PenjualanController extends Controller
{
    public function index(Request $request)
    {
        $query = Penjualan::query();

        if ($request->filled('q')) {
            $keyword = $request->q;
            $query->where(function ($q) use ($keyword) {
                $q->where('kode_transaksi', 'like', "%{$keyword}%")
                  ->orWhere('nama_pelanggan', 'like', "%{$keyword}%")
                  ->orWhere('nama_produk', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $penjualan = $query
            ->orderByDesc('tanggal')
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        $totalOmzet = Penjualan::where('status', 'Selesai')->sum('total');

        $ringkasan = [
            'Selesai' => Penjualan::where('status', 'Selesai')->count(),
            'Pending' => Penjualan::where('status', 'Pending')->count(),
            'Batal'   => Penjualan::where('status', 'Batal')->count(),
        ];

        return view('penjualan.index', compact('penjualan', 'totalOmzet', 'ringkasan'));
    }

    public function create()
    {
        return view('penjualan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_transaksi' => ['required', 'string', 'max:30', 'unique:penjualan,kode_transaksi'],
            'tanggal' => ['required', 'date', 'before_or_equal:' . now()->addDays(7)->toDateString()],
            'nama_pelanggan' => ['required', 'string', 'max:100'],
            'nama_produk' => ['required', 'string', 'max:120'],
            'jumlah' => ['required', 'integer', 'min:1'],
            'harga_satuan' => ['required', 'numeric', 'min:0'],
            'status' => ['required', Rule::in(['Selesai', 'Pending', 'Batal'])],
            'catatan' => ['nullable', 'string', 'max:1000'],
        ], [
            'tanggal.before_or_equal' => 'Tanggal transaksi tidak boleh lebih dari 7 hari ke depan.',
        ]);

        $validated['total'] = $validated['jumlah'] * $validated['harga_satuan'];

        Penjualan::create($validated);

        return redirect()
            ->route('penjualan.index')
            ->with('success', 'Transaksi berhasil ditambahkan.');
    }

    public function show(Penjualan $penjualan)
    {
        return view('penjualan.show', compact('penjualan'));
    }

    public function edit(Penjualan $penjualan)
    {
        return view('penjualan.edit', compact('penjualan'));
    }

    public function update(Request $request, Penjualan $penjualan)
    {
        $validated = $request->validate([
            'kode_transaksi' => [
                'required', 'string', 'max:30',
                Rule::unique('penjualan', 'kode_transaksi')->ignore($penjualan->id),
            ],
            'tanggal' => ['required', 'date', 'before_or_equal:' . now()->addDays(7)->toDateString()],
            'nama_pelanggan' => ['required', 'string', 'max:100'],
            'nama_produk' => ['required', 'string', 'max:120'],
            'jumlah' => ['required', 'integer', 'min:1'],
            'harga_satuan' => ['required', 'numeric', 'min:0'],
            'status' => ['required', Rule::in(['Selesai', 'Pending', 'Batal'])],
            'catatan' => ['nullable', 'string', 'max:1000'],
        ], [
            'tanggal.before_or_equal' => 'Tanggal transaksi tidak boleh lebih dari 7 hari ke depan.',
        ]);

        $validated['total'] = $validated['jumlah'] * $validated['harga_satuan'];

        $penjualan->update($validated);

        return redirect()
            ->route('penjualan.index')
            ->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function destroy(Penjualan $penjualan)
    {
        $penjualan->delete();

        return redirect()
            ->route('penjualan.index')
            ->with('success', 'Transaksi berhasil dihapus.');
    }
}