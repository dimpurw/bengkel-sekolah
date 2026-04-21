<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\StockOut;
use Illuminate\Http\Request;

class StockOutController extends Controller
{
    public function index(Request $request)
    {
        $items = StockOut::orderBy('created_at', 'desc')
            ->get();
        $locations = Location::orderBy('created_at', 'desc')
            ->get();

        return view('item.stock_out', compact('items', 'locations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_registrasi' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'stok' => 'required|numeric',
            'batas_aman_stok' => 'required|numeric',
            'satuan' => 'required|string|max:50',
            'merek' => 'nullable|string|max:255',
            'vendor' => 'nullable|string|max:255',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'location_id' => 'required|exists:locations,id',
        ]);

        $gambarPath = $school->gambar ?? null;

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $gambarPath = 'barang_habis_pakai_folder/gambar_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move('barang_habis_pakai_folder', $gambarPath);
        }

        StockOut::create([
            'no_registrasi' => $request->no_registrasi,
            'name' => $request->name,
            'stok' => $request->stok,
            'batas_aman_stok' => $request->batas_aman_stok,
            'satuan' => $request->satuan,
            'merek' => $request->merek,
            'vendor' => $request->vendor,
            'gambar' => $gambarPath,
            'location_id' => $request->location_id,
        ]);

        return redirect()->route('stock.out.index')
            ->with('success', 'Data Barang (Kondisi Baik) berhasil dibuat');
    }

    public function update(Request $request, $id)
    {
        $goodItem = StockOut::findOrFail($id);

        $request->validate([
            'no_registrasi' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'stok' => 'required|numeric',
            'batas_aman_stok' => 'required|numeric',
            'satuan' => 'required|string|max:50',
            'merek' => 'nullable|string|max:255',
            'vendor' => 'nullable|string|max:255',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'location_id' => 'required|exists:locations,id',
        ]);

        // ── Upload gambar hero
        $gambarPath = $goodItem->gambar ?? null;

        if ($request->hasFile('gambar')) {
            if ($goodItem && $goodItem->gambar) {
                unlink($goodItem->gambar);
            }

            $file = $request->file('gambar');
            $gambarPath = 'barang_habis_pakai_folder/gambar_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move('barang_habis_pakai_folder', $gambarPath);
        }

        $data = [
            'no_registrasi' => $request->no_registrasi,
            'name' => $request->name,
            'stok' => $request->stok,
            'batas_aman_stok' => $request->batas_aman_stok,
            'satuan' => $request->satuan,
            'merek' => $request->merek,
            'vendor' => $request->vendor,
            'gambar' => $gambarPath,
            'location_id' => $request->location_id,
        ];

        $goodItem->update($data);

        return redirect()->route('stock.out.index')
            ->with('success', 'Data Barang (Kondisi Baik) berhasil diupdate');
    }

    public function destroy($id)
    {
        $goodItem = StockOut::findOrFail($id);

        if ($goodItem && $goodItem->gambar) {
            unlink($goodItem->gambar);
        }

        $goodItem->delete();

        return redirect()->route('stock.out.index')
            ->with('success', 'Data Barang (Kondisi Baik) berhasil dihapus');
    }
}
