<x-admin.app-layout>
    <x-slot name="title">
        Data Barang
    </x-slot>

    <div class="card">
        <div class="card-body">
            <x-admin.table>
                <thead class="thead-light">
                    <tr>
                        <th>No</th>
                        <th>Foto</th>
                        <th>Nama</th>
                        <th>Jenis Barang</th>
                        <th>Harga</th>
                        <th>Satuan</th>
                        <th>Rekomendasi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($banyakBarang as $barang)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <img src="{{ $barang->foto ? Storage::url($barang->foto) : asset('images/no-photo.png') }}"
                                    alt="foto barang" width="50"
                                    onerror="this.onerror=null;this.src='{{ asset('images/no-photo.png') }}';">
                            </td>
                            <td>{{ $barang->nama }}</td>
                            <td>{{ $barang->jenis_barang->jenis ?? 'Belum diberikan' }}</td>
                            <td>{{ 'Rp ' . number_format($barang->harga, 0, ',', '.') }}</td>
                            <td>{{ $barang->satuan->satuan ?? 'Belum diberikan' }}</td>
                            <td class="text-center">
                                <input type="checkbox" class="form-check-input rekom-checkbox"
                                    data-id="{{ $barang->id }}" {{ $barang->is_rekomendasi ? 'checked' : '' }}>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="thead-light">
                    <tr>
                        <th>No</th>
                        <th>Foto</th>
                        <th>Nama</th>
                        <th>Jenis Barang</th>
                        <th>Harga</th>
                        <th>Satuan</th>
                        <th>Rekomendasi</th>
                    </tr>
                </tfoot>
            </x-admin.table>
            <div class="text-right mt-3">
                <button id="save-rekomendasi" class="btn btn-primary">Simpan Rekomendasi</button>
            </div>

        </div>
    </div>

    <p id="warning" class="text-center text-danger mt-2"></p>

    {{-- SweetAlert + Rekomendasi Script --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // (script delete dan updateCheckboxes tetap sama)

            const checkboxes = document.querySelectorAll('.rekom-checkbox');
            const warning = document.getElementById('warning');
            const saveButton = document.getElementById('save-rekomendasi');

            function updateCheckboxes() {
                const checkedCount = Array.from(checkboxes).filter(cb => cb.checked).length;
                checkboxes.forEach(cb => {
                    if (!cb.checked) cb.disabled = checkedCount >= 3;
                    else cb.disabled = false;
                });

                warning.textContent = checkedCount >= 3 ? "Maksimal 3 barang bisa direkomendasikan." : "";
            }

            // Tombol simpan rekomendasi
            saveButton.addEventListener('click', function() {
                const selectedIds = Array.from(checkboxes)
                    .filter(cb => cb.checked)
                    .map(cb => cb.dataset.id);

                fetch("{{ url('/barang/update-bulk-rekomendasi') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                                .getAttribute("content")
                        },
                        body: JSON.stringify({
                            rekomendasi_ids: selectedIds
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire("Berhasil", "Rekomendasi berhasil disimpan!", "success");
                        } else {
                            Swal.fire("Gagal", data.error || "Gagal menyimpan", "error");
                        }
                    })
                    .catch(error => {
                        console.error("Terjadi kesalahan:", error);
                        Swal.fire("Error", "Terjadi kesalahan saat mengupdate.", "error");
                    });
            });

            updateCheckboxes(); // inisialisasi awal
        });
    </script>

</x-admin.app-layout>
