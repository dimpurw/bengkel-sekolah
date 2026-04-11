@extends('layouts.main')

@section('title', 'Lokasi Penyimpanan')

@section('content')

<div class="data-table-wrap">

    {{-- Header --}}
    <div style="padding:16px 20px;border-bottom:1px solid #e2e8f0;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px;">
        <span style="font-size:0.92rem;font-weight:800;color:#0f172a;">
            Lokasi Penyimpanan
        </span>
        <div style="display:flex;gap:8px;">
            <a href="#" target="_blank" class="btn-top btn-cetak">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                    <polyline points="6 9 6 2 18 2 18 9" />
                    <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2" />
                    <rect x="6" y="14" width="12" height="8" />
                </svg>
                Cetak Semua
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

    {{-- Card Grid --}}
    <div style="padding:20px;">
        @if($locations->isEmpty())
        <div style="text-align:center;padding:48px;color:#94a3b8;">
            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                style="margin:0 auto 12px;display:block;opacity:.4;">
                <circle cx="12" cy="10" r="3" />
                <path d="M12 2a8 8 0 0 0-8 8c0 5.4 7.05 11.5 7.35 11.76a1 1 0 0 0 1.3 0C12.95 21.5 20 15.4 20 10a8 8 0 0 0-8-8z" />
            </svg>
            <p style="font-size:0.88rem;font-weight:600;">Belum ada lokasi penyimpanan.</p>
        </div>
        @else
        <div class="lokasi-grid">
            @foreach($locations as $lok)
            <div class="lokasi-card">
                {{-- Header kartu --}}
                <div class="lokasi-card-head">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2">
                        <circle cx="12" cy="10" r="3" />
                        <path d="M12 2a8 8 0 0 0-8 8c0 5.4 7.05 11.5 7.35 11.76a1 1 0 0 0 1.3 0C12.95 21.5 20 15.4 20 10a8 8 0 0 0-8-8z" />
                    </svg>
                    <span class="lokasi-nama">{{ $lok->name }}</span>
                </div>
                <div class="qr-wrapper">
                    {!! DNS2D::getBarcodeHTML('LOK:' . $lok->name, 'QRCODE', 4, 4) !!}
                </div>
                {{-- Aksi --}}
                <div class="lokasi-aksi">
                    <button class="btn-detail"
                        onclick="openDetail({{ $lok->id }}, '{{ addslashes($lok->nama) }}', '{{ addslashes($lok->deskripsi ?? '') }}')">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                            <circle cx="12" cy="12" r="3" />
                        </svg>
                        Detail
                    </button>
                    <button class="btn-icon-blue" title="Edit"
                        onclick="openEdit(
                            {{ $lok->id }},
                            '{{ addslashes($lok->name) }}',
                        )">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                            <path d="M12 20h9" />
                            <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z" />
                        </svg>
                    </button>
                    <button class="btn-icon-red" title="Hapus"
                        onclick="openHapus({{ $lok->id }}, '{{ addslashes($lok->nama) }}')">
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
    <div class="modal-box" style="max-width:440px;">
        <div class="modal-head">
            <span>Tambah Lokasi Penyimpanan</span>
            <button class="modal-close" onclick="closeModal('modalTambah')">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <line x1="18" y1="6" x2="6" y2="18" />
                    <line x1="6" y1="6" x2="18" y2="18" />
                </svg>
            </button>
        </div>
        <form method="POST" action="{{ route('location.store') }}">
            @csrf
            <div class="modal-body">

                <div class="field-group" style="margin-bottom:16px;">
                    <label class="field-label">Nama Lokasi <span class="req">*</span></label>
                    <input type="text" class="field-input" name="name" id="inputNamaLokasi"
                        value="{{ old('nama') }}"
                        placeholder="Contoh: Rak 1, Lemari B2..."
                        required autofocus />
                    @error('nama')<span class="err-msg">{{ $message }}</span>@enderror
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
    <div class="modal-box" style="max-width:440px;">
        <div class="modal-head">
            <span>Edit Lokasi Penyimpanan</span>
            <button class="modal-close" onclick="closeModal('modalEdit')">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <line x1="18" y1="6" x2="6" y2="18" />
                    <line x1="6" y1="6" x2="18" y2="18" />
                </svg>
            </button>
        </div>
        <form method="POST" id="formEdit">
            @csrf
            @method('PUT')
            <div class="modal-body">

                <div class="field-group" style="margin-bottom:16px;">
                    <label class="field-label">Nama Lokasi <span class="req">*</span></label>
                    <input type="text" class="field-input" name="name" id="edit_name" required autofocus />
                    @error('nama')<span class="err-msg">{{ $message }}</span>@enderror
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
    <div class="modal-box" style="max-width:400px;">
        <div class="modal-head">
            <span>Detail Lokasi</span>
            <button class="modal-close" onclick="closeModal('modalDetail')">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <line x1="18" y1="6" x2="6" y2="18" />
                    <line x1="6" y1="6" x2="18" y2="18" />
                </svg>
            </button>
        </div>
        <div class="modal-body" style="text-align:center;">
            <div style="display:inline-flex;align-items:center;gap:8px;background:#eff6ff;border:1px solid #bfdbfe;border-radius:8px;padding:8px 16px;margin-bottom:10px;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2">
                    <circle cx="12" cy="10" r="3" />
                    <path d="M12 2a8 8 0 0 0-8 8c0 5.4 7.05 11.5 7.35 11.76a1 1 0 0 0 1.3 0C12.95 21.5 20 15.4 20 10a8 8 0 0 0-8-8z" />
                </svg>
                <span id="detailNama" style="font-weight:800;color:#1e40af;font-size:0.95rem;"></span>
            </div>
            <p id="detailDeskripsi" style="font-size:0.82rem;color:#64748b;margin-bottom:16px;"></p>

            {{-- QR besar --}}
            <div id="detailQrWrap" style="display:flex;justify-content:center;margin-bottom:10px;"></div>
            <p style="font-size:0.73rem;color:#94a3b8;">Scan QR untuk identifikasi lokasi</p>
        </div>
        <div class="modal-foot" style="justify-content:space-between;">
            <button type="button" class="btn-batal" onclick="closeModal('modalDetail')">Tutup</button>
            <a id="detailCetakBtn" href="#" target="_blank" class="btn-simpan" style="text-decoration:none;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                    <polyline points="6 9 6 2 18 2 18 9" />
                    <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2" />
                    <rect x="6" y="14" width="12" height="8" />
                </svg>
                Cetak QR
            </a>
        </div>
    </div>
