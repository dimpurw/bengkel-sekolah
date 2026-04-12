@extends('layouts.main')

@section('title', 'Barang Rusak/Arsip')

@section('content')

{{-- ── CARD WRAPPER ── --}}
<div class="data-table-wrap">

    {{-- Header --}}
    <div style="padding:16px 20px;border-bottom:1px solid #e2e8f0;">

        {{-- Baris atas: judul + tombol aksi --}}
        <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px;margin-bottom:14px;">
            <span style="font-size:0.92rem;font-weight:800;color:#0f172a;">
                Data Barang Rusak/Arsip
            </span>
            <div style="display:flex;gap:8px;flex-wrap:wrap;">
                <a href="#" target="_blank" class="btn-top btn-cetak">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                        <polyline points="6 9 6 2 18 2 18 9" />
                        <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2" />
                        <rect x="6" y="14" width="12" height="8" />
                    </svg>
                    Cetak Semua
                </a>
                <a href="#" class="btn-top btn-import">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                        <polyline points="17 8 12 3 7 8" />
                        <line x1="12" y1="3" x2="12" y2="15" />
                    </svg>
                    Import
                </a>
                <button class="btn-top btn-tambah" onclick="openModal('modalTambah')">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                        <line x1="12" y1="5" x2="12" y2="19" />
                        <line x1="5" y1="12" x2="19" y2="12" />
                    </svg>
                    Tambah
                </button>
            </div>
        </div>

        {{-- Baris filter --}}
        <form method="GET" action="{{ route('damaged.item.index') }}" id="filterForm">
            <div style="display:flex;gap:10px;flex-wrap:wrap;align-items:flex-end;">

                {{-- Search --}}
                <div style="flex:1;min-width:180px;position:relative;">
                    <span style="position:absolute;left:10px;top:50%;transform:translateY(-50%);color:#94a3b8;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <circle cx="11" cy="11" r="8" />
                            <line x1="21" y1="21" x2="16.65" y2="16.65" />
                        </svg>
                    </span>
                    <input type="text" name="search" class="field-input"
                        style="padding-left:32px;"
                        placeholder="Cari nama / NIS / username..."
                        value="{{ request('search') }}"
                        oninput="debounceSubmit()" />
                </div>

                {{-- Filter Lokasi --}}
                <div style="min-width:160px;">
                    <select name="location_id" class="field-input" onchange="this.form.submit()">
                        <option value="">Semua Lokasi</option>
                        @foreach($locations as $location)
                        <option value="{{ $location->id }}" {{ request('location_id') == $location->id ? 'selected' : '' }}>
                            {{ $location->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                {{-- Per halaman --}}
                <div style="min-width:120px;">
                    <select name="per_page" class="field-input" onchange="this.form.submit()">
                        @foreach([12, 24, 48] as $n)
                        <option value="{{ $n }}" {{ request('per_page', 12) == $n ? 'selected' : '' }}>
                            {{ $n }} per hal
                        </option>
                        @endforeach
                    </select>
                </div>

                {{-- Reset --}}
                @if(request()->hasAny(['search','location_id']) && request()->anyFilled(['search','location_id']))
                <a href="{{ route('damaged.item.index') }}" class="btn-reset">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <line x1="18" y1="6" x2="6" y2="18" />
                        <line x1="6" y1="6" x2="18" y2="18" />
                    </svg>
                    Reset
                </a>
                @endif
            </div>
        </form>
    </div>{{-- /header --}}

    {{-- ── CARD GRID ── --}}
    <div style="padding:20px;">
        @if($items->isEmpty())
        <div style="text-align:center;padding:48px;color:#94a3b8;">
            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                style="margin:0 auto 12px;display:block;opacity:.4;">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                <circle cx="12" cy="7" r="4" />
            </svg>
            <p style="font-size:0.88rem;font-weight:600;">Tidak ada data barang Rusak/Arsip ditemukan.</p>
        </div>
        @else
        <div class="siswa-grid">
            @foreach($items as $item)
            <div class="siswa-card">
                <div class="siswa-foto">
                    @if($item->gambar)
                    <img src="{{ asset($item->gambar) }}" alt="{{ $item->name }}" />
                    @else
                    <div class="siswa-foto-placeholder">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#ffffffaa" stroke-width="1.2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                            <circle cx="12" cy="7" r="4" />
                        </svg>
                    </div>
                    @endif
                </div>
                <div class="siswa-info">
                    <div class="siswa-nama">{{ $item->name }}</div>
                    <div class="siswa-no">No: {{ $item->no_registrasi ?? '-' }}</div>
                    <div class="siswa-stok">
                        <span class="badge bg-success">
                            Stok: {{ $item->stok ?? '-' }}
                        </span>
                    </div>
                    <div class="siswa-merek">Merek: {{ $item->merek ?? '-' }}</div>
                </div>
                <div class="siswa-aksi">
                    <button class="btn-detail" onclick="openDetail({{ $item->id }})">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                            <circle cx="12" cy="12" r="3" />
                        </svg>
                        Detail
                    </button>
                    <a href="#" target="_blank" class="btn-icon-gray" title="Cetak Kartu">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                            <polyline points="6 9 6 2 18 2 18 9" />
                            <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2" />
                            <rect x="6" y="14" width="12" height="8" />
                        </svg>
                    </a>
                    <button class="btn-icon-blue" title="Edit"
                        onclick="openEdit(
                            {{ $item->id }},
                            '{{ $item->no_registrasi }}',
                            '{{ $item->name }}',
                            '{{ $item->stok }}',
                            '{{ $item->satuan }}',
                            '{{ $item->merek }}',
                            '{{ $item->vendor }}',
                            '{{ $item->gambar }}',
                            '{{ $item->location_id }}',
                        )">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                            <path d="M12 20h9" />
                            <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z" />
                        </svg>
                    </button>
                    <button class="btn-icon-red" title="Hapus"
                        onclick="openHapus({{ $item->id }}, '{{ addslashes($item->nama) }}')">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                            <polyline points="3 6 5 6 21 6" />
                            <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6" />
                            <path d="M10 11v6M14 11v6" />
                            <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2" />
                        </svg>
                    </button>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>


{{-- ══════════════════ MODAL TAMBAH ══════════════════ --}}
<div class="modal-overlay" id="modalTambah">
    <div class="modal-box">
        <div class="modal-head">
            <span>Tambah Barang Rusak/Arsip</span>
            <button class="modal-close" onclick="closeModal('modalTambah')">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <line x1="18" y1="6" x2="6" y2="18" />
                    <line x1="6" y1="6" x2="18" y2="18" />
                </svg>
            </button>
        </div>
        <form method="POST" action="{{ route('damaged.item.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="modal-grid">
                    <div class="field-group field-full">
                        <label class="field-label">No Registrasi <span class="req">*</span></label>
                        <input type="text" class="field-input" name="no_registrasi"
                            value="{{ old('no_registrasi') }}" placeholder="No Registrasi" required />
                        @error('no_registrasi')<span class="err-msg">{{ $message }}</span>@enderror
                    </div>
                    <div class="field-group">
                        <label class="field-label">Nama Barang/Peralatan <span class="req">*</span></label>
                        <input type="text" class="field-input" name="name"
                            value="{{ old('name') }}" placeholder="Nama Barang/Peralatan" required />
                        @error('name')<span class="err-msg">{{ $message }}</span>@enderror
                    </div>
                    <div class="field-group">
                        <label class="field-label">Jumlah Stok <span class="req">*</span></label>
                        <input type="number" class="field-input" name="stok"
                            value="{{ old('stok') }}" placeholder="Jumlah Stok" required />
                        @error('stok')<span class="err-msg">{{ $message }}</span>@enderror
                    </div>
                    <div class="field-group">
                        <label class="field-label">Satuan <span class="req">*</span></label>
                        <input type="text" class="field-input" name="satuan"
                            value="{{ old('satuan') }}" placeholder="Satuan" required />
                        @error('satuan')<span class="err-msg">{{ $message }}</span>@enderror
                    </div>
                    <div class="field-group">
                        <label class="field-label">Merek <span class="req">*</span></label>
                        <input type="text" class="field-input" name="merek"
                            value="{{ old('merek') }}" placeholder="Merek" required />
                        @error('merek')<span class="err-msg">{{ $message }}</span>@enderror
                    </div>
                    <div class="field-group">
                        <label class="field-label">Vendor/Distributor <span class="req">*</span></label>
                        <input type="text" class="field-input" name="vendor"
                            value="{{ old('vendor') }}" placeholder="Vendor/Distributor" required />
                        @error('vendor')<span class="err-msg">{{ $message }}</span>@enderror
                    </div>
                    <div class="field-group">
                        <label class="field-label">Lokasi <span class="req">*</span></label>
                        <select class="field-input" name="location_id" required>
                            <option value="">-- Pilih Lokasi --</option>
                            @foreach($locations as $location)
                            <option value="{{ $location->id }}" {{ old('location_id') == $location->id ? 'selected' : '' }}>
                                {{ $location->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('location_id')<span class="err-msg">{{ $message }}</span>@enderror
                    </div>

                    {{-- ── UPLOAD GAMBAR ── --}}
                    <div class="field-group field-full">
                        <label class="field-label">Gambar</label>

                        <div class="upload-zone" id="uploadZoneTambah"
                            onclick="document.getElementById('inputFotoTambah').click()"
                            ondragover="onDragOver(event,'uploadZoneTambah')"
                            ondragleave="onDragLeave('uploadZoneTambah')"
                            ondrop="onDrop(event,'inputFotoTambah','uploadZoneTambah','previewWrapTambah','previewImgTambah','previewNameTambah','placeholderTambah','errFotoTambah')">

                            {{-- Placeholder --}}
                            <div class="upload-placeholder" id="placeholderTambah">
                                <div class="upload-icon">
                                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                        <rect x="3" y="3" width="18" height="18" rx="3" />
                                        <circle cx="8.5" cy="8.5" r="1.5" />
                                        <polyline points="21 15 16 10 5 21" />
                                    </svg>
                                </div>
                                <p class="upload-txt">Klik atau seret foto ke sini</p>
                                <p class="upload-hint">JPG, PNG, WEBP — maks 2MB</p>
                            </div>

                            {{-- Preview --}}
                            <div class="upload-preview" id="previewWrapTambah" style="display:none;">
                                <img id="previewImgTambah" src="" alt="Preview" />
                                <div class="upload-preview-info">
                                    <span id="previewNameTambah" class="upload-fname"></span>
                                    <button type="button" class="upload-remove"
                                        onclick="removePhoto(event,'inputFotoTambah','previewWrapTambah','placeholderTambah','uploadZoneTambah')">
                                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                            <line x1="18" y1="6" x2="6" y2="18" />
                                            <line x1="6" y1="6" x2="18" y2="18" />
                                        </svg>
                                        Hapus Gambar
                                    </button>
                                </div>
                            </div>
                        </div>

                        <input type="file" id="inputFotoTambah" name="gambar"
                            accept="image/jpeg,image/png,image/webp" style="display:none;"
                            onchange="onFileChange(this,'uploadZoneTambah','previewWrapTambah','previewImgTambah','previewNameTambah','placeholderTambah','errFotoTambah')" />
                        <span class="err-msg" id="errFotoTambah"></span>
                        @error('gambar')<span class="err-msg">{{ $message }}</span>@enderror
                    </div>

                </div>
            </div>
            <div class="modal-foot">
                <button type="button" class="btn-batal" onclick="closeModal('modalTambah')">Batal</button>
                <button type="submit" class="btn-simpan">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
                        <polyline points="17 21 17 13 7 13 7 21" />
                        <polyline points="7 3 7 8 15 8" />
                    </svg>
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ══════════════════ MODAL EDIT ══════════════════ --}}
<div class="modal-overlay" id="modalEdit">
    <div class="modal-box">
        <div class="modal-head">
            <span>Edit Siswa</span>
            <button class="modal-close" onclick="closeModal('modalEdit')">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <line x1="18" y1="6" x2="6" y2="18" />
                    <line x1="6" y1="6" x2="18" y2="18" />
                </svg>
            </button>
        </div>
        <form method="POST" id="formEdit" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <div class="modal-grid">
                    <div class="field-group field-full">
                        <label class="field-label">No Registrasi <span class="req">*</span></label>
                        <input type="text" class="field-input" name="no_registrasi" id="edit_no_registrasi" required />
                        @error('no_registrasi')<span class="err-msg">{{ $message }}</span>@enderror
                    </div>
                    <div class="field-group">
                        <label class="field-label">Nama Barang/Peralatan <span class="req">*</span></label>
                        <input type="text" class="field-input" name="name" id="edit_name" required />
                        @error('name')<span class="err-msg">{{ $message }}</span>@enderror
                    </div>
                    <div class="field-group">
                        <label class="field-label">Jumlah Stok <span class="req">*</span></label>
                        <input type="number" class="field-input" name="stok" id="edit_stok" required />
                        @error('stok')<span class="err-msg">{{ $message }}</span>@enderror
                    </div>
                    <div class="field-group">
                        <label class="field-label">Satuan <span class="req">*</span></label>
                        <input type="text" class="field-input" name="satuan" id="edit_satuan" required />
                        @error('satuan')<span class="err-msg">{{ $message }}</span>@enderror
                    </div>
                    <div class="field-group">
                        <label class="field-label">Merek <span class="req">*</span></label>
                        <input type="text" class="field-input" name="merek" id="edit_merek" required />
                        @error('merek')<span class="err-msg">{{ $message }}</span>@enderror
                    </div>
                    <div class="field-group">
                        <label class="field-label">Vendor/Distributor <span class="req">*</span></label>
                        <input type="text" class="field-input" name="vendor" id="edit_vendor" required />
                        @error('vendor')<span class="err-msg">{{ $message }}</span>@enderror
                    </div>
                    <div class="field-group">
                        <label class="field-label">Lokasi <span class="req">*</span></label>
                        <select class="field-input" name="location_id" id="edit_location_id" required>
                            <option value="">-- Pilih Lokasi --</option>
                            @foreach($locations as $location)
                            <option value="{{ $location->id }}" {{ old('location_id') == $location->id ? 'selected' : '' }}>
                                {{ $location->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('location_id')<span class="err-msg">{{ $message }}</span>@enderror
                    </div>

                    {{-- ── UPLOAD FOTO ── --}}
                    <div class="field-group field-full">
                        <label class="field-label">Gambar</label>

                        <div class="upload-zone" id="uploadZoneEdit"
                            onclick="document.getElementById('inputFotoEdit').click()"
                            ondragover="onDragOver(event,'uploadZoneEdit')"
                            ondragleave="onDragLeave('uploadZoneEdit')"
                            ondrop="onDrop(event,'inputFotoEdit','uploadZoneEdit','previewWrapEdit','previewImgEdit','previewNameEdit','placeholderEdit','errFotoEdit')">

                            <!-- Placeholder -->
                            <div class="upload-placeholder" id="placeholderEdit">
                                <div class="upload-icon">
                                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                        <rect x="3" y="3" width="18" height="18" rx="3" />
                                        <circle cx="8.5" cy="8.5" r="1.5" />
                                        <polyline points="21 15 16 10 5 21" />
                                    </svg>
                                </div>
                                <p class="upload-txt">Klik atau seret foto ke sini</p>
                                <p class="upload-hint">JPG, PNG, WEBP — maks 2MB</p>
                            </div>

                            <!-- Preview -->
                            <div class="upload-preview" id="previewWrapEdit" style="display:none;">
                                <img id="previewImgEdit" src="" alt="Preview" />
                                <div class="upload-preview-info">
                                    <span id="previewNameEdit" class="upload-fname"></span>
                                    <button type="button" class="upload-remove"
                                        onclick="removePhoto(event,'inputFotoEdit','previewWrapEdit','placeholderEdit','uploadZoneEdit')">
                                        Hapus foto
                                    </button>
                                </div>
                            </div>
                        </div>

                        <input type="file" id="inputFotoEdit" name="gambar"
                            accept="image/jpeg,image/png,image/webp" style="display:none;"
                            onchange="onFileChange(this,'uploadZoneEdit','previewWrapEdit','previewImgEdit','previewNameEdit','placeholderEdit','errFotoEdit')" />

                        <span class="err-msg" id="errFotoEdit"></span>
                    </div>

                </div>
            </div>
            <div class="modal-foot">
                <button type="button" class="btn-batal" onclick="closeModal('modalEdit')">Batal</button>
                <button type="submit" class="btn-simpan">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
                        <polyline points="17 21 17 13 7 13 7 21" />
                        <polyline points="7 3 7 8 15 8" />
                    </svg>
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ══════════════════ MODAL DETAIL ══════════════════ --}}
<div class="modal-overlay" id="modalDetail">
    <div class="modal-box">
        <div class="modal-head">
            <span>Detail Siswa</span>
            <button class="modal-close" onclick="closeModal('modalDetail')">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <line x1="18" y1="6" x2="6" y2="18" />
                    <line x1="6" y1="6" x2="18" y2="18" />
                </svg>
            </button>
        </div>
        <div class="modal-body" id="detailContent">
            <div style="text-align:center;padding:24px;color:#94a3b8;font-size:0.85rem;">Memuat...</div>
        </div>
        <div class="modal-foot">
            <button type="button" class="btn-batal" onclick="closeModal('modalDetail')">Tutup</button>
        </div>
    </div>
</div>


{{-- ══════════════════ MODAL HAPUS ══════════════════ --}}
<div class="modal-overlay" id="modalHapus">
    <div class="modal-box modal-box-sm">
        <div class="modal-head">
            <span>Hapus Barang Kondisi Rusak/Arsip</span>
            <button class="modal-close" onclick="closeModal('modalHapus')">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <line x1="18" y1="6" x2="6" y2="18" />
                    <line x1="6" y1="6" x2="18" y2="18" />
                </svg>
            </button>
        </div>
        <div class="modal-body" style="text-align:center;padding:28px 24px 20px;">
            <div style="width:52px;height:52px;background:#fee2e2;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2.2">
                    <polyline points="3 6 5 6 21 6" />
                    <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6" />
                    <path d="M10 11v6M14 11v6" />
                    <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2" />
                </svg>
            </div>
            <p style="font-size:0.95rem;font-weight:700;color:#0f172a;margin-bottom:6px;">Yakin ingin menghapus?</p>
            <p style="font-size:0.85rem;color:#64748b;">Siswa <strong id="hapusNama"></strong> akan dihapus permanen.</p>
        </div>
        <form method="POST" id="formHapus" action="">
            @csrf @method('DELETE')
            <div class="modal-foot" style="justify-content:center;gap:10px;">
                <button type="button" class="btn-batal" onclick="closeModal('modalHapus')">Batal</button>
                <button type="submit" class="btn-hapus-confirm">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                        <polyline points="3 6 5 6 21 6" />
                        <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6" />
                    </svg>
                    Ya, Hapus
                </button>
            </div>
        </form>
    </div>
</div>

@endsection


@push('styles')
<style>
    .btn-top {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 8px 16px;
        border-radius: 8px;
        border: none;
        font-size: 0.82rem;
        font-weight: 700;
        font-family: var(--font);
        cursor: pointer;
        text-decoration: none;
        transition: filter 0.15s, transform 0.1s;
    }

    .btn-top:hover {
        filter: brightness(0.93);
        transform: translateY(-1px);
    }

    .btn-cetak {
        background: #fff;
        color: #374151;
        border: 1.5px solid #e2e8f0;
    }

    .btn-import {
        background: #f97316;
        color: #fff;
    }

    .btn-tambah {
        background: #2563eb;
        color: #fff;
    }

    .btn-reset {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 8px 12px;
        border-radius: 8px;
        background: #fee2e2;
        color: #991b1b;
        border: none;
        font-size: 0.8rem;
        font-weight: 700;
        font-family: var(--font);
        cursor: pointer;
        text-decoration: none;
    }

    .btn-reset:hover {
        filter: brightness(0.93);
    }

    /* Upload zone */
    .upload-zone {
        border: 2px dashed #cbd5e1;
        border-radius: 10px;
        padding: 20px 16px;
        cursor: pointer;
        transition: border-color 0.2s, background 0.2s;
        background: #fafbff;
        user-select: none;
    }

    .upload-zone:hover {
        border-color: #2563eb;
        background: #eff6ff;
    }

    .upload-zone.drag-over {
        border-color: #2563eb;
        background: #dbeafe;
    }

    .upload-placeholder {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 6px;
    }

    .upload-icon {
        width: 52px;
        height: 52px;
        border-radius: 12px;
        background: #e0e7ff;
        color: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 4px;
    }

    .upload-txt {
        font-size: 0.85rem;
        font-weight: 700;
        color: #374151;
    }

    .upload-hint {
        font-size: 0.75rem;
        color: #94a3b8;
    }

    .upload-preview {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .upload-preview img {
        width: 72px;
        height: 72px;
        border-radius: 10px;
        object-fit: cover;
        border: 2px solid #e2e8f0;
        flex-shrink: 0;
    }

    .upload-preview-info {
        display: flex;
        flex-direction: column;
        gap: 6px;
        min-width: 0;
    }

    .upload-fname {
        font-size: 0.8rem;
        font-weight: 600;
        color: #374151;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 200px;
    }

    .upload-remove {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: #fee2e2;
        color: #991b1b;
        border: none;
        border-radius: 6px;
        padding: 4px 10px;
        font-size: 0.75rem;
        font-weight: 700;
        font-family: var(--font);
        cursor: pointer;
    }

    .upload-remove:hover {
        filter: brightness(0.93);
    }

    /* Card grid */
    .siswa-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 16px;
    }

    .siswa-card {
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        overflow: hidden;
        background: #fff;
        transition: box-shadow 0.2s, transform 0.15s;
    }

    .siswa-card:hover {
        box-shadow: 0 6px 24px #00000012;
        transform: translateY(-2px);
    }

    .siswa-foto {
        width: 100%;
        height: 200px;
        overflow: hidden;
        background: #e2e8f0;
    }

    .siswa-foto img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .siswa-foto-placeholder {
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #1a6b4a, #2d8f63);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .siswa-foto-placeholder svg {
        width: 80px;
        height: 80px;
    }

    .siswa-info {
        padding: 12px 14px 8px;
    }

    .siswa-nama {
        font-size: 0.92rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 4px;
    }

    .siswa-meta {
        font-size: 0.78rem;
        color: #64748b;
        line-height: 1.7;
    }

    .siswa-aksi {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 10px 14px;
        border-top: 1px solid #f1f5f9;
    }

    .btn-detail {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 7px 10px;
        border-radius: 7px;
        background: none;
        border: 1.5px solid #e2e8f0;
        font-size: 0.78rem;
        font-weight: 700;
        color: #374151;
        font-family: var(--font);
        cursor: pointer;
        transition: background 0.15s;
    }

    .btn-detail:hover {
        background: #f8fafc;
    }

    .btn-icon-gray,
    .btn-icon-red,
    .btn-icon-blue {
        width: 32px;
        height: 32px;
        border-radius: 7px;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: filter 0.15s;
        text-decoration: none;
        flex-shrink: 0;
    }

    .btn-icon-gray {
        background: #f1f5f9;
        color: #64748b;
    }

    .btn-icon-gray:hover {
        filter: brightness(0.92);
    }

    .btn-icon-blue {
        background: #448eef;
        color: #fff;
    }

    .btn-icon-blue:hover {
        filter: brightness(1.1);
    }

    .btn-icon-red {
        background: #ef4444;
        color: #fff;
    }

    .btn-icon-red:hover {
        filter: brightness(1.1);
    }

    /* Upload zone */
    .upload-zone {
        border: 2px dashed #cbd5e1;
        border-radius: 10px;
        padding: 20px 16px;
        cursor: pointer;
        transition: border-color 0.2s, background 0.2s;
        background: #fafbff;
        user-select: none;
    }

    .upload-zone:hover {
        border-color: #2563eb;
        background: #eff6ff;
    }

    .upload-zone.drag-over {
        border-color: #2563eb;
        background: #dbeafe;
    }

    .upload-placeholder {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 6px;
    }

    .upload-icon {
        width: 52px;
        height: 52px;
        border-radius: 12px;
        background: #e0e7ff;
        color: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 4px;
    }

    .upload-txt {
        font-size: 0.85rem;
        font-weight: 700;
        color: #374151;
    }

    .upload-hint {
        font-size: 0.75rem;
        color: #94a3b8;
    }

    .upload-preview {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .upload-preview img {
        width: 72px;
        height: 72px;
        border-radius: 10px;
        object-fit: cover;
        border: 2px solid #e2e8f0;
        flex-shrink: 0;
    }

    .upload-preview-info {
        display: flex;
        flex-direction: column;
        gap: 6px;
        min-width: 0;
    }

    .upload-fname {
        font-size: 0.8rem;
        font-weight: 600;
        color: #374151;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 200px;
    }

    .upload-remove {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: #fee2e2;
        color: #991b1b;
        border: none;
        border-radius: 6px;
        padding: 4px 10px;
        font-size: 0.75rem;
        font-weight: 700;
        font-family: var(--font);
        cursor: pointer;
    }

    .upload-remove:hover {
        filter: brightness(0.93);
    }

    /* Modal */
    .modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        z-index: 200;
        background: #00000055;
        backdrop-filter: blur(2px);
        align-items: center;
        justify-content: center;
        padding: 16px;
    }

    .modal-overlay.active {
        display: flex;
        animation: fadeIn 0.2s ease;
    }

    @keyframes fadeIn {
        from {
            opacity: 0
        }

        to {
            opacity: 1
        }
    }

    .modal-box {
        background: #fff;
        border-radius: 16px;
        width: 100%;
        max-width: 520px;
        box-shadow: 0 20px 60px #00000030;
        animation: slideUp 0.25s cubic-bezier(0.22, 1, 0.36, 1);
        overflow: hidden;
        max-height: 90vh;
        display: flex;
        flex-direction: column;
    }

    .modal-box-sm {
        max-width: 400px;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(24px)
        }

        to {
            opacity: 1;
            transform: translateY(0)
        }
    }

    .modal-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px 20px;
        border-bottom: 1px solid #e2e8f0;
        font-size: 0.95rem;
        font-weight: 800;
        color: #0f172a;
        flex-shrink: 0;
    }

    .modal-close {
        width: 30px;
        height: 30px;
        border-radius: 7px;
        background: none;
        border: none;
        cursor: pointer;
        color: #64748b;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background 0.15s;
    }

    .modal-close:hover {
        background: #f1f5f9;
        color: #0f172a;
    }

    .modal-body {
        padding: 20px;
        overflow-y: auto;
        flex: 1;
    }

    .modal-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px 16px;
    }

    .modal-foot {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 10px;
        padding: 14px 20px;
        border-top: 1px solid #e2e8f0;
        background: #fafbff;
        flex-shrink: 0;
    }

    .btn-batal {
        padding: 9px 18px;
        border-radius: 8px;
        background: none;
        border: 1.5px solid #e2e8f0;
        font-size: 0.85rem;
        font-weight: 700;
        color: #64748b;
        font-family: var(--font);
        cursor: pointer;
    }

    .btn-batal:hover {
        background: #f1f5f9;
    }

    .btn-hapus-confirm {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 9px 20px;
        border-radius: 8px;
        background: #ef4444;
        color: #fff;
        border: none;
        font-size: 0.85rem;
        font-weight: 700;
        font-family: var(--font);
        cursor: pointer;
    }

    .btn-hapus-confirm:hover {
        filter: brightness(1.1);
    }

    /* Detail */
    .detail-foto {
        width: 90px;
        height: 90px;
        border-radius: 12px;
        object-fit: cover;
        border: 2px solid #e2e8f0;
        margin: 0 auto 16px;
        display: block;
    }

    .detail-row {
        display: flex;
        gap: 8px;
        padding: 9px 0;
        border-bottom: 1px solid #f1f5f9;
        font-size: 0.85rem;
    }

    .detail-row:last-child {
        border-bottom: none;
    }

    .detail-key {
        width: 130px;
        flex-shrink: 0;
        color: #64748b;
        font-weight: 600;
    }

    .detail-val {
        color: #0f172a;
        font-weight: 500;
    }

    .err-msg {
        color: #ef4444;
        font-size: 0.75rem;
        margin-top: 2px;
        display: block;
    }

    .req {
        color: #ef4444;
    }

    @media(max-width:600px) {
        .siswa-grid {
            grid-template-columns: 1fr 1fr
        }

        .modal-grid {
            grid-template-columns: 1fr
        }
    }

    @media(max-width:400px) {
        .siswa-grid {
            grid-template-columns: 1fr
        }
    }
