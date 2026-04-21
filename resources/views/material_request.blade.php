@extends('layouts.main')

@section('title', 'Ajukan Peminjaman')

@section('content')

<div class="pinjam-layout">

    {{-- ── KIRI: Daftar Barang + Pengajuan Menunggu ── --}}
    <div class="pinjam-left">

        {{-- Daftar Barang Tersedia --}}
        <div class="data-table-wrap" style="margin-bottom:16px;">
            <div style="padding:16px 20px;border-bottom:1px solid #e2e8f0;">
                <span style="font-size:0.92rem;font-weight:800;color:#0f172a;">Daftar Barang Tersedia</span>
            </div>
            <div style="padding:8px 0;">
                @forelse($barangs as $barang)
                <div class="barang-row">
                    <div class="barang-info">
                        <div class="barang-nama">{{ $barang->name }}</div>
                        <div class="barang-meta">
                            Stok: {{ $barang->stok }} Unit
                            @if($barang->merek) | Merek: {{ $barang->merek }} @endif
                        </div>
                    </div>
                    <button class="btn-keranjang"
                        onclick="openTambah({{ $barang->id }}, '{{ addslashes($barang->name) }}', {{ $barang->stok }})"
                        {{ $barang->stok < 1 ? 'disabled' : '' }}>
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <line x1="12" y1="5" x2="12" y2="19" />
                            <line x1="5" y1="12" x2="19" y2="12" />
                        </svg>
                        Keranjang
                    </button>
                </div>
                @empty
                <div style="padding:32px;text-align:center;color:#94a3b8;font-size:0.87rem;">
                    Tidak ada barang tersedia.
                </div>
                @endforelse
            </div>
        </div>

        {{-- Pengajuan Menunggu/Ditolak --}}
        @if($pengajuans->isNotEmpty())
        <div class="data-table-wrap">
            <div style="padding:14px 20px;border-bottom:1px solid #e2e8f0;display:flex;align-items:center;gap:8px;">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#92400e" stroke-width="2">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                    <polyline points="14 2 14 8 20 8" />
                </svg>
                <span style="font-size:0.88rem;font-weight:800;color:#92400e;">Pengajuan Menunggu/Ditolak</span>
            </div>
            <div style="padding:8px 0;">
                @foreach($pengajuans as $pj)
                <div class="barang-row">
                    <div class="barang-info">
                        <div class="barang-nama">{{ $pj->stockOut->name ?? '-' }}</div>
                        <div class="barang-meta">
                            Jumlah: {{ $pj->jumlah }} | Status:
                            <span class="badge-status badge-{{ $pj->status }}">{{ $pj->status }}</span>
                        </div>
                        @if($pj->catatan_admin)
                        <div style="font-size:0.75rem;color:#ef4444;margin-top:3px;">
                            Catatan: {{ $pj->catatan_admin }}
                        </div>
                        @endif
                    </div>
                    <div style="display:flex;gap:6px;">
                        {{-- Edit (hanya jika menunggu) --}}
                        @if($pj->status === 'menunggu')
                        <button class="btn-sm btn-edit"
                            onclick="openEdit({{ $pj->id }}, '{{ addslashes($pj->barang->nama ?? '') }}', {{ $pj->jumlah }}, '{{ addslashes($pj->catatan ?? '') }}', {{ $pj->stockOut->stok ?? 0 }})">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                            </svg>
                        </button>
                        @endif
                        {{-- Hapus --}}
                        <button class="btn-sm btn-hapus"
                            onclick="openHapus({{ $pj->id }}, '{{ addslashes($pj->barang->nama ?? '') }}')">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <polyline points="3 6 5 6 21 6" />
                                <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6" />
                            </svg>
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

    </div>{{-- /pinjam-left --}}

    {{-- ── KANAN: Keranjang ── --}}
    <div class="pinjam-right">
        <div class="keranjang-box">
            <div class="keranjang-head">Keranjang</div>

            <div id="keranjangList">
                @if(session('keranjang') && count(session('keranjang')) > 0)
                @foreach(session('keranjang') as $item)
                <div class="keranjang-item" id="ki-{{ $item['barang_id'] }}">
                    <div class="ki-info">
                        <div class="ki-nama">{{ $item['nama'] }}</div>
                        <div class="ki-qty">Qty: {{ $item['jumlah'] }}</div>
                    </div>
                    <form method="POST" action="{{ route('peminjaman.praktik.keranjang.hapus', $item['barang_id']) }}" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" class="ki-hapus" title="Hapus dari keranjang">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                <line x1="18" y1="6" x2="6" y2="18" />
                                <line x1="6" y1="6" x2="18" y2="18" />
                            </svg>
                        </button>
                    </form>
                </div>
                @endforeach
                @else
                <div class="keranjang-kosong" id="keranjangKosong">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="opacity:.3;margin-bottom:8px;">
                        <circle cx="9" cy="21" r="1" />
                        <circle cx="20" cy="21" r="1" />
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6" />
                    </svg>
                    <span>Keranjang kosong</span>
                </div>
                @endif
            </div>

            @if(session('keranjang') && count(session('keranjang')) > 0)
            <form method="POST" action="{{ route('peminjaman.praktik.ajukan') }}" style="margin-top:12px;">
                @csrf
                <button type="submit" class="btn-ajukan">Ajukan Peminjaman</button>
            </form>
            @else
            <button class="btn-ajukan" disabled style="margin-top:12px;opacity:.5;cursor:not-allowed;">
                Ajukan Peminjaman
            </button>
            @endif
        </div>
    </div>

