@extends('layouts.main')

@section('title', 'Identitas Sekolah')

@section('content')
<div class="identitas-wrap">

    {{-- ── FORM PANEL ── --}}
    <div class="identitas-form-panel">
        <div class="identitas-card">
            <div class="identitas-card-title">Identitas Sekolah</div>

            <form method="POST" action="{{ route('school.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="identitas-grid">

                    <div class="field-group">
                        <label class="field-label" for="nama_sekolah">Nama Sekolah</label>
                        <input type="text" class="field-input @error('nama_sekolah') is-invalid @enderror"
                            id="nama_sekolah" name="nama_sekolah"
                            value="{{ old('nama_sekolah', $school->nama_sekolah ?? '') }}" required />
                        @error('nama_sekolah')<span style="color:#ef4444;font-size:0.75rem;">{{ $message }}</span>@enderror
                    </div>

                    <div class="field-group">
                        <label class="field-label" for="npsn">NPSN</label>
                        <input type="number" class="field-input @error('npsn') is-invalid @enderror"
                            id="npsn" name="npsn"
                            value="{{ old('npsn', $school->npsn ?? '') }}" required />
                        @error('npsn')<span style="color:#ef4444;font-size:0.75rem;">{{ $message }}</span>@enderror
                    </div>

                    <div class="field-group">
                        <label class="field-label" for="kota">Kabupaten/Kota</label>
                        <input type="text" class="field-input @error('kota') is-invalid @enderror"
                            id="kota" name="kota"
                            value="{{ old('kota', $school->kota ?? '') }}" />
                        @error('kota')<span style="color:#ef4444;font-size:0.75rem;">{{ $message }}</span>@enderror
                    </div>

                    <div class="field-group">
                        <label class="field-label" for="provinsi">Provinsi</label>
                        <input type="text" class="field-input @error('provinsi') is-invalid @enderror"
                            id="provinsi" name="provinsi"
                            value="{{ old('provinsi', $school->provinsi ?? '') }}" />
                        @error('provinsi')<span style="color:#ef4444;font-size:0.75rem;">{{ $message }}</span>@enderror
                    </div>

                    <div class="field-group">
                        <label class="field-label" for="tahun_ajaran">Tahun Ajaran</label>
                        <input type="text" class="field-input @error('tahun_ajaran') is-invalid @enderror"
                            id="tahun_ajaran" name="tahun_ajaran"
                            placeholder="2025/2026"
                            value="{{ old('tahun_ajaran', $school->tahun_ajaran ?? '') }}" />
                        @error('tahun_ajaran')<span style="color:#ef4444;font-size:0.75rem;">{{ $message }}</span>@enderror
                    </div>

                    <div class="field-group">
                        <label class="field-label" for="nama_bengkel">Nama Bengkel/Lab</label>
                        <input type="text" class="field-input @error('nama_bengkel') is-invalid @enderror"
                            id="nama_bengkel" name="nama_bengkel"
                            value="{{ old('nama_bengkel', $school->nama_bengkel ?? '') }}" />
                        @error('nama_bengkel')<span style="color:#ef4444;font-size:0.75rem;">{{ $message }}</span>@enderror
                    </div>

                    <div class="field-group">
                        <label class="field-label" for="nama_kepsek">Nama Kepala Sekolah</label>
                        <input type="text" class="field-input @error('nama_kepsek') is-invalid @enderror"
                            id="nama_kepsek" name="nama_kepsek"
                            value="{{ old('nama_kepsek', $school->nama_kepsek ?? '') }}" />
                        @error('nama_kepsek')<span style="color:#ef4444;font-size:0.75rem;">{{ $message }}</span>@enderror
                    </div>

                    <div class="field-group">
                        <label class="field-label" for="nip_kepsek">NIP Kepala Sekolah</label>
                        <input type="number" class="field-input @error('nip_kepsek') is-invalid @enderror"
                            id="nip_kepsek" name="nip_kepsek"
                            value="{{ old('nip_kepsek', $school->nip_kepsek ?? '') }}" />
                        @error('nip_kepsek')<span style="color:#ef4444;font-size:0.75rem;">{{ $message }}</span>@enderror
                    </div>

                    <div class="field-group field-full">
                        <label class="field-label" for="foto_kepsek">Foto Kepala Sekolah</label>
                        <input type="file" class="field-input @error('foto_kepsek') is-invalid @enderror"
                            id="foto_kepsek" name="foto_kepsek" accept="image/*" />
                        @error('foto_kepsek')
                        <span style="color:#ef4444;font-size:0.75rem;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="field-group">
                        <label class="field-label" for="nama_kabeng">Nama Kepala Bengkel/Lab</label>
                        <input type="text" class="field-input @error('nama_kabeng') is-invalid @enderror"
                            id="nama_kabeng" name="nama_kabeng"
                            value="{{ old('nama_kabeng', $school->nama_kabeng ?? '') }}" />
                        @error('nama_kabeng')<span style="color:#ef4444;font-size:0.75rem;">{{ $message }}</span>@enderror
                    </div>

                    <div class="field-group">
                        <label class="field-label" for="nip_kabeng">NIP Kepala Bengkel/Lab</label>
                        <input type="number" class="field-input @error('nip_kabeng') is-invalid @enderror"
                            id="nip_kabeng" name="nip_kabeng"
                            value="{{ old('nip_kabeng', $school->nip_kabeng ?? '') }}" />
                        @error('nip_kabeng')<span style="color:#ef4444;font-size:0.75rem;">{{ $message }}</span>@enderror
                    </div>

                    <div class="field-group field-full">
                        <label class="field-label" for="foto_kabeng">Foto Kepala Bengkel/Lab</label>
                        <input type="file" class="field-input @error('foto_kabeng') is-invalid @enderror"
                            id="foto_kabeng" name="foto_kabeng" accept="image/*" />
                        @error('foto_kabeng')
                        <span style="color:#ef4444;font-size:0.75rem;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="field-group field-full">
                        <label class="field-label" for="logo">Logo Sekolah</label>
                        <input type="file" class="field-input @error('logo') is-invalid @enderror"
                            id="logo" name="logo" accept="image/*" />
                        @error('logo')
                        <span style="color:#ef4444;font-size:0.75rem;">{{ $message }}</span>
                        @enderror
                    </div>

                </div>{{-- /identitas-grid --}}

                <div style="margin-top:20px;">
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

    {{-- ── PREVIEW PANEL ── --}}
    <div class="identitas-preview-panel">

        <div class="preview-block">
            <div class="preview-label">Preview Logo Sekolah</div>
            <div class="preview-img-wrap">
                <img id="prev-logo"
                    src="{{ $school->logo ?? '' }}"
                    alt="Logo Sekolah"
                    style="{{ ($school->logo ?? '') ? '' : 'display:none' }}"
                    onerror="this.style.display='none'" />
                @if(!($school->logo ?? ''))
                <span style="color:#94a3b8;font-size:0.8rem;">Belum ada logo</span>
                @endif
            </div>
        </div>

        <div class="preview-block">
            <div class="preview-label">Preview Foto Kepala Sekolah</div>
            <div class="preview-img-wrap preview-photo">
                <img id="prev-kepsek"
                    src="{{ $school->foto_kepsek ?? '' }}"
                    alt="Foto Kepala Sekolah"
                    style="{{ ($school->foto_kepsek ?? '') ? '' : 'display:none' }}"
                    onerror="this.style.display='none'" />
                @if(!($school->foto_kepsek ?? ''))
                <span style="color:#94a3b8;font-size:0.8rem;padding:16px;">Belum ada foto</span>
                @endif
            </div>
        </div>

        <div class="preview-block">
            <div class="preview-label">Preview Foto Kepala Bengkel</div>
            <div class="preview-img-wrap preview-photo">
                <img id="prev-kabeng"
                    src="{{ $school->foto_kabeng ?? '' }}"
                    alt="Foto Kepala Bengkel"
                    style="{{ ($school->foto_kabeng ?? '') ? '' : 'display:none' }}"
                    onerror="this.style.display='none'" />
                @if(!($school->foto_kabeng ?? ''))
                <span style="color:#94a3b8;font-size:0.8rem;padding:16px;">Belum ada foto</span>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    function updatePreview(inputId, imgId) {
        const url = document.getElementById(inputId).value.trim();
        const img = document.getElementById(imgId);
        if (url) {
            img.src = url;
            img.style.display = '';
        } else {
            img.style.display = 'none';
        }
    }
</script>
@endpush