</style>
@endpush


@push('scripts')
<script>
    /* Modal helpers */
    function openModal(id) {
        document.getElementById(id).classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    // Edit Modal
    function openEdit(id, no_registrasi, name, stok,
        satuan, merek, vendor, gambar, location_id) {

        document.getElementById('edit_no_registrasi').value = no_registrasi;
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_stok').value = stok;
        document.getElementById('edit_satuan').value = satuan;
        document.getElementById('edit_merek').value = merek;
        document.getElementById('edit_vendor').value = vendor;

        // set Lokasi
        document.getElementById('edit_location_id').value = location_id;

        // set action form
        document.getElementById('formEdit').action = `/barang-kondisi-rusak/${id}`;

        // handle preview foto (pakai sistem upload kamu)
        let previewWrap = document.getElementById('previewWrapEdit');
        let previewImg = document.getElementById('previewImgEdit');
        let previewName = document.getElementById('previewNameEdit');
        let placeholder = document.getElementById('placeholderEdit');

        if (gambar) {
            previewImg.src = `/${gambar}`;
            previewName.innerText = 'Gambar saat ini';
            previewWrap.style.display = 'flex';
            placeholder.style.display = 'none';
        } else {
            previewWrap.style.display = 'none';
            placeholder.style.display = 'block';
        }

        openModal('modalEdit');
    }

    function closeModal(id) {
        document.getElementById(id).classList.remove('active');
        document.body.style.overflow = '';
    }
    document.querySelectorAll('.modal-overlay').forEach(o => {
        o.addEventListener('click', e => {
            if (e.target === o) closeModal(o.id);
        });
    });
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') document.querySelectorAll('.modal-overlay.active').forEach(m => closeModal(m.id));
    });

    /* ── Upload helpers ── */
    const MAX_MB = 2 * 1024 * 1024;

    function onFileChange(input, zoneId, wrapId, imgId, nameId, placeholderId, errId) {
        const file = input.files[0];
        const errEl = document.getElementById(errId);
        errEl.textContent = '';
        if (!file) return;
        if (!file.type.match(/^image\/(jpeg|png|webp)$/)) {
            errEl.textContent = 'File harus berupa gambar (JPG, PNG, WEBP).';
            input.value = '';
            return;
        }
        if (file.size > MAX_MB) {
            errEl.textContent = 'Ukuran file maksimal 2MB.';
            input.value = '';
            return;
        }
        const reader = new FileReader();
        reader.onload = ev => {
            document.getElementById(imgId).src = ev.target.result;
            document.getElementById(nameId).textContent = file.name;
            document.getElementById(wrapId).style.display = 'flex';
            document.getElementById(placeholderId).style.display = 'none';
            document.getElementById(zoneId).classList.remove('drag-over');
        };
        reader.readAsDataURL(file);
    }

    function removePhoto(event, inputId, wrapId, placeholderId, zoneId) {
        event.stopPropagation();
        document.getElementById(inputId).value = '';
        document.getElementById(wrapId).style.display = 'none';
        document.getElementById(placeholderId).style.display = 'flex';
    }

    function onDragOver(event, zoneId) {
        event.preventDefault();
        document.getElementById(zoneId).classList.add('drag-over');
    }

    function onDragLeave(zoneId) {
        document.getElementById(zoneId).classList.remove('drag-over');
    }

    function onDrop(event, inputId, zoneId, wrapId, imgId, nameId, placeholderId, errId) {
        event.preventDefault();
        const file = event.dataTransfer.files[0];
        if (!file) return;
        const input = document.getElementById(inputId);
        const dt = new DataTransfer();
        dt.items.add(file);
        input.files = dt.files;
        onFileChange(input, zoneId, wrapId, imgId, nameId, placeholderId, errId);
    }

    /* Hapus */
    function openHapus(id, nama) {
        document.getElementById('hapusNama').textContent = nama;
        document.getElementById('formHapus').action = `/barang-kondisi-rusak/${id}`;
        openModal('modalHapus');
    }

    /* Detail */
    function openDetail(id) {
        openModal('modalDetail');
        document.getElementById('detailContent').innerHTML = '<div style="text-align:center;padding:32px;color:#94a3b8;font-size:0.85rem;">Memuat...</div>';
        fetch(`/barang-kondisi-rusak/${id}/detail`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(r => r.json())
            .then(d => {
                const s = d.siswa;
                const foto = s.foto ? `<img src="/${s.foto}" class="detail-foto" alt="${s.name}" onerror="this.style.display='none'"/>` : '';
                document.getElementById('detailContent').innerHTML = `
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-2">
                            <div class="text-muted small">Nama</div>
                            <div class="fw-semibold">${s.name}</div>
                        </div>
                        <div class="mb-2">
                            <div class="text-muted small">NIS</div>
                            <div>${s.identity_number}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-2">
                            <div class="text-muted small">Lokasi</div>
                            <div>${s.class_room ?? '-'}</div>
                        </div>
                        <div class="mb-2">
                            <div class="text-muted small">Username</div>
                            <div>${s.username ?? '-'}</div>
                        </div>
                    </div>
                </div>
            `;
            })
            .catch(() => {
                document.getElementById('detailContent').innerHTML = '<div style="color:#ef4444;text-align:center;padding:24px;font-size:0.85rem;">Gagal memuat data.</div>';
            });
    }

    /* Debounce search */
    let debounceTimer;

    function debounceSubmit() {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => document.getElementById('filterForm').submit(), 500);
    }
</script>
@endpush