</div>


{{-- ══════════════════ MODAL HAPUS ══════════════════ --}}
<div class="modal-overlay" id="modalHapus">
    <div class="modal-box modal-box-sm">
        <div class="modal-head">
            <span>Hapus Lokasi</span>
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
            <p style="font-size:0.85rem;color:#64748b;">Lokasi <strong id="hapusNama"></strong> akan dihapus permanen.</p>
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
    .qr-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 10px 0;
    }

    .qr-wrapper svg {
        width: 100px;
        height: 100px;
    }

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

    .btn-tambah {
        background: #2563eb;
        color: #fff;
    }

    .lokasi-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 16px;
    }

    .lokasi-card {
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        overflow: hidden;
        background: #fff;
        transition: box-shadow 0.2s, transform 0.15s;
    }

    .lokasi-card:hover {
        box-shadow: 0 6px 24px #00000012;
        transform: translateY(-2px);
    }

    .lokasi-card-head {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 13px 16px 11px;
        background: #f8faff;
        border-bottom: 1px solid #e2e8f0;
    }

    .lokasi-nama {
        font-size: 0.9rem;
        font-weight: 800;
        color: #1e3a8a;
    }

    .lokasi-qr {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px 16px;
        background: #fff;
        min-height: 190px;
    }

    /* Scale SVG dari milon/barcode */
    .lokasi-qr svg {
        width: 160px !important;
        height: 160px !important;
    }

    .lokasi-aksi {
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

    .btn-icon-blue {
        background: #448eef;
        color: #fff;
        width: 32px;
        height: 32px;
        border-radius: 7px;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: filter 0.15s;
        flex-shrink: 0;
    }

    .btn-icon-blue:hover {
        filter: brightness(1.1);
    }

    .btn-icon-red {
        width: 32px;
        height: 32px;
        border-radius: 7px;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        background: #ef4444;
        color: #fff;
        transition: filter 0.15s;
        flex-shrink: 0;
    }

    .btn-icon-red:hover {
        filter: brightness(1.1);
    }

    /* QR Preview wrap */
    .qr-preview-wrap {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        overflow: hidden;
    }

    .qr-preview-label {
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 10px 14px;
        border-bottom: 1px solid #e2e8f0;
        font-size: 0.78rem;
        font-weight: 700;
        color: #374151;
        background: #f1f5f9;
    }

    /* Scale SVG preview */
    #qrResult svg {
        width: 140px !important;
        height: 140px !important;
        border-radius: 6px;
    }

    #detailQrWrap svg {
        width: 200px !important;
        height: 200px !important;
    }

    /* Spinner */
    .qr-spinner {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        border: 3px solid #e2e8f0;
        border-top-color: #2563eb;
        animation: spin 0.7s linear infinite;
    }

    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
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

    .err-msg {
        color: #ef4444;
        font-size: 0.75rem;
        margin-top: 2px;
        display: block;
    }

    .req {
        color: #ef4444;
    }

    @media(max-width:500px) {
        .lokasi-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush


@push('scripts')
<script>
    // Edit Modal
    function openEdit(id, name) {
        document.getElementById('edit_name').value = name;

        // set action form
        document.getElementById('formEdit').action = `/lokasi-penyimpanan/${id}`;
        openModal('modalEdit');
    }


    /* Modal helpers */
    function openModal(id) {
        document.getElementById(id).classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeModal(id) {
        document.getElementById(id).classList.remove('active');
        document.body.style.overflow = '';
        if (id === 'modalTambah') resetPreview();
    }
    document.querySelectorAll('.modal-overlay').forEach(o => {
        o.addEventListener('click', e => {
            if (e.target === o) closeModal(o.id);
        });
    });
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') document.querySelectorAll('.modal-overlay.active').forEach(m => closeModal(m.id));
    });

    function showState(state) {
        document.getElementById('qrPlaceholder').style.display = state === 'placeholder' ? 'flex' : 'none';
        document.getElementById('qrLoading').style.display = state === 'loading' ? 'flex' : 'none';
        document.getElementById('qrResult').style.display = state === 'result' ? 'block' : 'none';
    }

    function resetPreview() {
        showState('placeholder');
        document.getElementById('qrResult').innerHTML = '';
        document.getElementById('inputNamaLokasi').value = '';
    }

    /* Detail */
    function openDetail(id, nama, deskripsi) {
        document.getElementById('detailNama').textContent = nama;
        document.getElementById('detailDeskripsi').textContent = deskripsi || '';
        document.getElementById('detailCetakBtn').href = `/lokasi-penyimpanan/${id}/cetak`;

        // Load QR besar
        fetch(`/lokasi/${id}/qr-svg`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(r => r.text())
            .then(svg => {
                document.getElementById('detailQrWrap').innerHTML = svg;
            });

        openModal('modalDetail');
    }

    /* Hapus */
    function openHapus(id, nama) {
        document.getElementById('hapusNama').textContent = nama;
        document.getElementById('formHapus').action = `/lokasi-penyimpanan/${id}`;
        openModal('modalHapus');
    }
</script>
@endpush