<x-admin.app-layout>
    <x-slot name="title">
        Data Jenis Barang
    </x-slot>

    <div class="card">
        <div class="card-body">
            <x-admin.table button="Tambah Jenis Barang" buttonhref="{{ route('jenis_barang.create') }}">
                <thead>
                    <tr>
                        <td>No</td>
                        <td>Jenis</td>
                        <td>Action</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($jenisBarang as $jenis)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $jenis->jenis }}</td>
                            <td>
                                <a href="{{ route('jenis_barang.edit', $jenis->id) }}" class="btn btn-warning btn-sm">
                                    <i class="ti-pencil"></i> Edit
                                </a>
                                <form id="delete-form-{{ $jenis->id }}" action="{{ route('jenis_barang.destroy', $jenis->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm delete-button"
                                        data-id="{{ $jenis->id }}">
                                        <i class="ti-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td>No</td>
                        <td>Jenis</td>
                        <td>Action</td>
                    </tr>
                </tfoot>
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
