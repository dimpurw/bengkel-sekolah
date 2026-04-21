<?php

namespace App\Http\Controllers;

use App\Models\MaterialRequest;
use App\Models\StockOut;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaterialRequestController extends Controller
{
    public function index()
    {
        $barangs = StockOut::where('stok', '>', 0)
            ->orderBy('name')
            ->get();

        $pengajuans = MaterialRequest::with('stockOut')
            ->where('user_id', Auth::id())
            ->whereIn('status', ['menunggu', 'ditolak'])
            ->latest()
            ->get();

        return view('material_request', compact('barangs', 'pengajuans'));
    }

    // ── TAMBAH KE KERANJANG (session) ──────────────────────────────────
    public function tambahKeranjang(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:good_items,id',
            'jumlah'    => 'required|integer|min:1',
            'catatan'   => 'nullable|string|max:255',
        ]);

        $barang = StockOut::findOrFail($request->barang_id);

        if ($request->jumlah > $barang->stok) {
            return back()->with('error', 'Jumlah melebihi stok tersedia.');
        }

        $keranjang = session('keranjang', []);

        $exists = false;
        foreach ($keranjang as &$item) {
            if ($item['barang_id'] == $request->barang_id) {
                $item['jumlah']  = $request->jumlah;
                $item['catatan'] = $request->catatan;
                $exists = true;
                break;
            }
        }
        unset($item);

        if (!$exists) {
            $keranjang[] = [
                'barang_id' => $barang->id,
                'nama'      => $barang->name,
                'jumlah'    => $request->jumlah,
                'catatan'   => $request->catatan,
            ];
        }

        session(['keranjang' => $keranjang]);

        return back()->with('success', "{$barang->nama} ditambahkan ke keranjang.");
    }

    public function hapusKeranjang($barangId)
    {
        $keranjang = session('keranjang', []);
        $keranjang = array_values(
            array_filter($keranjang, fn($item) => $item['barang_id'] != $barangId)
        );
        session(['keranjang' => $keranjang]);

        return back()->with('success', 'Barang dihapus dari keranjang.');
    }

    public function ajukan()
    {
        $keranjang = session('keranjang', []);

        if (empty($keranjang)) {
            return back()->with('error', 'Keranjang kosong.');
        }

        foreach ($keranjang as $item) {
            $barang = StockOut::find($item['barang_id']);
            if (!$barang || $barang->stok < $item['jumlah']) continue;

            MaterialRequest::create([
                'user_id'      => Auth::id(),
                'stock_out_id' => $item['barang_id'],
                'jumlah'       => $item['jumlah'],
                'catatan'      => $item['catatan'],
                'status'       => 'menunggu',
            ]);
        }

        // Kosongkan keranjang setelah ajukan
        session()->forget('keranjang');

        return back()->with('success', 'Pengajuan peminjaman berhasil dikirim.');
    }

    public function update(Request $request, $id)
    {
        $peminjaman = MaterialRequest::where('user_id', Auth::id())
            ->where('status', 'menunggu')
            ->findOrFail($id);

        $request->validate([
            'jumlah'  => 'required|integer|min:1',
            'catatan' => 'nullable|string|max:255',
        ]);

        $peminjaman->update([
            'jumlah'  => $request->jumlah,
            'catatan' => $request->catatan,
        ]);

        return back()->with('success', 'Pengajuan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $peminjaman = MaterialRequest::where('user_id', Auth::id())
            ->whereIn('status', ['menunggu', 'ditolak'])
            ->findOrFail($id);

        $peminjaman->delete();

        return back()->with('success', 'Pengajuan berhasil dibatalkan.');
    }
}
