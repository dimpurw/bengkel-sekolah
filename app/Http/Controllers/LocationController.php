<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index(Request $request)
    {
        $locations = Location::orderBy('name')->get();

        return view('location', compact('locations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Location::create([
            'name' => $request->name
        ]);

        return redirect()->route('location.index')
            ->with('success', 'Data Lokasi Penyimpanan berhasil dibuat');
    }

    public function update(Request $request, $id)
    {
        $location = Location::findOrFail($id);

        $request->validate([
            'name'  => 'required|string|max:255',
        ]);

        $data = [
            'name'  => $request->name,
        ];

        $location->update($data);

        return redirect()->route('location.index')
            ->with('success', 'Data Lokasi Penyimpanan berhasil diupdate');
    }

    public function destroy($id)
    {
        $location = Location::findOrFail($id);

        $location->delete();

        return redirect()->route('location.index')
            ->with('success', 'Data Lokasi Penyimpanan berhasil dihapus');
    }
}
