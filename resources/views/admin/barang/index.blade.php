<x-admin.app-layout>
    <x-slot name="title">
        Data Barang
    </x-slot>

    <div class="card">
        <div class="card-body">
            <x-admin.table button="Tambah Barang" buttonhref="{{ route('barang.create') }}">
                <thead>
                    <tr>
                        <td>No</td>
                        <td>Foto</td>
                        <td>Nama</td>
                        <td>Jenis Barang</td>
                        <td>Harga</td>
                        <td>Satuan</td>
                        <td>Action</td>
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
                            <td>{{ 'Rp ' . $barang->harga }}</td>
                            <td>{{ $barang->satuan->satuan ?? 'Belum diberikan' }}</td>
                            <td>
                                <a href="{{ route('barang.edit', $barang->id) }}" class="btn btn-warning btn-sm"><i
                                        class="ti-pencil">Edit</i></a>
                                <form style="display: inline;" id="delete-form-{{ $barang->id }}"
                                    action="{{ route('barang.destroy', $barang->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm delete-button"
                                        data-id="{{ $barang->id }}">
                                        <i class="ti-trash"></i>Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td>No</td>
                        <td>Foto</td>
                        <td>Nama</td>
                        <td>Jenis Barang</td>
                        <td>Harga</td>
                        <td>Satuan</td>
                        <td>Action</td>
                    </tr>
                </tfoot>
            </x-admin.table>
        </div>
        <div class="card-body">
            <x-admin.table>
                <thead>
                    <tr>
                        <td>No</td>
                        <td>Foto</td>
                        <td>Nama</td>
                        <td>Jenis Barang</td>
                        <td>Harga</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rekomendBarang as $barang)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <img src="{{ $barang->foto ? Storage::url($barang->foto) : asset('images/no-photo.png') }}"
                                    alt="foto barang" width="50"
                                    onerror="this.onerror=null;this.src='{{ asset('images/no-photo.png') }}';">
                            </td>
                            <td>{{ $barang->nama }}</td>
                            <td>{{ $barang->jenis_barang->jenis ?? 'Belum diberikan' }}</td>
                            <td>{{ 'Rp ' . $barang->harga }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </x-admin.table>

        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".delete-button").forEach(button => {
                button.addEventListener("click", function() {
                    const jenisId = this.getAttribute("data-id");
                    Swal.fire({
                        title: "Apakah Anda yakin ingin menghapus?",
                        text: "Anda tidak dapat mengembalikan data ini!",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        cancelButtonColor: "#3085d6",
                        confirmButtonText: "Ya, hapus!",
                        cancelButtonText: "Batal"
                    }).then((result) => {
                        if (result.isConfirmed || result
                            .value) {
                            document.getElementById("delete-form-" + jenisId)
                                .submit();
                        }
                    });

                });
            });
        });
    </script>
</x-admin.app-layout>
