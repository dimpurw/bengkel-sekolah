@extends('layouts.main')

@section('title', 'Master Kelas')

@section('content')

{{-- ── TABEL Walikelas ── --}}
<div class="data-table-wrap">
    <div class="data-table-head">
        <span>Daftar Kelas</span>
        <button class="btn-add" onclick="openModal('modalTambah')">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                <line x1="12" y1="5" x2="12" y2="19" />
                <line x1="5" y1="12" x2="19" y2="12" />
            </svg>
            Tambah Walikelas
        </button>
    </div>

    <table>
        <thead>
            <tr>
                <th>Kelas</th>
                <th>Walikelas</th>
                <th>NIP</th>
                <th>Username</th>
                <th style="text-align:center;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $i => $walikelas)
            <tr>
                <td style="font-weight:600;">{{ $walikelas->classRoom->nama }}</td>
                <td>{{ $walikelas->name ?? '-' }}</td>
                <td>{{ $walikelas->identity_number }}</td>
                <td>{{ $walikelas->username ?? '-' }}</td>
                <td style="text-align:center;">
                    <div style="display:flex;gap:6px;justify-content:center;">
                        {{-- Tombol Edit --}}
                        <button class="btn-action btn-edit"
                            onclick="openEdit(
                  {{ $walikelas->id }},
                  '{{ addslashes($walikelas->classRoom->nama) }}',
                  '{{ addslashes($walikelas->name ?? '') }}',
                  '{{ addslashes($walikelas->identity_number) }}',
                  '{{ addslashes($walikelas->username ?? '') }}'
                )">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                            </svg>
                            Edit
                        </button>
                        {{-- Tombol Hapus --}}
                        <button class="btn-action btn-hapus"
                            onclick="openHapus({{ $walikelas->id }}, '{{ addslashes($walikelas->nama) }}')">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                                <polyline points="3 6 5 6 21 6" />
                                <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6" />
                                <path d="M10 11v6M14 11v6" />
                                <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2" />
                            </svg>
                            Hapus
                        </button>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align:center;color:#94a3b8;padding:32px;font-size:0.87rem;">
                    Belum ada data Walikelas.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>


{{-- ══════════════════════════════════════════
     MODAL TAMBAH
══════════════════════════════════════════ --}}
<div class="modal-overlay" id="modalTambah">
    <div class="modal-box">
        <div class="modal-head">
            <span>Tambah User</span>
            <button class="modal-close" onclick="closeModal('modalTambah')">✕</button>
        </div>

        <form method="POST" action="{{ route('class.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="modal-body">
                <div class="modal-grid">

                    <div class="field-group field-full">
                        <label class="field-label">Nama Kelas *</label>
                        <input type="text" name="class_room" class="field-input" required>
                    </div>

                    <div class="field-group">
                        <label class="field-label">Nama Walikelas *</label>
                        <input type="text" name="name" class="field-input" required>
                    </div>

                    <div class="field-group">
                        <label class="field-label">NIP *</label>
                        <input type="number" name="identity_number" class="field-input" required>
                    </div>

                    <div class="field-group">
                        <label class="field-label">Username *</label>
                        <input type="text" name="username" class="field-input" required>
                    </div>

                    <div class="field-group">
                        <label class="field-label">Password *</label>
                        <input type="password" name="password" class="field-input" required>
                    </div>

                </div>
            </div>

            <div class="modal-foot">
                <button type="button" class="btn-batal" onclick="closeModal('modalTambah')">Batal</button>
                <button type="submit" class="btn-simpan">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- ══════════════════════════════════════════
     MODAL EDIT
══════════════════════════════════════════ --}}
<div class="modal-overlay" id="modalEdit">
    <div class="modal-box">
        <div class="modal-head">
            <span>Edit User</span>
            <button class="modal-close" onclick="closeModal('modalEdit')">✕</button>
        </div>

        <form method="POST" id="formEdit" action="" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="modal-body">
                <div class="modal-grid">

                    <div class="field-group field-full">
                        <label class="field-label">Nama Kelas *</label>
                        <input type="text" name="class_room" id="edit_class_room" class="field-input" required>
                    </div>

                    <div class="field-group">
                        <label class="field-label">Nama Walikelas *</label>
                        <input type="text" name="name" id="edit_name" class="field-input" required>
                    </div>

                    <div class="field-group">
                        <label class="field-label">NIP *</label>
                        <input type="number" name="identity_number" id="edit_identity_number" class="field-input" required>
                    </div>

                    <div class="field-group">
                        <label class="field-label">Username *</label>
                        <input type="text" name="username" id="edit_username" class="field-input" required>
                    </div>

                    <div class="field-group">
                        <label class="field-label">Password (opsional)</label>
                        <input type="password" name="password" class="field-input">
                    </div>

                </div>
            </div>

            <div class="modal-foot">
                <button type="button" class="btn-batal" onclick="closeModal('modalEdit')">Batal</button>
                <button type="submit" class="btn-simpan">Update</button>
            </div>
        </form>
    </div>
</div>

{{-- ══════════════════════════════════════════
     MODAL HAPUS
══════════════════════════════════════════ --}}
<div class="modal-overlay" id="modalHapus">
    <div class="modal-box modal-box-sm">
        <div class="modal-head modal-head-danger">
            <span>Hapus Kelas</span>
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
            <p style="font-size:0.85rem;color:#64748b;">Data Walikelas <strong id="hapusNama"></strong> akan dihapus permanen dan tidak bisa dikembalikan.</p>
        </div>
        <form method="POST" id="formHapus" action="">
            @csrf
            @method('DELETE')
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

    // ── Buka modal Edit & isi data ──
    function openEdit(id, class_room, name, identity_number, username) {
        document.getElementById('edit_class_room').value = class_room;
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_identity_number').value = identity_number;
        document.getElementById('edit_username').value = username;

        document.getElementById('formEdit').action = `/master-kelas/${id}`;

        openModal('modalEdit');
    }

    // ── Buka modal Hapus & set action ──
    function openHapus(id, nama) {
        document.getElementById('hapusNama').textContent = nama;
        document.getElementById('formHapus').action = `/master-kelas/${id}`;
        openModal('modalHapus');
    }
</script>
@endpush