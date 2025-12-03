<x-public.app-layout>

    <!-- Hero Section -->
    <section id="home" class="hero-section">
        <div class="container hero-content">
            <h1 class="hero-title">SELAMAT DATANG</h1>
            <p class="hero-subtitle">Kami menyediakan Saprodi Terbaik dan Termurah Untuk Anda</p>
            <div class="hero-buttons">
                <a href="#products" class="btn btn-primary-custom mt-3">
                    <i class="fas fa-shopping-bag me-2"></i>Lihat Produk
                </a>
                <a href="{{ route('katalog') }}" class="btn btn-outline-light mt-3 ms-2">
                    <i class="fas fa-th-large me-2"></i>Katalog Lengkap
                </a>
            </div>
        </div>
        <div class="hero-overlay-pattern"></div>
    </section>

    <!-- Produk Section -->
    <section id="products" class="py-5">
        <div class="container">
            <div class="section-header text-center mb-5">
                <span class="section-badge">Pilihan Terbaik</span>
                <h2 class="section-title">Produk Rekomendasi</h2>
                <p class="section-subtitle text-muted">Produk unggulan yang kami rekomendasikan untuk Anda</p>
            </div>
            <div class="row g-3 g-md-4">
                @foreach ($rekomendBarang as $barang)
                    <div class="col-6 col-md-4 fade-in-up">
                        <a href="{{ route('produk.show', $barang->id) }}" class="text-decoration-none">
                            <div class="card h-100 product-card">
                                <div class="product-image">
                                    <img src="{{ $barang->foto ? Storage::url($barang->foto) : asset('images/no-photo.png') }}"
                                        alt="{{ $barang->nama }}">
                                    <div class="product-overlay">
                                        <span class="overlay-text"><i class="fas fa-eye me-2"></i>Lihat Detail</span>
                                    </div>
                                </div>
                                <div class="card-body d-flex flex-column p-2 p-md-3">
                                    <span class="product-category-badge mb-2">{{ $barang->jenisBarang->jenis ?? 'Umum' }}</span>
                                    <h5 class="card-title product-title">{{ $barang->nama }}</h5>
                                    <p class="card-text text-muted d-none d-md-block">{{ Str::limit($barang->detail, 80) }}</p>
                                    <p class="card-text text-muted d-md-none small">{{ Str::limit($barang->detail, 40) }}</p>
                                    <div class="mt-auto d-flex justify-content-between align-items-center">
                                        <p class="mb-0 product-price">
                                            {{ 'Rp ' . number_format($barang->harga, 0, ',', '.') }}
                                        </p>
                                        <span class="product-unit text-muted small">/ {{ $barang->satuan->satuan ?? 'pcs' }}</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
            <div class="text-center mt-5">
                <a href="{{ route('katalog') }}" class="btn btn-primary-custom btn-lg px-5">
                    <i class="fas fa-th-large me-2"></i>Lihat Semua Produk
                </a>
            </div>
        </div>
    </section>

    <!-- Tentang Section -->
    <section id="about" class="about-section py-5 bg-light">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0 fade-in-left">
                    <span class="section-badge mb-3">Tentang Kami</span>
                    <h2 class="fw-bold mb-4">BUMDes Karya Maju Cemerlang</h2>
                    <p class="lead mb-3">
                        Penggerak ekonomi di Desa Apung yang hadir untuk meningkatkan kesejahteraan warga.
                    </p>
                    <p>
                        Badan Usaha Milik Desa (BUMDes) <strong>Karya Maju Cemerlang</strong> berkomitmen untuk
                        menyediakan sarana produksi pertanian (saprodi) berkualitas tinggi dengan harga terjangkau.
                    </p>
                    <div class="about-features mt-4">
                        <div class="about-feature-item">
                            <i class="fas fa-seedling text-success"></i>
                            <span>Benih Unggul</span>
                        </div>
                        <div class="about-feature-item">
                            <i class="fas fa-leaf text-success"></i>
                            <span>Pupuk Berkualitas</span>
                        </div>
                        <div class="about-feature-item">
                            <i class="fas fa-shield-alt text-success"></i>
                            <span>Pestisida Aman</span>
                        </div>
                        <div class="about-feature-item">
                            <i class="fas fa-tools text-success"></i>
                            <span>Alat Pertanian</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 fade-in-right">
                    <div class="about-image-wrapper">
                        <img src="{{ asset('images/welcome/tentangkami.jpeg') }}" class="img-fluid rounded shadow-lg"
                            alt="Tentang Kami">
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('script')
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            // Fade in animation on scroll
            document.addEventListener('DOMContentLoaded', function() {
                const observerOptions = {
                    threshold: 0.1,
                    rootMargin: '0px 0px -50px 0px'
                };

                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('visible');
                        }
                    });
                }, observerOptions);

                document.querySelectorAll('.fade-in-up, .fade-in-left, .fade-in-right').forEach(el => {
                    observer.observe(el);
                });
            });
        </script>
    @endpush

    @push('style')
        <style>
            /* Hero Section Enhanced */
            .hero-section {
                background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.7)),
                    url({{ asset('images/welcome/bg.jpeg') }}) center/cover no-repeat fixed;
                height: 100vh;
                min-height: 600px;
                color: white;
                display: flex;
                align-items: center;
                justify-content: center;
                text-align: center;
                position: relative;
                overflow: hidden;
            }

            .hero-content {
                position: relative;
                z-index: 2;
            }

            .hero-title {
                font-size: 3.5rem;
                font-weight: 700;
                text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
                animation: fadeInDown 1s ease;
            }

            .hero-subtitle {
                font-size: 1.3rem;
                opacity: 0.95;
                animation: fadeInUp 1s ease 0.3s both;
            }

            .hero-buttons {
                animation: fadeInUp 1s ease 0.6s both;
            }

            .hero-overlay-pattern {
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
                opacity: 0.5;
            }

            /* Section Header */
            .section-badge {
                display: inline-block;
                background: linear-gradient(135deg, #0CC0DF 0%, #0891b2 100%);
                color: white;
                padding: 6px 16px;
                border-radius: 20px;
                font-size: 0.85rem;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 1px;
            }

            .section-subtitle {
                font-size: 1.1rem;
            }

            /* Product Card Enhancements */
            .product-overlay {
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(12, 192, 223, 0.85);
                display: flex;
                align-items: center;
                justify-content: center;
                opacity: 0;
                transition: opacity 0.3s ease;
            }

            .product-card:hover .product-overlay {
                opacity: 1;
            }

            .overlay-text {
                color: white;
                font-weight: 600;
                font-size: 1rem;
            }

            .product-category-badge {
                display: inline-block;
                background: #e8f8fb;
                color: #0891b2;
                padding: 3px 10px;
                border-radius: 12px;
                font-size: 0.75rem;
                font-weight: 500;
                width: fit-content;
            }

            .product-unit {
                font-size: 0.8rem;
            }

            /* About Section Features */
            .about-features {
                display: flex;
                flex-wrap: wrap;
                gap: 15px;
            }

            .about-feature-item {
                display: flex;
                align-items: center;
                gap: 8px;
                background: white;
                padding: 10px 16px;
                border-radius: 25px;
                box-shadow: 0 2px 8px rgba(0,0,0,0.08);
                font-size: 0.9rem;
                font-weight: 500;
            }

            .about-feature-item i {
                font-size: 1.1rem;
            }

            .about-image-wrapper {
                position: relative;
            }

            .about-image-wrapper::before {
                content: '';
                position: absolute;
                top: -15px;
                right: -15px;
                width: 100%;
                height: 100%;
                border: 3px solid #0CC0DF;
                border-radius: 8px;
                z-index: -1;
            }

            /* Animations */
            @keyframes fadeInDown {
                from {
                    opacity: 0;
                    transform: translateY(-30px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .fade-in-up, .fade-in-left, .fade-in-right {
                opacity: 0;
                transition: opacity 0.6s ease, transform 0.6s ease;
            }

            .fade-in-up {
                transform: translateY(30px);
            }

            .fade-in-left {
                transform: translateX(-30px);
            }

            .fade-in-right {
                transform: translateX(30px);
            }

            .fade-in-up.visible, .fade-in-left.visible, .fade-in-right.visible {
                opacity: 1;
                transform: translate(0);
            }

            /* Responsive */
            @media (max-width: 768px) {
                .hero-section {
                    height: 80vh;
                    min-height: 500px;
                }

                .hero-title {
                    font-size: 2rem;
                }

                .hero-subtitle {
                    font-size: 1rem;
                }

                .hero-buttons .btn {
                    display: block;
                    margin: 10px auto !important;
                    width: 80%;
                }

                .about-image-wrapper::before {
                    display: none;
                }

                .about-features {
                    justify-content: center;
                }
            }

            @media (max-width: 576px) {
                .hero-title {
                    font-size: 1.6rem;
                }

                .section-badge {
                    font-size: 0.75rem;
                    padding: 4px 12px;
                }

                .about-feature-item {
                    font-size: 0.8rem;
                    padding: 8px 12px;
                }
            }
        </style>
    @endpush

</x-public.app-layout>