</div>{{-- /pinjam-layout --}}


{{-- ══════════════════ MODAL TAMBAH KE KERANJANG ══════════════════ --}}
<div class="modal-overlay" id="modalTambah">
    <div class="modal-box">
        <div class="modal-head">
            <span id="modalTambahTitle">Tambah ke Keranjang</span>
            <button class="modal-close" onclick="closeModal('modalTambah')">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <line x1="18" y1="6" x2="6" y2="18" />
                    <line x1="6" y1="6" x2="18" y2="18" />
                </svg>
            </button>
        </div>
        <form method="POST" action="{{ route('peminjaman.praktik.keranjang.tambah') }}" id="formTambah">
            @csrf
            <input type="hidden" name="barang_id" id="tambahBarangId" />
            <div class="modal-body">
                <div class="field-group" style="margin-bottom:16px;">
                    <label class="field-label" id="labelJumlah">Jumlah <span class="req">*</span></label>
                    <input type="number" class="field-input" name="jumlah"
                        id="inputJumlah" min="1" value="1" required />
                </div>
                <div class="field-group">
                    <label class="field-label">Catatan (Opsional)</label>
                    <textarea class="field-input" name="catatan" rows="3"
                        placeholder="Keperluan peminjaman..."
                        style="resize:vertical;"></textarea>
                </div>
            </div>
            <div class="modal-foot">
                <button type="button" class="btn-batal" onclick="closeModal('modalTambah')">Batal</button>
                <button type="submit" class="btn-tambah-submit">Tambah</button>
            </div>
        </form>
    </div>
</div>


{{-- ══════════════════ MODAL EDIT PENGAJUAN ══════════════════ --}}
<div class="modal-overlay" id="modalEdit">
    <div class="modal-box">
        <div class="modal-head">
            <span id="modalEditTitle">Edit Pengajuan</span>
            <button class="modal-close" onclick="closeModal('modalEdit')">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <line x1="18" y1="6" x2="6" y2="18" />
                    <line x1="6" y1="6" x2="18" y2="18" />
                </svg>
            </button>
        </div>
        <form method="POST" id="formEdit" action="">
            @csrf @method('PUT')
            <div class="modal-body">
                <div class="field-group" style="margin-bottom:16px;">
                    <label class="field-label" id="labelJumlahEdit">Jumlah <span class="req">*</span></label>
                    <input type="number" class="field-input" name="jumlah"
                        id="editJumlah" min="1" value="1" required />
                </div>
                <div class="field-group">
                    <label class="field-label">Catatan (Opsional)</label>
                    <textarea class="field-input" name="catatan" id="editCatatan" rows="3"
                        style="resize:vertical;"></textarea>
                </div>
            </div>
            <div class="modal-foot">
                <button type="button" class="btn-batal" onclick="closeModal('modalEdit')">Batal</button>
                <button type="submit" class="btn-tambah-submit">Simpan</button>
            </div>
        </form>
    </div>
