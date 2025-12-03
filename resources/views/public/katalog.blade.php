<x-public.app-layout>

    <!-- Header Section -->
    <section class="page-header">
        <div class="container">
            <nav aria-label="breadcrumb" class="breadcrumb-custom">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('landing_page') }}">Beranda</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Katalog Produk</li>
                </ol>
            </nav>
            <h1 class="page-title">Katalog Produk</h1>
            <p class="lead">Temukan berbagai sarana produksi pertanian terbaik untuk kebutuhan Anda</p>

            <!-- Search Bar -->
            <form action="{{ route('katalog') }}" method="GET" class="search-form mt-4">
                <div class="input-group input-group-lg search-input-group">
                    <span class="input-group-text bg-white border-0">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="text" name="search" class="form-control border-0"
                        placeholder="Cari produk..." value="{{ request('search') }}">
                    <button class="btn btn-light px-4" type="submit">
                        Cari
                    </button>
                </div>
            </form>
        </div>
    </section>

    <!-- Cart Floating Button - Hanya untuk user yang login dengan role user -->
    @auth
        @if(Auth::user()->isUser())
            <div class="cart-floating-btn" id="cartFloatingBtn" style="display: none;">
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#cartModal">
                    <i class="fas fa-shopping-cart me-2"></i>
                    <span id="cartCount">0</span> Item
                </button>
            </div>
        @endif
    @endauth

    <!-- Products Section -->
    <section class="product-grid">
        <div class="container">

            <!-- Product Count -->
            @if ($barangs->count() > 0)
                <div class="product-count">
                    Menampilkan {{ $barangs->count() }} produk
                    @if (request('search'))
                        untuk pencarian "{{ request('search') }}"
                    @endif
                </div>
            @endif

            <!-- Products Grid -->
            @if ($barangs->count() > 0)
                <div class="row g-2 g-sm-3 g-md-4">
                    @foreach ($barangs as $barang)
                        <div class="col-6 col-md-4 col-lg-3 d-flex">
                            <div class="card product-card w-100 d-flex flex-column">
                                <div class="product-image">
                                    <img src="{{ $barang->foto ? Storage::url($barang->foto) : asset('images/no-photo.png') }}"
                                        alt="{{ $barang->nama }}" class="img-fluid">
                                </div>
                                <div class="product-info mt-auto p-3">
                                    <h5 class="product-title">{{ $barang->nama }}</h5>
                                    <p class="card-text">{{ Str::limit($barang->detail, 50) }}</p>
                                    <div class="product-price">
                                        {{ 'Rp ' . number_format($barang->harga, 0, ',', '.') }}
                                    </div>

                                    @if ($barang->deskripsi)
                                        <p class="product-description">
                                            {{ Str::limit($barang->deskripsi, 80) }}
                                        </p>
                                    @endif

                                    @if (isset($barang->stok))
                                        @if ($barang->stok > 10)
                                            <span class="stock-badge stock-available">
                                                <i class="fas fa-check-circle me-1"></i>Tersedia
                                            </span>
                                        @elseif($barang->stok > 0)
                                            <span class="stock-badge stock-low">
                                                <i class="fas fa-exclamation-triangle me-1"></i>Stok Terbatas
                                            </span>
                                        @else
                                            <span class="stock-badge stock-out">
                                                <i class="fas fa-times-circle me-1"></i>Habis
                                            </span>
                                        @endif
                                    @endif

                                    <!-- Tombol Keranjang - Hanya untuk user yang login dengan role user -->
                                    @auth
                                        @if(Auth::user()->isUser())
                                            @if (!isset($barang->stok) || $barang->stok > 0)
                                                <button class="btn btn-primary add-to-cart-btn mt-2 w-100"
                                                    data-id="{{ $barang->id }}" data-name="{{ $barang->nama }}"
                                                    data-price="{{ $barang->harga }}"
                                                    data-image="{{ $barang->foto ? Storage::url($barang->foto) : asset('images/no-photo.png') }}">
                                                    <i class="fas fa-cart-plus me-2"></i>Tambah ke Keranjang
                                                </button>
                                            @else
                                                <button class="btn btn-secondary mt-2 w-100" disabled>
                                                    <i class="fas fa-ban me-2"></i>Stok Habis
                                                </button>
                                            @endif
                                        @endif
                                    @else
                                        <a href="{{ route('login') }}" class="btn btn-outline-primary mt-2 w-100">
                                            <i class="fas fa-sign-in-alt me-2"></i>Login untuk Pesan
                                        </a>
                                    @endauth

                                    <!-- ✅ Tombol Lihat Detail -->
                                    <a href="{{ route('produk.show', $barang->id) }}"
                                        class="btn btn-outline-info mt-2 w-100">
                                        <i class="fas fa-eye me-2"></i>Lihat Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>


                <!-- Pagination -->
                @if ($barangs->hasPages())
                    <div class="pagination-wrapper">
                        {{ $barangs->appends(request()->query())->links() }}
                    </div>
                @endif
            @else
                <!-- No Products Found -->
                <div class="no-products">
                    <i class="fas fa-search"></i>
                    <h4>Produk Tidak Ditemukan</h4>
                    <p>
                        @if (request('search'))
                            Maaf, tidak ada produk yang sesuai dengan pencarian "{{ request('search') }}"
                        @else
                            Saat ini belum ada produk yang tersedia
                        @endif
                    </p>
                    @if (request('search'))
                        <a href="{{ route('katalog') }}" class="btn btn-primary mt-3">
                            <i class="fas fa-th-large me-2"></i>Lihat Semua Produk
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </section>

    <!-- Cart Modal - Hanya untuk user yang login dengan role user -->
    @auth
        @if(Auth::user()->isUser())
            <div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="cartModalLabel">
                                <i class="fas fa-shopping-cart me-2"></i>Keranjang Belanja
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div id="cartItems"></div>
                            <div id="emptyCart" style="display: none;">
                                <div class="text-center py-4">
                                    <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                                    <h5>Keranjang Kosong</h5>
                                    <p class="text-muted">Silakan tambahkan produk ke keranjang terlebih dahulu</p>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="d-flex justify-content-between align-items-center w-100">
                                <div>
                                    <strong>Total: <span id="cartTotal">Rp 0</span></strong>
                                </div>
                                <div>
                                    <button type="button" class="btn btn-secondary me-2" onclick="clearCart()">
                                        <i class="fas fa-trash me-2"></i>Kosongkan
                                    </button>
                                    <button type="button" class="btn btn-success" onclick="sendToWhatsApp()" id="whatsappBtn">
                                        <i class="fab fa-whatsapp me-2"></i>Pesan via WhatsApp
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endauth

    @push('styles')
        <style>
            /* Search Bar Styles */
            .search-form {
                max-width: 600px;
                margin: 0 auto;
            }

            .search-input-group {
                border-radius: 50px;
                overflow: hidden;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            }

            .search-input-group .form-control {
                padding: 15px 5px;
            }

            .search-input-group .form-control:focus {
                box-shadow: none;
            }

            .search-input-group .btn {
                border-radius: 0 50px 50px 0 !important;
                font-weight: 600;
            }

            /* Product Card Enhancements */
            .product-card {
                transition: all 0.3s ease;
            }

            .product-card:hover {
                transform: translateY(-5px);
            }

            /* Cart Floating Button */
            .cart-floating-btn {
                position: fixed;
                bottom: 20px;
                right: 20px;
                z-index: 1000;
                animation: bounce 2s infinite;
            }

            .cart-floating-btn .btn {
                border-radius: 50px;
                padding: 12px 20px;
                font-weight: 600;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            }

            @keyframes bounce {
                0%, 20%, 50%, 80%, 100% {
                    transform: translateY(0);
                }
                40% {
                    transform: translateY(-10px);
                }
                60% {
                    transform: translateY(-5px);
                }
            }

            .add-to-cart-btn {
                transition: all 0.3s ease;
            }

            .add-to-cart-btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            }

            .cart-item {
                border: 1px solid #e9ecef;
                border-radius: 8px;
                padding: 15px;
                margin-bottom: 15px;
                background: #f8f9fa;
            }

            .cart-item img {
                width: 60px;
                height: 60px;
                object-fit: cover;
                border-radius: 8px;
            }

            .quantity-controls {
                display: flex;
                align-items: center;
                gap: 10px;
            }

            .quantity-controls button {
                width: 32px;
                height: 32px;
                border-radius: 50%;
                border: 1px solid #ddd;
                background: white;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .quantity-controls input {
                width: 60px;
                text-align: center;
                border: 1px solid #ddd;
                border-radius: 4px;
                padding: 5px;
            }

            .btn-success {
                background: linear-gradient(45deg, #25d366, #128c7e);
                border: none;
            }

            .btn-success:hover {
                background: linear-gradient(45deg, #128c7e, #25d366);
            }

            /* Responsive Search */
            @media (max-width: 576px) {
                .search-input-group {
                    flex-direction: row;
                }

                .search-input-group .form-control {
                    padding: 12px 5px;
                    font-size: 0.9rem;
                }

                .search-input-group .btn {
                    padding: 10px 15px;
                    font-size: 0.85rem;
                }
            }
        </style>
    @endpush

    @push('script')
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            // Cart functionality
            let cart = JSON.parse(localStorage.getItem('shopping_cart')) || [];
            const whatsappNumber =
                '{{ \App\Models\Setting::where('key', 'nomor_telepon')->value('value') ?? '6280000000000' }}';

            // Initialize cart display
            document.addEventListener('DOMContentLoaded', function() {
                updateCartDisplay();
                updateFloatingButton();
            });

            // Add to cart function
            document.querySelectorAll('.add-to-cart-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.dataset.id;
                    const name = this.dataset.name;
                    const price = parseInt(this.dataset.price);
                    const image = this.dataset.image;

                    addToCart(id, name, price, image);

                    // Visual feedback
                    this.innerHTML = '<i class="fas fa-check me-2"></i>Ditambahkan!';
                    this.classList.add('btn-success');
                    this.classList.remove('btn-primary');

                    setTimeout(() => {
                        this.innerHTML = '<i class="fas fa-cart-plus me-2"></i>Tambah ke Keranjang';
                        this.classList.add('btn-primary');
                        this.classList.remove('btn-success');
                    }, 1500);
                });
            });

            function addToCart(id, name, price, image) {
                const existingItem = cart.find(item => item.id === id);

                if (existingItem) {
                    existingItem.quantity += 1;
                } else {
                    cart.push({
                        id: id,
                        name: name,
                        price: price,
                        image: image,
                        quantity: 1
                    });
                }

                saveCart();
                updateCartDisplay();
                updateFloatingButton();
            }

            function removeFromCart(id) {
                cart = cart.filter(item => item.id !== id);
                saveCart();
                updateCartDisplay();
                updateFloatingButton();
            }

            function updateQuantity(id, quantity) {
                const item = cart.find(item => item.id === id);
                if (item) {
                    if (quantity <= 0) {
                        removeFromCart(id);
                    } else {
                        item.quantity = quantity;
                        saveCart();
                        updateCartDisplay();
                        updateFloatingButton();
                    }
                }
            }

            function clearCart() {
                if (confirm('Apakah Anda yakin ingin mengosongkan keranjang?')) {
                    cart = [];
                    saveCart();
                    updateCartDisplay();
                    updateFloatingButton();
                }
            }

            function saveCart() {
                localStorage.setItem('shopping_cart', JSON.stringify(cart));
            }

            function updateCartDisplay() {
                const cartItems = document.getElementById('cartItems');
                const emptyCart = document.getElementById('emptyCart');
                const cartTotal = document.getElementById('cartTotal');
                const whatsappBtn = document.getElementById('whatsappBtn');

                if (cart.length === 0) {
                    cartItems.style.display = 'none';
                    emptyCart.style.display = 'block';
                    cartTotal.textContent = 'Rp 0';
                    whatsappBtn.disabled = true;
                    return;
                }

                cartItems.style.display = 'block';
                emptyCart.style.display = 'none';
                whatsappBtn.disabled = false;

                let total = 0;
                let html = '';

                cart.forEach(item => {
                    const itemTotal = item.price * item.quantity;
                    total += itemTotal;

                    html += `
            <div class="cart-item border-bottom py-3">
                <div class="row align-items-center g-2">
                    <div class="col-3 col-md-2">
                        <img src="${item.image}" alt="${item.name}" class="img-fluid rounded shadow-sm">
                    </div>
                    <div class="col-9 col-md-4">
                        <h6 class="mb-1 fw-bold" style="font-size: 0.9rem;">${item.name}</h6>
                        <span class="text-muted small d-block">Rp ${item.price.toLocaleString('id-ID')}</span>
                        <span class="text-primary small fw-bold d-md-none">Subtotal: Rp ${itemTotal.toLocaleString('id-ID')}</span>
                    </div>
                    <div class="col-8 col-md-3 mt-2 mt-md-0">
                        <div class="input-group input-group-sm quantity-controls">
                            <button class="btn btn-outline-secondary" type="button"
                                onclick="updateQuantity('${item.id}', ${item.quantity - 1})">
                                <i class="fas fa-minus"></i>
                            </button>
                            <input type="number" class="form-control text-center" style="max-width: 50px"
                                value="${item.quantity}" min="1"
                                onchange="updateQuantity('${item.id}', parseInt(this.value))">
                            <button class="btn btn-outline-secondary" type="button"
                                onclick="updateQuantity('${item.id}', ${item.quantity + 1})">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-2 col-md-2 text-end fw-bold d-none d-md-block">
                        Rp ${itemTotal.toLocaleString('id-ID')}
                    </div>
                    <div class="col-4 col-md-1 text-end mt-2 mt-md-0">
                        <button class="btn btn-sm btn-outline-danger" onclick="removeFromCart('${item.id}')"
                                title="Hapus item">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
                });

                cartItems.innerHTML = html;
                cartTotal.textContent = `Rp ${total.toLocaleString('id-ID')}`;
            }


            function updateFloatingButton() {
                const floatingBtn = document.getElementById('cartFloatingBtn');
                const cartCount = document.getElementById('cartCount');

                const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);

                if (totalItems > 0) {
                    floatingBtn.style.display = 'block';
                    cartCount.textContent = totalItems;
                } else {
                    floatingBtn.style.display = 'none';
                }
            }

            function sendToWhatsApp() {
                if (cart.length === 0) {
                    alert('Keranjang kosong!');
                    return;
                }

                let message = 'Halo, saya ingin bertanya tentang ketersediaan produk berikut:\n\n';
                message += '📋 *DAFTAR PESANAN:*\n';

                let total = 0;
                cart.forEach((item, index) => {
                    const itemTotal = item.price * item.quantity;
                    total += itemTotal;
                    message += `${index + 1}. ${item.name}\n`;
                    message += `   Jumlah: ${item.quantity}\n`;
                    message += `   Harga: Rp ${item.price.toLocaleString('id-ID')}\n`;
                    message += `   Subtotal: Rp ${itemTotal.toLocaleString('id-ID')}\n\n`;
                });

                message += `💰 *TOTAL: Rp ${total.toLocaleString('id-ID')}*\n\n`;
                message += 'Apakah semua produk ini tersedia? Terima kasih.';

                const encodedMessage = encodeURIComponent(message);
                const whatsappUrl = `https://wa.me/${whatsappNumber}?text=${encodedMessage}`;

                window.open(whatsappUrl, '_blank');
            }
        </script>
    @endpush

</x-public.app-layout>
