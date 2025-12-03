<x-admin.app-layout>

    <x-slot name="title">
        Data Barang
    </x-slot>

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">
                Tambah Data Barang
            </h4>
        </div>
        <div class="card-body">
            <form action="{{ route('barang.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="mb-3">
                        <img id="imagePreview" src="#" alt="Preview Foto"
                            style="display: none; max-width: 200px; margin-top: 10px;">
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-12 col-12">
                        <div class="mb-3">
                            <label for="foto" class="form-label">Foto Barang</label>
                            <input type="file" class="form-control" id="foto" name="foto" accept="image/*"
                                onchange="previewImage(event)">
                        </div>
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Barang</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="detail" class="form-label">Detail Barang</label>
                            <textarea  rows="4" class="form-control" id="detail" name="detail" placeholder="isikan detail deskripsi barang" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="harga" class="form-label">Harga Rp</label>
                            <input type="number" class="form-control id="harga" name="harga" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="id_Jenis">Jenis Barang</label>
                            <select class="form-control" name="id_jenis" id="id_jenis">
                                <option value="">-- Pilih Jenis Barang --</option>
                                @foreach ($banyakJenis as $jenis)
                                    <option value="{{ $jenis->id }}">{{ $jenis->jenis }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="id_satuan">Satuan Penjualan</label>
                            <select class="form-control" name="id_satuan" id="id_satuan">
                                <option value="">-- Pilih Satuan --</option>
                                @foreach ($banyakSatuan as $satuan)
                                    <option value="{{ $satuan->id }}">{{ $satuan->satuan }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <a href="{{route('barang.index')}}" class="btn btn-danger">Kembali</a>
                <button id="submit-button" type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const submitButton = document.getElementById("submit-button");

            submitButton.addEventListener("click", function() {
                // Tunggu validasi browser
                // Gunakan setTimeout 0 agar ini dieksekusi setelah browser validasi
                setTimeout(() => {
                    const form = this.closest("form");
                    if (form && form.checkValidity()) {
                        // Jika form valid, nonaktifkan tombol agar tidak spam
                        this.disabled = true;
                        this.innerHTML = "Menyimpan...";
                    }
                }, 0);
            });
        });
    </script>

    <script>
        function previewImage(event) {
            const input = event.target;
            const preview = document.getElementById('imagePreview');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</x-admin.app-layout>