</div>


{{-- ══════════════════ MODAL HAPUS ══════════════════ --}}
<div class="modal-overlay" id="modalHapus">
    <div class="modal-box modal-box-sm">
        <div class="modal-head">
            <span>Batalkan Pengajuan</span>
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
            <p style="font-size:0.95rem;font-weight:700;color:#0f172a;margin-bottom:6px;">Batalkan pengajuan?</p>
            <p style="font-size:0.85rem;color:#64748b;">Pengajuan <strong id="hapusNama"></strong> akan dibatalkan.</p>
        </div>
        <form method="POST" id="formHapus" action="">
            @csrf @method('DELETE')
            <div class="modal-foot" style="justify-content:center;gap:10px;">
                <button type="button" class="btn-batal" onclick="closeModal('modalHapus')">Batal</button>
                <button type="submit" class="btn-hapus-confirm">Ya, Batalkan</button>
            </div>
        </form>
    </div>
</div>

@endsection


@push('styles')
<style>
    /* Layout 2 kolom */
    .pinjam-layout {
        display: grid;
        grid-template-columns: 1fr 300px;
        gap: 16px;
        align-items: flex-start;
    }

    .pinjam-left {
        min-width: 0;
    }

    .pinjam-right {
        position: sticky;
        top: 16px;
    }

    /* Barang row */
    .barang-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 13px 20px;
        border-bottom: 1px solid #f1f5f9;
        gap: 12px;
        transition: background 0.12s;
    }

    .barang-row:last-child {
        border-bottom: none;
    }

    .barang-row:hover {
        background: #f8fafc;
    }

    .barang-info {
        min-width: 0;
    }

    .barang-nama {
        font-size: 0.88rem;
        font-weight: 700;
        color: #0f172a;
    }

    .barang-meta {
        font-size: 0.77rem;
        color: #64748b;
        margin-top: 2px;
    }

    .btn-keranjang {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        flex-shrink: 0;
        padding: 7px 14px;
        border-radius: 7px;
        border: none;
        background: #10b981;
        color: #fff;
        font-size: 0.8rem;
        font-weight: 700;
        font-family: var(--font);
        cursor: pointer;
        transition: filter 0.15s;
        white-space: nowrap;
    }

    .btn-keranjang:hover {
        filter: brightness(1.08);
    }

    .btn-keranjang:disabled {
        background: #cbd5e1;
        cursor: not-allowed;
        filter: none;
    }

    /* Badge status */
    .badge-status {
        border-radius: 5px;
        padding: 2px 8px;
        font-size: 0.72rem;
        font-weight: 700;
    }

    .badge-menunggu {
        background: #fef3c7;
        color: #92400e;
    }

    .badge-disetujui {
        background: #d1fae5;
        color: #065f46;
    }

    .badge-ditolak {
        background: #fee2e2;
        color: #991b1b;
    }

    .badge-selesai {
        background: #dbeafe;
        color: #1e40af;
    }

    /* Btn sm edit/hapus di baris pengajuan */
    .btn-sm {
        width: 30px;
        height: 30px;
        border-radius: 6px;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: filter 0.15s;
        flex-shrink: 0;
    }

    .btn-edit {
        background: #fef3c7;
        color: #92400e;
    }

    .btn-edit:hover {
        filter: brightness(0.93);
    }

    .btn-hapus {
        background: #fee2e2;
        color: #991b1b;
    }

    .btn-hapus:hover {
        filter: brightness(0.93);
    }

    /* Keranjang box */
    .keranjang-box {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        overflow: hidden;
    }

    .keranjang-head {
        padding: 14px 18px;
        font-size: 0.9rem;
        font-weight: 800;
        color: #0f172a;
        border-bottom: 1px solid #e2e8f0;
        background: #f8fafc;
    }

    #keranjangList {
        padding: 8px 0;
        min-height: 60px;
    }

    .keranjang-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 14px;
        gap: 10px;
        background: #f0f9ff;
        border: 1px solid #bae6fd;
        border-radius: 8px;
        margin: 6px 10px;
    }

    .ki-info {
        min-width: 0;
    }

    .ki-nama {
        font-size: 0.83rem;
        font-weight: 700;
        color: #0f172a;
    }

    .ki-qty {
        font-size: 0.75rem;
        color: #64748b;
        margin-top: 2px;
    }

    .ki-hapus {
        width: 24px;
        height: 24px;
        border-radius: 5px;
        border: none;
        background: #fff;
        color: #94a3b8;
        cursor: pointer;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background 0.15s, color 0.15s;
    }

    .ki-hapus:hover {
        background: #fee2e2;
        color: #ef4444;
    }

    .keranjang-kosong {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 24px 16px;
        color: #94a3b8;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .btn-ajukan {
        display: block;
        width: calc(100% - 20px);
        margin: 0 10px 14px;
        padding: 11px;
        border-radius: 8px;
        border: none;
        background: #2563eb;
        color: #fff;
        font-size: 0.88rem;
        font-weight: 700;
        font-family: var(--font);
        cursor: pointer;
        transition: filter 0.15s;
    }

    .btn-ajukan:hover:not(:disabled) {
        filter: brightness(1.08);
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
        max-width: 480px;
        box-shadow: 0 20px 60px #00000030;
        animation: slideUp 0.25s cubic-bezier(0.22, 1, 0.36, 1);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        max-height: 90vh;
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
    }

    .modal-body {
        padding: 20px;
        overflow-y: auto;
        flex: 1;
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

    .btn-tambah-submit {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 9px 22px;
        border-radius: 8px;
        background: #2563eb;
        color: #fff;
        border: none;
        font-size: 0.88rem;
        font-weight: 700;
        font-family: var(--font);
        cursor: pointer;
    }

    .btn-tambah-submit:hover {
        filter: brightness(1.08);
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

    .field-label {
        font-size: 0.8rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 5px;
        display: block;
    }

    .req {
        color: #ef4444;
    }

    @media(max-width:768px) {
        .pinjam-layout {
            grid-template-columns: 1fr;
        }

        .pinjam-right {
            position: static;
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

    /* Buka modal tambah ke keranjang */
    function openTambah(id, nama, stok) {
        document.getElementById('modalTambahTitle').textContent = 'Tambah ke Keranjang: ' + nama;
        document.getElementById('labelJumlah').innerHTML = `Jumlah (Max: ${stok}) <span class="req">*</span>`;
        document.getElementById('tambahBarangId').value = id;
        document.getElementById('inputJumlah').max = stok;
        document.getElementById('inputJumlah').value = 1;
        openModal('modalTambah');
        setTimeout(() => document.getElementById('inputJumlah').focus(), 200);
    }

    /* Buka modal edit pengajuan */
    function openEdit(id, nama, jumlah, catatan, stok) {
        document.getElementById('modalEditTitle').textContent = 'Edit Pengajuan: ' + nama;
        document.getElementById('labelJumlahEdit').innerHTML = `Jumlah (Max: ${stok}) <span class="req">*</span>`;
        document.getElementById('editJumlah').max = stok;
        document.getElementById('editJumlah').value = jumlah;
        document.getElementById('editCatatan').value = catatan;
        document.getElementById('formEdit').action = `/peminjaman-bahan-praktik/${id}`;
        openModal('modalEdit');
    }

    /* Buka modal hapus pengajuan */
    function openHapus(id, nama) {
        document.getElementById('hapusNama').textContent = nama;
        document.getElementById('formHapus').action = `/peminjaman-bahan-praktik/${id}`;
        openModal('modalHapus');
    }
</script>
@endpush