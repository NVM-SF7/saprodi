<x-public.app-layout>
    <!-- Breadcrumb Section -->
    <section class="breadcrumb-section">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('landing_page') }}"><i class="fas fa-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('katalog') }}">Katalog</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($barang->nama, 25) }}</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- Product Detail Section -->
    <section class="product-detail-section">
        <div class="container">
            <div class="product-detail-card">
                <div class="row g-0">
                    <!-- Product Image Column -->
                    <div class="col-lg-6">
                        <div class="product-gallery">
                            <div class="main-image-container" data-bs-toggle="modal" data-bs-target="#imageModal">
                                <img src="{{ $barang->foto ? Storage::url($barang->foto) : asset('images/no-photo.png') }}"
                                    alt="{{ $barang->nama }}" class="main-product-image" id="mainImage">
                                <div class="image-overlay">
                                    <i class="fas fa-expand"></i>
                                    <span>Klik untuk memperbesar</span>
                                </div>
                                @if($barang->jenisBarang)
                                    <span class="category-ribbon">{{ $barang->jenisBarang->jenis }}</span>
                                @endif
                                @if($barang->is_rekomendasi)
                                    <span class="featured-badge"><i class="fas fa-star"></i> Rekomendasi</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Product Info Column -->
                    <div class="col-lg-6">
                        <div class="product-info">
                            <!-- Category & Code -->
                            <div class="product-meta-top">
                                @if($barang->jenisBarang)
                                    <span class="category-tag">
                                        <i class="fas fa-folder-open"></i> {{ $barang->jenisBarang->jenis }}
                                    </span>
                                @endif
                                @if($barang->kode)
                                    <span class="product-sku">SKU: {{ $barang->kode }}</span>
                                @endif
                            </div>

                            <!-- Product Title -->
                            <h1 class="product-title">{{ $barang->nama }}</h1>

                            <!-- Price Section -->
                            <div class="price-section">
                                <div class="price-tag">
                                    <span class="currency">Rp</span>
                                    <span class="price-amount">{{ number_format($barang->harga, 0, ',', '.') }}</span>
                                    @if($barang->satuan)
                                        <span class="price-unit">/ {{ $barang->satuan->satuan }}</span>
                                    @endif
                                </div>
                            </div>

                            <!-- Product Description -->
                            @if ($barang->detail)
                                <div class="product-short-desc">
                                    <p>{{ $barang->detail }}</p>
                                </div>
                            @endif

                            <!-- Product Specs -->
                            <div class="product-specs">
                                <div class="spec-item">
                                    <div class="spec-icon">
                                        <i class="fas fa-box"></i>
                                    </div>
                                    <div class="spec-content">
                                        <span class="spec-label">Satuan</span>
                                        <span class="spec-value">{{ $barang->satuan->satuan ?? 'Pcs' }}</span>
                                    </div>
                                </div>
                                <div class="spec-item">
                                    <div class="spec-icon">
                                        <i class="fas fa-layer-group"></i>
                                    </div>
                                    <div class="spec-content">
                                        <span class="spec-label">Kategori</span>
                                        <span class="spec-value">{{ $barang->jenisBarang->jenis ?? 'Umum' }}</span>
                                    </div>
                                </div>
                                <div class="spec-item">
                                    <div class="spec-icon">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    <div class="spec-content">
                                        <span class="spec-label">Status</span>
                                        <span class="spec-value text-success">Tersedia</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Quantity Selector & Action Buttons - Hanya untuk user yang login dengan role user -->
                            @auth
                                @if(Auth::user()->isUser())
                                    <div class="quantity-section">
                                        <label class="quantity-label">Jumlah:</label>
                                        <div class="quantity-selector">
                                            <button type="button" class="qty-btn minus" onclick="decreaseQty()">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                            <input type="number" id="quantity" value="1" min="1" max="99" class="qty-input">
                                            <button type="button" class="qty-btn plus" onclick="increaseQty()">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="action-buttons">
                                        <button class="btn-add-cart"
                                            id="addToCartBtn"
                                            data-id="{{ $barang->id }}"
                                            data-name="{{ $barang->nama }}"
                                            data-price="{{ $barang->harga }}"
                                            data-image="{{ $barang->foto ? Storage::url($barang->foto) : asset('images/no-photo.png') }}">
                                            <i class="fas fa-cart-plus"></i>
                                            <span>Tambah ke Keranjang</span>
                                        </button>
                                        <a href="https://wa.me/{{ \App\Models\Setting::where('key', 'nomor_telepon')->value('value') ?? '6280000000000' }}?text={{ urlencode('Halo, saya tertarik dengan produk: ' . $barang->nama . ' (Rp ' . number_format($barang->harga, 0, ',', '.') . '). Apakah masih tersedia?') }}"
                                           class="btn-whatsapp" target="_blank">
                                            <i class="fab fa-whatsapp"></i>
                                            <span>Chat Sekarang</span>
                                        </a>
                                    </div>
                                @else
                                    <div class="action-buttons">
                                        <a href="https://wa.me/{{ \App\Models\Setting::where('key', 'nomor_telepon')->value('value') ?? '6280000000000' }}?text={{ urlencode('Halo, saya tertarik dengan produk: ' . $barang->nama . ' (Rp ' . number_format($barang->harga, 0, ',', '.') . '). Apakah masih tersedia?') }}"
                                           class="btn-whatsapp" target="_blank" style="flex: 1;">
                                            <i class="fab fa-whatsapp"></i>
                                            <span>Chat Sekarang</span>
                                        </a>
                                    </div>
                                @endif
                            @else
                                <div class="action-buttons">
                                    <a href="{{ route('login') }}" class="btn-add-cart" style="text-decoration: none;">
                                        <i class="fas fa-sign-in-alt"></i>
                                        <span>Login untuk Pesan</span>
                                    </a>
                                    <a href="https://wa.me/{{ \App\Models\Setting::where('key', 'nomor_telepon')->value('value') ?? '6280000000000' }}?text={{ urlencode('Halo, saya tertarik dengan produk: ' . $barang->nama . ' (Rp ' . number_format($barang->harga, 0, ',', '.') . '). Apakah masih tersedia?') }}"
                                       class="btn-whatsapp" target="_blank">
                                        <i class="fab fa-whatsapp"></i>
                                        <span>Chat Sekarang</span>
                                    </a>
                                </div>
                            @endauth

                            <!-- Trust Badges -->
                            <div class="trust-badges">
                                <div class="trust-item">
                                    <i class="fas fa-shield-alt"></i>
                                    <span>Produk Original</span>
                                </div>
                                <div class="trust-item">
                                    <i class="fas fa-truck"></i>
                                    <span>Pengiriman Cepat</span>
                                </div>
                                <div class="trust-item">
                                    <i class="fas fa-headset"></i>
                                    <span>Layanan 24/7</span>
                                </div>
                            </div>

                            <!-- Share Section -->
                            <div class="share-section">
                                <span class="share-label">Bagikan Produk:</span>
                                <div class="share-buttons">
                                    <a href="https://wa.me/?text={{ urlencode($barang->nama . ' - Rp ' . number_format($barang->harga, 0, ',', '.') . ' | ' . request()->url()) }}"
                                       class="share-btn share-wa" target="_blank" data-tooltip="WhatsApp">
                                        <i class="fab fa-whatsapp"></i>
                                    </a>
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}"
                                       class="share-btn share-fb" target="_blank" data-tooltip="Facebook">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                    <a href="https://twitter.com/intent/tweet?text={{ urlencode($barang->nama . ' - Rp ' . number_format($barang->harga, 0, ',', '.')) }}&url={{ urlencode(request()->url()) }}"
                                       class="share-btn share-tw" target="_blank" data-tooltip="Twitter">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                    <button class="share-btn share-copy" onclick="copyToClipboard()" data-tooltip="Salin Link">
                                        <i class="fas fa-link"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product Description Tab -->
                @if ($barang->deskripsi)
                <div class="product-description-section">
                    <div class="description-header">
                        <h3><i class="fas fa-file-alt"></i> Deskripsi Produk</h3>
                    </div>
                    <div class="description-content">
                        <p>{{ $barang->deskripsi }}</p>
                    </div>
                </div>
                @endif
            </div>

            <!-- Back Button -->
            <div class="back-navigation">
                <a href="{{ route('katalog') }}" class="back-link">
                    <i class="fas fa-arrow-left"></i>
                    <span>Kembali ke Katalog</span>
                </a>
            </div>
        </div>
    </section>

    <!-- Mobile Sticky Add to Cart - Hanya untuk user yang login dengan role user -->
    @auth
        @if(Auth::user()->isUser())
            <div class="mobile-sticky-cart" id="mobileCart">
                <div class="sticky-price">
                    <span class="sticky-label">Harga</span>
                    <span class="sticky-amount">Rp {{ number_format($barang->harga, 0, ',', '.') }}</span>
                </div>
                <button class="sticky-cart-btn" onclick="addToCartFromSticky()">
                    <i class="fas fa-cart-plus"></i> Keranjang
                </button>
            </div>
        @endif
    @endauth

    <!-- Image Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <button type="button" class="modal-close-btn" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i>
                </button>
                <div class="modal-body p-0">
                    <img src="{{ $barang->foto ? Storage::url($barang->foto) : asset('images/no-photo.png') }}"
                        alt="{{ $barang->nama }}" class="modal-image">
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div class="toast-container" id="toastContainer">
        <div class="custom-toast" id="customToast">
            <div class="toast-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="toast-message" id="toastMessage">Produk ditambahkan ke keranjang!</div>
        </div>
    </div>

    @push('style')
    <style>
        :root {
            --primary: #0CC0DF;
            --primary-dark: #0891b2;
            --primary-light: #e8f8fb;
            --success: #25d366;
            --success-dark: #128c7e;
            --dark: #1a1a2e;
            --gray-100: #f8f9fa;
            --gray-200: #e9ecef;
            --gray-300: #dee2e6;
            --gray-500: #6c757d;
            --gray-700: #495057;
            --shadow-sm: 0 2px 8px rgba(0,0,0,0.08);
            --shadow-md: 0 4px 20px rgba(0,0,0,0.1);
            --shadow-lg: 0 10px 40px rgba(0,0,0,0.12);
            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 20px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Breadcrumb Section */
        .breadcrumb-section {
            background: var(--gray-100);
            padding: 15px 0;
            margin-top: 76px;
            border-bottom: 1px solid var(--gray-200);
        }

        .breadcrumb-section .breadcrumb {
            font-size: 0.85rem;
        }

        .breadcrumb-section .breadcrumb-item a {
            color: var(--gray-500);
            text-decoration: none;
            transition: var(--transition);
        }

        .breadcrumb-section .breadcrumb-item a:hover {
            color: var(--primary);
        }

        .breadcrumb-section .breadcrumb-item.active {
            color: var(--dark);
            font-weight: 500;
        }

        .breadcrumb-section .breadcrumb-item + .breadcrumb-item::before {
            content: "\f054";
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
            font-size: 0.6rem;
            color: var(--gray-300);
        }

        /* Product Detail Section */
        .product-detail-section {
            padding: 40px 0 80px;
            background: linear-gradient(180deg, var(--gray-100) 0%, #fff 100%);
            min-height: calc(100vh - 200px);
        }

        .product-detail-card {
            background: #fff;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-lg);
            overflow: hidden;
            animation: fadeInUp 0.6s ease;
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

        /* Product Gallery */
        .product-gallery {
            padding: 30px;
            background: var(--gray-100);
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .main-image-container {
            position: relative;
            width: 100%;
            border-radius: var(--radius-md);
            overflow: hidden;
            cursor: zoom-in;
            background: #fff;
            box-shadow: var(--shadow-md);
        }

        .main-product-image {
            width: 100%;
            height: 450px;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .main-image-container:hover .main-product-image {
            transform: scale(1.03);
        }

        .image-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.4);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 10px;
            opacity: 0;
            transition: var(--transition);
            color: #fff;
            font-size: 0.9rem;
        }

        .image-overlay i {
            font-size: 2rem;
        }

        .main-image-container:hover .image-overlay {
            opacity: 1;
        }

        .category-ribbon {
            position: absolute;
            top: 20px;
            left: -35px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: #fff;
            padding: 8px 40px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transform: rotate(-45deg);
            box-shadow: 0 2px 10px rgba(12, 192, 223, 0.4);
        }

        .featured-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
            color: #fff;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 5px;
            box-shadow: 0 2px 10px rgba(245, 158, 11, 0.4);
        }

        /* Product Info */
        .product-info {
            padding: 40px;
        }

        .product-meta-top {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 15px;
            flex-wrap: wrap;
        }

        .category-tag {
            background: var(--primary-light);
            color: var(--primary-dark);
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .product-sku {
            color: var(--gray-500);
            font-size: 0.8rem;
            font-family: monospace;
            background: var(--gray-100);
            padding: 4px 10px;
            border-radius: 4px;
        }

        .product-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--dark);
            line-height: 1.3;
            margin-bottom: 20px;
        }

        /* Price Section */
        .price-section {
            margin-bottom: 25px;
        }

        .price-tag {
            display: inline-flex;
            align-items: baseline;
            gap: 4px;
            background: linear-gradient(135deg, var(--primary-light) 0%, #d4f5fa 100%);
            padding: 15px 25px;
            border-radius: var(--radius-md);
            border: 2px solid var(--primary);
        }

        .price-tag .currency {
            font-size: 1rem;
            font-weight: 600;
            color: var(--primary-dark);
        }

        .price-tag .price-amount {
            font-size: 2rem;
            font-weight: 800;
            color: var(--primary);
            letter-spacing: -1px;
        }

        .price-tag .price-unit {
            font-size: 0.9rem;
            color: var(--gray-500);
            margin-left: 5px;
        }

        /* Product Short Description */
        .product-short-desc {
            margin-bottom: 25px;
            padding: 15px 20px;
            background: var(--gray-100);
            border-radius: var(--radius-sm);
            border-left: 4px solid var(--primary);
        }

        .product-short-desc p {
            margin: 0;
            color: var(--gray-700);
            line-height: 1.7;
            font-size: 0.95rem;
        }

        /* Product Specs */
        .product-specs {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-bottom: 25px;
        }

        .spec-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 15px;
            background: var(--gray-100);
            border-radius: var(--radius-sm);
            transition: var(--transition);
        }

        .spec-item:hover {
            background: var(--primary-light);
            transform: translateY(-2px);
        }

        .spec-icon {
            width: 40px;
            height: 40px;
            background: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            font-size: 1rem;
            box-shadow: var(--shadow-sm);
        }

        .spec-content {
            display: flex;
            flex-direction: column;
        }

        .spec-label {
            font-size: 0.7rem;
            color: var(--gray-500);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .spec-value {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--dark);
        }

        /* Quantity Selector */
        .quantity-section {
            margin-bottom: 25px;
        }

        .quantity-label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 10px;
        }

        .quantity-selector {
            display: inline-flex;
            align-items: center;
            background: var(--gray-100);
            border-radius: var(--radius-sm);
            overflow: hidden;
            border: 2px solid var(--gray-200);
        }

        .qty-btn {
            width: 45px;
            height: 45px;
            border: none;
            background: transparent;
            color: var(--gray-700);
            font-size: 1rem;
            cursor: pointer;
            transition: var(--transition);
        }

        .qty-btn:hover {
            background: var(--primary);
            color: #fff;
        }

        .qty-btn:active {
            transform: scale(0.95);
        }

        .qty-input {
            width: 60px;
            height: 45px;
            border: none;
            background: #fff;
            text-align: center;
            font-size: 1rem;
            font-weight: 600;
            color: var(--dark);
            -moz-appearance: textfield;
        }

        .qty-input::-webkit-outer-spin-button,
        .qty-input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 15px;
            margin-bottom: 25px;
        }

        .btn-add-cart, .btn-whatsapp {
            flex: 1;
            padding: 16px 25px;
            border: none;
            border-radius: var(--radius-sm);
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: var(--transition);
            text-decoration: none;
        }

        .btn-add-cart {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: #fff;
            box-shadow: 0 4px 15px rgba(12, 192, 223, 0.4);
        }

        .btn-add-cart:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(12, 192, 223, 0.5);
        }

        .btn-add-cart:active {
            transform: translateY(-1px);
        }

        .btn-add-cart.added {
            background: linear-gradient(135deg, var(--success) 0%, var(--success-dark) 100%);
            box-shadow: 0 4px 15px rgba(37, 211, 102, 0.4);
        }

        .btn-whatsapp {
            background: linear-gradient(135deg, var(--success) 0%, var(--success-dark) 100%);
            color: #fff;
            box-shadow: 0 4px 15px rgba(37, 211, 102, 0.4);
        }

        .btn-whatsapp:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(37, 211, 102, 0.5);
            color: #fff;
        }

        /* Trust Badges */
        .trust-badges {
            display: flex;
            gap: 20px;
            padding: 20px 0;
            border-top: 1px solid var(--gray-200);
            border-bottom: 1px solid var(--gray-200);
            margin-bottom: 20px;
        }

        .trust-item {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--gray-500);
            font-size: 0.8rem;
        }

        .trust-item i {
            color: var(--primary);
            font-size: 1.1rem;
        }

        /* Share Section */
        .share-section {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .share-label {
            font-size: 0.85rem;
            color: var(--gray-500);
        }

        .share-buttons {
            display: flex;
            gap: 8px;
        }

        .share-btn {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 0.9rem;
            border: none;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            position: relative;
        }

        .share-btn::after {
            content: attr(data-tooltip);
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            background: var(--dark);
            color: #fff;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 0.7rem;
            white-space: nowrap;
            opacity: 0;
            visibility: hidden;
            transition: var(--transition);
            margin-bottom: 5px;
        }

        .share-btn:hover::after {
            opacity: 1;
            visibility: visible;
        }

        .share-btn:hover {
            transform: translateY(-3px) scale(1.1);
        }

        .share-wa { background: #25d366; }
        .share-fb { background: #1877f2; }
        .share-tw { background: #1da1f2; }
        .share-copy { background: var(--gray-500); }

        /* Product Description Section */
        .product-description-section {
            border-top: 1px solid var(--gray-200);
            padding: 30px 40px;
        }

        .description-header {
            margin-bottom: 20px;
        }

        .description-header h3 {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--dark);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .description-header h3 i {
            color: var(--primary);
        }

        .description-content {
            color: var(--gray-700);
            line-height: 1.8;
        }

        /* Back Navigation */
        .back-navigation {
            margin-top: 30px;
            text-align: center;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            color: var(--gray-500);
            text-decoration: none;
            font-size: 0.9rem;
            padding: 12px 25px;
            border-radius: 30px;
            transition: var(--transition);
            background: #fff;
            box-shadow: var(--shadow-sm);
        }

        .back-link:hover {
            color: var(--primary);
            box-shadow: var(--shadow-md);
            transform: translateX(-5px);
        }

        /* Mobile Sticky Cart */
        .mobile-sticky-cart {
            display: none;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: #fff;
            padding: 15px 20px;
            box-shadow: 0 -4px 20px rgba(0,0,0,0.1);
            z-index: 1000;
            justify-content: space-between;
            align-items: center;
            transform: translateY(100%);
            transition: transform 0.3s ease;
        }

        .mobile-sticky-cart.show {
            transform: translateY(0);
        }

        .sticky-price {
            display: flex;
            flex-direction: column;
        }

        .sticky-label {
            font-size: 0.7rem;
            color: var(--gray-500);
        }

        .sticky-amount {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--primary);
        }

        .sticky-cart-btn {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: #fff;
            border: none;
            padding: 12px 30px;
            border-radius: var(--radius-sm);
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }

        /* Image Modal */
        #imageModal .modal-content {
            background: transparent;
            border: none;
        }

        .modal-close-btn {
            position: absolute;
            top: -40px;
            right: 0;
            background: #fff;
            border: none;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 10;
            transition: var(--transition);
        }

        .modal-close-btn:hover {
            background: var(--primary);
            color: #fff;
        }

        .modal-image {
            width: 100%;
            border-radius: var(--radius-md);
        }

        /* Toast */
        .toast-container {
            position: fixed;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 9999;
            pointer-events: none;
        }

        .custom-toast {
            background: var(--dark);
            color: #fff;
            padding: 15px 25px;
            border-radius: 50px;
            display: flex;
            align-items: center;
            gap: 12px;
            box-shadow: var(--shadow-lg);
            opacity: 0;
            transform: translateY(20px);
            transition: var(--transition);
        }

        .custom-toast.show {
            opacity: 1;
            transform: translateY(0);
        }

        .toast-icon {
            width: 24px;
            height: 24px;
            background: var(--success);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
        }

        .toast-message {
            font-size: 0.9rem;
            font-weight: 500;
        }

        /* Responsive */
        @media (max-width: 991px) {
            .product-gallery {
                padding: 20px;
            }

            .main-product-image {
                height: 350px;
            }

            .product-info {
                padding: 30px;
            }

            .product-specs {
                grid-template-columns: repeat(2, 1fr);
            }

            .trust-badges {
                flex-wrap: wrap;
            }
        }

        @media (max-width: 768px) {
            .breadcrumb-section {
                margin-top: 60px;
            }

            .product-detail-section {
                padding: 20px 0 100px;
            }

            .product-detail-card {
                border-radius: var(--radius-md);
            }

            .main-product-image {
                height: 300px;
            }

            .product-title {
                font-size: 1.4rem;
            }

            .price-tag .price-amount {
                font-size: 1.6rem;
            }

            .product-specs {
                grid-template-columns: 1fr;
            }

            .action-buttons {
                flex-direction: column;
            }

            .mobile-sticky-cart {
                display: flex;
            }

            .trust-badges {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 10px;
            }

            .trust-item {
                flex-direction: column;
                text-align: center;
                gap: 5px;
            }

            .product-description-section {
                padding: 20px;
            }
        }

        @media (max-width: 576px) {
            .breadcrumb-section {
                margin-top: 56px;
                padding: 10px 0;
            }

            .breadcrumb-section .breadcrumb {
                font-size: 0.75rem;
            }

            .product-gallery {
                padding: 15px;
            }

            .main-product-image {
                height: 250px;
            }

            .category-ribbon {
                display: none;
            }

            .product-info {
                padding: 20px;
            }

            .product-title {
                font-size: 1.2rem;
            }

            .price-tag {
                padding: 12px 18px;
            }

            .price-tag .price-amount {
                font-size: 1.4rem;
            }

            .quantity-selector {
                width: 100%;
                justify-content: center;
            }

            .qty-input {
                flex: 1;
            }

            .share-section {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .custom-toast {
                margin: 0 15px;
                padding: 12px 20px;
            }
        }
    </style>
    @endpush

    @push('script')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Copy link function
        function copyToClipboard() {
            navigator.clipboard.writeText(window.location.href).then(() => {
                showToast('Link berhasil disalin!');
            });
        }

        // Toast notification
        function showToast(message) {
            const toast = document.getElementById('customToast');
            const toastMessage = document.getElementById('toastMessage');

            if (toast && toastMessage) {
                toastMessage.textContent = message;
                toast.classList.add('show');

                setTimeout(() => {
                    toast.classList.remove('show');
                }, 3000);
            }
        }

        @auth
            @if(Auth::user()->isUser())
                // Cart functionality - Hanya untuk user yang login dengan role user
                let cart = JSON.parse(localStorage.getItem('shopping_cart')) || [];

                // Quantity functions
                function increaseQty() {
                    const input = document.getElementById('quantity');
                    if (input && parseInt(input.value) < 99) {
                        input.value = parseInt(input.value) + 1;
                    }
                }

                function decreaseQty() {
                    const input = document.getElementById('quantity');
                    if (input && parseInt(input.value) > 1) {
                        input.value = parseInt(input.value) - 1;
                    }
                }

                // Add to cart
                const addToCartBtn = document.getElementById('addToCartBtn');
                if (addToCartBtn) {
                    addToCartBtn.addEventListener('click', function() {
                        addToCart(this);
                    });
                }

                function addToCartFromSticky() {
                    const btn = document.getElementById('addToCartBtn');
                    if (btn) {
                        addToCart(btn);
                    }
                }

                function addToCart(btn) {
                    const id = btn.dataset.id;
                    const name = btn.dataset.name;
                    const price = parseInt(btn.dataset.price);
                    const image = btn.dataset.image;
                    const quantityInput = document.getElementById('quantity');
                    const quantity = quantityInput ? parseInt(quantityInput.value) : 1;

                    const existingItem = cart.find(item => item.id === id);

                    if (existingItem) {
                        existingItem.quantity += quantity;
                    } else {
                        cart.push({
                            id: id,
                            name: name,
                            price: price,
                            image: image,
                            quantity: quantity
                        });
                    }

                    localStorage.setItem('shopping_cart', JSON.stringify(cart));

                    // Visual feedback
                    btn.innerHTML = '<i class="fas fa-check"></i><span>Ditambahkan!</span>';
                    btn.classList.add('added');

                    showToast('Produk ditambahkan ke keranjang!');

                    setTimeout(() => {
                        btn.innerHTML = '<i class="fas fa-cart-plus"></i><span>Tambah ke Keranjang</span>';
                        btn.classList.remove('added');
                    }, 2000);
                }

                // Mobile sticky cart visibility
                function handleScroll() {
                    const mobileCart = document.getElementById('mobileCart');
                    const actionButtons = document.querySelector('.action-buttons');

                    if (window.innerWidth <= 768 && actionButtons && mobileCart) {
                        const rect = actionButtons.getBoundingClientRect();
                        if (rect.bottom < 0) {
                            mobileCart.classList.add('show');
                        } else {
                            mobileCart.classList.remove('show');
                        }
                    }
                }

                window.addEventListener('scroll', handleScroll);
                window.addEventListener('resize', handleScroll);

                // Initialize
                document.addEventListener('DOMContentLoaded', function() {
                    handleScroll();
                });
            @endif
        @endauth
    </script>
    @endpush
</x-public.app-layout>
