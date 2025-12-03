<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BarangFactory extends Factory
{
    public function definition(): array
    {
        return [
            'foto' => null, // atau pakai gambar dummy dengan faker jika mau
            'nama' => $this->faker->words(3, true),
            'detail' => $this->faker->paragraph(),
            'harga' => $this->faker->numberBetween(10000, 500000),
            'id_jenis' => null, // bisa diganti kalau sudah ada data jenis
            'id_satuan' => null, // bisa diganti kalau sudah ada data satuan
            'is_rekomendasi' => $this->faker->boolean(20),
        ];
    }
}
