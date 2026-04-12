<?php

namespace App\Http\Controllers;

use App\Models\DamagedItem;
use App\Models\Location;
use Illuminate\Http\Request;

class DamagedItemController extends Controller
{
    public function index(Request $request)
    {
        $items = DamagedItem::orderBy('created_at', 'desc')
            ->get();
        $locations = Location::orderBy('created_at', 'desc')
            ->get();

        return view('item.damaged', compact('items', 'locations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_registrasi' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'stok' => 'required|numeric',
            'satuan' => 'required|string|max:50',
            'merek' => 'nullable|string|max:255',
            'vendor' => 'nullable|string|max:255',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'location_id' => 'required|exists:locations,id',
        ]);

        $gambarPath = $school->gambar ?? null;

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $gambarPath = 'barang_bagus_folder/gambar_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move('barang_bagus_folder', $gambarPath);
        }

        DamagedItem::create([
            'no_registrasi' => $request->no_registrasi,
            'name' => $request->name,
            'stok' => $request->stok,
            'satuan' => $request->satuan,
            'merek' => $request->merek,
            'vendor' => $request->vendor,
            'gambar' => $gambarPath,
            'location_id' => $request->location_id,
        ]);

        return redirect()->route('damaged.item.index')
            ->with('success', 'Data Barang Rusak/Arsip berhasil dibuat');
    }

    public function update(Request $request, $id)
    {
        $damagedItem = DamagedItem::findOrFail($id);

        $request->validate([
            'no_registrasi' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'stok' => 'required|numeric',
            'satuan' => 'required|string|max:50',
            'merek' => 'nullable|string|max:255',
            'vendor' => 'nullable|string|max:255',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'location_id' => 'required|exists:locations,id',
        ]);

        // ── Upload gambar hero
        $gambarPath = $damagedItem->gambar ?? null;

        if ($request->hasFile('gambar')) {
            if ($damagedItem && $damagedItem->gambar) {
                unlink($damagedItem->gambar);
            }

            $file = $request->file('gambar');
            $gambarPath = 'barang_bagus_folder/gambar_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move('barang_bagus_folder', $gambarPath);
        }

        $data = [
            'no_registrasi' => $request->no_registrasi,
            'name' => $request->name,
            'stok' => $request->stok,
            'satuan' => $request->satuan,
            'merek' => $request->merek,
            'vendor' => $request->vendor,
            'gambar' => $gambarPath,
            'location_id' => $request->location_id,
        ];

        $damagedItem->update($data);

        return redirect()->route('damaged.item.index')
            ->with('success', 'Data Barang Rusak/Arsip berhasil diupdate');
    }

    public function destroy($id)
    {
        $damagedItem = DamagedItem::findOrFail($id);

        if ($damagedItem && $damagedItem->gambar) {
            unlink($damagedItem->gambar);
        }

        $damagedItem->delete();

        return redirect()->route('damaged.item.index')
            ->with('success', 'Data Barang Rusak/Arsip berhasil dihapus');
    }
}
