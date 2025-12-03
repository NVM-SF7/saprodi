<x-admin.app-layout>
    <x-slot name="title">
        Data Satuan
    </x-slot>

    <div class="card">
        <div class="card-header">
            <div class="card-title">
                Edit Satuan
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('satuan.update', $satuan->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="nama" class="form-label">Satuan Barang</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="{{$satuan->satuan}}" required>
                </div>
                <a href="{{ route('satuan.index') }} " class="btn btn-danger"> Kembali </a>
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
</x-admin.app-layout>
