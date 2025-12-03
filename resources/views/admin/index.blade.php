<x-admin.app-layout>
    <link rel="stylesheet" href="{{ asset('icons/font-awesome-old/css/font-awesome.min.css') }}">

    <x-slot name="title">
        Dashboard
    </x-slot>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <!-- Total Petani -->
                <div class="col-sm-12 col-lg-4 mb-4">
                    <div class="card shadow-sm border-0 h-100 hover-card">
                        <div class="card-body d-flex align-items-center py-4 px-3">
                            <div class="icon-circle bg-primary-light mr-3">
                                <i class="ti ti-package text-primary" style="font-size: 1.8rem;"></i>
                            </div>
                            <div>
                                <div class="text-muted" style="font-size: 1.1rem;">Kelola Barang</div>
                                <div class="font-weight-bold text-dark" style="font-size: 1.8rem;">
                                </div>
                            </div>
                        </div>
                        <div class="card-body d-flex flex-column justify-content-between">
                            <a href="{{ route('barang.index') }}" class="btn btn-primary mt-auto">Lihat Halaman</a>
                        </div>
                    </div>
                </div>
                <!-- Total Petani -->
                <div class="col-sm-12 col-lg-4 mb-4">
                    <div class="card shadow-sm border-0 h-100 hover-card">
                        <div class="card-body d-flex align-items-center py-4 px-3">
                            <div class="icon-circle bg-primary-light mr-3">
                                <i class="ti ti-ruler text-primary" fffstyle="font-size: 1.8rem;"></i>
                            </div>
                            <div>
                                <div class="text-muted" style="font-size: 1.1rem;">Daftar Satuan</div>
                                <div class="font-weight-bold text-dark" style="font-size: 1.8rem;">
                                </div>
                            </div>
                        </div>
                        <div class="card-body d-flex flex-column justify-content-between">
                            <a href="{{ route('satuan.index') }}" class="btn btn-primary mt-auto">Lihat Halaman</a>
                        </div>
                    </div>
                </div>
                <!-- Total Petani -->
                <div class="col-sm-12 col-lg-4 mb-4">
                    <div class="card shadow-sm border-0 h-100 hover-card">
                        <div class="card-body d-flex align-items-center py-4 px-3">
                            <div class="icon-circle bg-primary-light mr-3">
                                <i class="ti ti-tag text-primary" style="font-size: 1.8rem;"></i>
                            </div>
                            <div>
                                <div class="text-muted" style="font-size: 1.1rem;">Daftar Jenis Barang</div>
                                <div class="font-weight-bold text-dark" style="font-size: 1.8rem;">
                                </div>
                            </div>
                        </div>
                        <div class="card-body d-flex flex-column justify-content-between">
                            <a href="{{ route('jenis_barang.index') }}" class="btn btn-primary mt-auto">Lihat
                                Halaman</a>
                        </div>
                    </div>
                </div>
            </div>
            <form action="{{ url('settings/telepon') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="value" class="form-label">Nomor WhatsApp / Telepon</label>
                    <p class="text">Gunakan 62 sebagai pengganti 0 didepa</p>
                    <input type="text" name="value" id="value" class="form-control"
                        value="{{ $setting->value }}" required>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">
                Recomended Item
            </h4>
        </div>
        <div class="card-body">
            <x-admin.table button="Ubah Item Rekomendasi" buttonhref="{{ route('best_sell.index') }}">
                <thead>
                    <tr>
                        <td>No</td>
                        <td>Foto</td>
                        <td>Nama</td>
                        <td>Jenis Barang</td>
                        <td>Harga</td>
                        <td>Satuan</td>
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
                            <td>{{ $barang->satuan->satuan ?? 'Belum diberikan' }}</td>
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
                    </tr>
                </tfoot>
            </x-admin.table>
        </div>
    </div>
    <x-admin.table button="Tambah Barang" buttonhref="{{ route('barang.create') }}">
        <thead>
            <tr>
                <td>No</td>
                <td>Foto</td>
                <td>Nama</td>
                <td>Jenis Barang</td>
                <td>Harga</td>
                <td>Satuan</td>
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
            </tr>
        </tfoot>
    </x-admin.table>
</x-admin.app-layout>
