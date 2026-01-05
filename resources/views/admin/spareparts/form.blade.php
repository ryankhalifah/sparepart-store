{{-- Form Partial: Bisa dipakai untuk create & edit --}}
<style>
    /* ===== Tema Form Ungu Elegan ===== */
    .form-label {
        font-weight: 500;
        color: #5e35b1;
    }

    .form-control {
        border-radius: 8px;
        border: 1px solid #d1c4e9;
        box-shadow: none;
        transition: all 0.3s ease;
        background-color: #faf7ff;
    }

    .form-control:focus {
        border-color: #7b42f6;
        box-shadow: 0 0 0 0.2rem rgba(123, 66, 246, 0.2);
        background-color: #fff;
    }

    .input-group-text {
        background: linear-gradient(135deg, #7b42f6, #a25fd6);
        color: #fff;
        font-weight: 500;
        border: none;
    }

    .invalid-feedback {
        color: #d32f2f;
        font-size: 0.9em;
    }

    #imagePreview {
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(128, 0, 128, 0.15);
        margin-top: 5px;
    }

    .preview-label {
        font-size: 0.9rem;
        color: #6a1b9a;
        font-weight: 500;
    }

    /* Efek hover lembut */
    input[type="file"]:hover,
    input[type="number"]:hover,
    input[type="text"]:hover {
        border-color: #a25fd6;
    }
</style>

<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="kode" class="form-label">Kode Spare Part</label>
            <input type="text" class="form-control @error('kode') is-invalid @enderror" id="kode" name="kode"
                value="{{ old('kode', $sparepart->kode ?? '') }}" placeholder="Masukkan kode" required>
            @error('kode')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="nama" class="form-label">Nama Spare Part</label>
            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama"
                value="{{ old('nama', $sparepart->nama ?? '') }}" placeholder="Masukkan nama" required>
            @error('nama')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="kategori" class="form-label">Kategori</label>
            <input type="text" class="form-control @error('kategori') is-invalid @enderror" id="kategori"
                name="kategori" value="{{ old('kategori', $sparepart->kategori ?? '') }}"
                placeholder="Masukkan kategori" required>
            @error('kategori')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label for="harga" class="form-label">Harga (Rp)</label>
            <div class="input-group">
                <span class="input-group-text">Rp</span>
                <input type="number" step="0.01" class="form-control @error('harga') is-invalid @enderror"
                    id="harga" name="harga" value="{{ old('harga', $sparepart->harga ?? '') }}" min="0"
                    required>
            </div>
            @error('harga')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="stok" class="form-label">Stok</label>
            <input type="number" class="form-control @error('stok') is-invalid @enderror" id="stok" name="stok"
                value="{{ old('stok', $sparepart->stok ?? '') }}" min="0" required>
            @error('stok')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="diskon" class="form-label">Diskon (%)</label>
            <input type="number" class="form-control @error('diskon') is-invalid @enderror" id="diskon"
                name="diskon" value="{{ old('diskon', $sparepart->diskon ?? 0) }}" min="0" max="100">
            @error('diskon')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<div class="mb-3">
    <label for="gambar" class="form-label">Gambar Spare Part</label>
    <input type="file" class="form-control @error('gambar') is-invalid @enderror" id="gambar" name="gambar"
        onchange="previewImage(event)">
    @error('gambar')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror

    <div class="mt-3 text-center">
        @if (isset($sparepart) && $sparepart->gambar)
            <p class="preview-label">Gambar Saat Ini:</p>
            <img id="imagePreview" src="{{ asset('storage/' . $sparepart->gambar) }}" alt="Gambar"
                style="max-width: 220px; height: auto;">
        @else
            <img id="imagePreview" style="max-width: 220px; height: auto; display: none;">
        @endif
    </div>
</div>

<script>
    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('imagePreview');
        if (input.files && input.files[0]) {
            preview.src = URL.createObjectURL(input.files[0]);
            preview.style.display = 'block';
        }
    }
</script>
