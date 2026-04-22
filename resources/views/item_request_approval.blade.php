@extends('layouts.main')

@section('title', 'Pengajuan Peminjaman')

@section('content')

{{-- ── TABEL STAF ── --}}
<div class="data-table-wrap">
    <div class="data-table-head">
        <span>Pengajuan Peminjaman Barang</span>
    </div>

    <table>
        <thead>
            <tr>
                <th>Siswa</th>
                <th>NIS</th>
                <th>Kelas</th>
                <th>Barang</th>
                <th>Lokasi</th>
                <th>Jumlah</th>
                <th>Tanggal</th>
                <th style="text-align:center;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pengajuans as $i => $data)
            <tr>
                <td style="font-weight:600;">{{ $data->user->name }}</td>
                <td>{{ $data->user->identity_number ?? '-' }}</td>
                <td>{{ $data->user->classRoom->nama ?? '-' }}</td>
                <td>{{ $data->goodItem->name ?? '-' }}</td>
                <td>{{ $data->goodItem->location->name ?? '-' }}</td>
                <td>{{ $data->jumlah ?? '-' }}</td>
                <td>{{ $data->tanggal_pinjam ?? '-' }}</td>
                <td style="text-align:center;">
                    {{-- TERIMA --}}
                    <button class="btn-action btn-edit"
                        onclick="openTerima({{ $data->id }}, '{{ $data->user->name }}')">
                        ✔ Terima
                    </button>

                    {{-- TOLAK --}}
                    <button class="btn-action btn-hapus"
                        onclick="openTolak({{ $data->id }}, '{{ $data->user->name }}')">
                        ✖ Tolak
                    </button>

                    {{-- PRINT --}}
                    <a href="#"
                        target="_blank"
                        class="btn-action"
                        style="background:#dcfce7;color:#166534;text-decoration:none;">
                        🖨 Print
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align:center;color:#94a3b8;padding:32px;font-size:0.87rem;">
                    Belum ada data pengajuan peminjaman barang.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div id="modalTerima" class="modal-overlay">
    <div class="modal-box modal-box-sm">
        <div class="modal-head">
            Konfirmasi Terima
            <button class="modal-close" onclick="closeModal('modalTerima')">✕</button>
        </div>

        <div class="modal-body">
            Yakin ingin menerima pengajuan dari <b id="namaTerima"></b>?
        </div>

        <div class="modal-foot">
            <button class="btn-batal" onclick="closeModal('modalTerima')">Batal</button>

            <form id="formTerima" method="POST">
                @csrf
                @method('PUT')
                <button type="submit" class="btn-hapus-confirm" style="background:#22c55e;">
                    ✔ Ya, Terima
                </button>
            </form>
        </div>
    </div>
</div>

<div id="modalTolak" class="modal-overlay">
    <div class="modal-box modal-box-sm">
        <div class="modal-head modal-head-danger">
            Konfirmasi Tolak
            <button class="modal-close" onclick="closeModal('modalTolak')">✕</button>
        </div>

        <div class="modal-body">
            Yakin ingin menolak pengajuan dari <b id="namaTolak"></b>?
        </div>

        <div class="modal-foot">
            <button class="btn-batal" onclick="closeModal('modalTolak')">Batal</button>

            <form id="formTolak" method="POST">
                @csrf
                @method('PUT')
                <button type="submit" class="btn-hapus-confirm">
                    ✖ Ya, Tolak
                </button>
            </form>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    /* ── ACTION BUTTONS ── */
    .btn-action {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 10px;
        border-radius: 6px;
        border: none;
        font-size: 0.75rem;
        font-weight: 700;
        font-family: var(--font);
        cursor: pointer;
        transition: filter 0.15s, transform 0.1s;
    }

    .btn-action:hover {
        filter: brightness(0.93);
        transform: translateY(-1px);
    }

    .btn-edit {
        background: #dbeafe;
        color: #1e40af;
    }

    .btn-hapus {
        background: #fee2e2;
        color: #991b1b;
    }

    /* ── MODAL OVERLAY ── */
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
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    /* ── MODAL BOX ── */
    .modal-box {
        background: #fff;
        border-radius: 16px;
        width: 100%;
        max-width: 520px;
        box-shadow: 0 20px 60px #00000030;
        animation: slideUp 0.25s cubic-bezier(0.22, 1, 0.36, 1);
        overflow: hidden;
    }

    .modal-box-sm {
        max-width: 400px;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(24px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
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
    }

    .modal-head-danger {
        border-bottom-color: #fee2e2;
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
        transition: background 0.15s, color 0.15s;
    }

    .modal-close:hover {
        background: #f1f5f9;
        color: #0f172a;
    }

    .modal-body {
        padding: 20px;
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
        transition: background 0.15s, border-color 0.15s;
    }

    .btn-batal:hover {
        background: #f1f5f9;
        border-color: #cbd5e1;
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
        transition: filter 0.15s;
    }

    .btn-hapus-confirm:hover {
        filter: brightness(1.1);
    }

    .req {
        color: #ef4444;
    }
</style>
@endpush

@push('scripts')
<script>
    // ── Buka modal ──
    function openModal(id) {
        document.getElementById(id).classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    // ── Tutup modal ──
    function closeModal(id) {
        document.getElementById(id).classList.remove('active');
        document.body.style.overflow = '';
    }

    // ── Klik overlay → tutup ──
    document.querySelectorAll('.modal-overlay').forEach(overlay => {
        overlay.addEventListener('click', function(e) {
            if (e.target === this) closeModal(this.id);
        });
    });

    // ── Esc → tutup semua ──
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') {
            document.querySelectorAll('.modal-overlay.active')
                .forEach(m => closeModal(m.id));
        }
    });

    function openTerima(id, nama) {
        document.getElementById('namaTerima').textContent = nama;
        document.getElementById('formTerima').action = `/pengajuan/${id}/terima`;
        openModal('modalTerima');
    }

    function openTolak(id, nama) {
        document.getElementById('namaTolak').textContent = nama;
        document.getElementById('formTolak').action = `/pengajuan/${id}/tolak`;
        openModal('modalTolak');
    }
</script>
@endpush