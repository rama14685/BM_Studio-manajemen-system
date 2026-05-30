<x-app-layout>
    <x-slot name="header">
        <h2 class="font-heading text-4xl text-[#0D0D0D] tracking-wider uppercase">
            {{ __('Point of Sale (POS) / Kasir BM Studio') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-[#F4F1EA] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 text-[#0D0D0D]">

            @if(session('error'))
                <div class="bg-[#E14D2A] border-[3px] border-black p-4 shadow-[4px_4px_0px_0px_rgba(13,13,13,1)] text-white font-bold text-sm">
                    ⚠️ ERROR: {{ strtoupper(session('error')) }}
                </div>
            @endif

            <form id="pos-checkout-form" method="POST" action="{{ route('admin.pos.store') }}">
                @csrf
                
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                    
                    <!-- LEFT COLUMN: BOOKING & ITEM SELECTION (7 cols) -->
                    <div class="lg:col-span-7 space-y-6">
                        
                        <!-- 1. Select Booking -->
                        <div class="bg-white border-[3px] border-black p-6 shadow-[5px_5px_0px_0px_rgba(13,13,13,1)]">
                            <h3 class="font-heading text-lg text-black uppercase mb-3 border-b-2 border-black pb-2">1. Pilih Reservasi Booking Studio</h3>
                            
                            <div>
                                <x-input-label for="booking_select" :value="__('Cari Jadwal Booking')" class="text-black font-bold text-xs" />
                                <select id="booking_select" name="booking_id" class="mt-1 block w-full border-[3px] border-[#0D0D0D] bg-white text-black focus:border-[#FFC700] focus:ring-0 rounded-none shadow-[3px_3px_0px_0px_rgba(13,13,13,1)]">
                                    <option value="" data-price="0">-- Tanpa Booking (Hanya Beli Minuman) --</option>
                                    @foreach($bookings as $b)
                                        <option value="{{ $b->id }}" data-price="{{ $b->status === 'dp' ? ($b->total_price - $b->dp_amount) : $b->total_price }}" data-user="{{ $b->user->name }}" data-studio="{{ $b->studio->name }}">
                                            Booking #{{ $b->id }} - {{ $b->user->name }} ({{ $b->studio->name }} | {{ Carbon\Carbon::parse($b->date)->format('d M') }} | {{ $b->status === 'dp' ? 'Sisa Rp. ' . number_format($b->total_price - $b->dp_amount, 0, ',', '.') : 'Rp. ' . number_format($b->total_price, 0, ',', '.') }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- 2. Select Drinks -->
                        <div class="bg-white border-[3px] border-black p-6 shadow-[5px_5px_0px_0px_rgba(13,13,13,1)]">
                            <h3 class="font-heading text-lg text-black uppercase mb-3 border-b-2 border-black pb-2">2. Tambah Pembelian Minuman</h3>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                @foreach($drinks as $drink)
                                    <div class="p-4 bg-[#F4F1EA] border-[3px] border-black rounded-none flex items-center justify-between hover:border-[#E14D2A] transition-all duration-150 shadow-[3px_3px_0px_0px_rgba(13,13,13,1)] hover:shadow-none hover:translate-x-0.5 hover:translate-y-0.5">
                                        <div>
                                            <h4 class="font-heading text-sm text-[#0D0D0D]">{{ $drink->name }}</h4>
                                            <p class="text-xs text-[#E14D2A] font-bold mt-0.5">Rp. {{ number_format($drink->price, 0, ',', '.') }}</p>
                                            <span class="text-[10px] text-zinc-500 font-bold">Stok: {{ $drink->stock_qty }} botol</span>
                                        </div>
                                        <div>
                                            <button type="button" 
                                                data-id="{{ $drink->id }}" 
                                                data-name="{{ $drink->name }}" 
                                                data-price="{{ $drink->price }}" 
                                                data-stock="{{ $drink->stock_qty }}" 
                                                class="add-drink-btn inline-flex items-center px-4 py-2 bg-[#FFC700] border-2 border-black text-black text-xs font-heading uppercase tracking-wider transition shadow-[2px_2px_0px_0px_rgba(13,13,13,1)] hover:shadow-none hover:translate-x-0.5 hover:translate-y-0.5">
                                                ADD
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- RIGHT COLUMN: SHOPPING CART & SUMMARY (5 cols) -->
                    <div class="lg:col-span-5">
                        <div class="bg-[#FFC700] border-[3px] border-black p-6 shadow-[6px_6px_0px_0px_rgba(13,13,13,1)] sticky top-6 space-y-6">
                            
                            <div>
                                <h3 class="font-heading text-xl text-black border-b-[2px] border-black pb-2 uppercase flex items-center">
                                    🛒 Ringkasan Pembayaran
                                </h3>
                            </div>

                            <!-- Cart Items Display -->
                            <div class="space-y-4 min-h-[150px] border-b-[2px] border-black pb-4">
                                
                                <!-- Studio Booking Row -->
                                <div id="booking-cart-row" class="hidden justify-between items-center text-sm p-3 bg-white border-2 border-black shadow-[2px_2px_0px_0px_rgba(13,13,13,1)]">
                                    <div>
                                        <h4 id="booking-cart-title" class="font-heading text-sm text-[#0D0D0D]">Sewa Studio</h4>
                                        <p id="booking-cart-detail" class="text-xs text-zinc-650 font-bold"></p>
                                    </div>
                                    <span id="booking-cart-price" class="font-heading text-[#0D0D0D]">Rp 0</span>
                                </div>

                                <!-- Drinks Cart Table -->
                                <div id="drinks-cart-container" class="space-y-2">
                                    <!-- Dynamic rows will be inserted here -->
                                    <p id="empty-cart-text" class="text-center text-black font-bold text-xs py-8">[ KARTU BELANJA MINUMAN KOSONG ]</p>
                                </div>

                            </div>

                            <!-- Payment Options -->
                            <div class="space-y-3">
                                <div>
                                    <x-input-label for="payment_method" :value="__('Metode Pembayaran')" class="text-black font-bold text-xs" />
                                    <select id="payment_method" name="payment_method" class="mt-1 block w-full border-[3px] border-[#0D0D0D] bg-white text-black focus:border-[#E14D2A] focus:ring-0 rounded-none shadow-[3px_3px_0px_0px_rgba(13,13,13,1)]" required>
                                        <option value="Cash">Cash / Tunai</option>
                                        <option value="Transfer">Transfer Bank / QRIS</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Price Calculation -->
                            <div class="space-y-2 text-sm pt-2 font-bold">
                                <div class="flex justify-between">
                                    <span class="text-zinc-700">Subtotal Sewa Studio:</span>
                                    <span id="summary-booking-total" class="text-[#0D0D0D]">Rp 0</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-zinc-700">Subtotal Minuman:</span>
                                    <span id="summary-drinks-total" class="text-[#0D0D0D]">Rp 0</span>
                                </div>
                                <div class="flex justify-between border-t-[2px] border-black pt-3 text-lg font-heading">
                                    <span class="text-black">GRAND TOTAL:</span>
                                    <span id="summary-grand-total" class="text-[#E14D2A] drop-shadow-[1px_1px_0px_white]">Rp 0</span>
                                </div>
                            </div>

                            <!-- Checkout Submit Button -->
                            <div>
                                <button type="submit" class="w-full inline-flex justify-center items-center py-4 bg-[#E14D2A] border-[3px] border-black text-white font-heading text-sm uppercase tracking-widest shadow-[4px_4px_0px_0px_rgba(13,13,13,1)] hover:shadow-none hover:translate-x-1 hover:translate-y-1 transition-all">
                                    BAYAR & CETAK STRUK
                                </button>
                            </div>

                        </div>
                    </div>

                </div>
            </form>

        </div>
    </div>

    <!-- Client-Side POS Logic -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const bookingSelect = document.getElementById('booking_select');
            const addDrinkButtons = document.querySelectorAll('.add-drink-btn');
            
            const bookingRow = document.getElementById('booking-cart-row');
            const bookingTitle = document.getElementById('booking-cart-title');
            const bookingDetail = document.getElementById('booking-cart-detail');
            const bookingPriceDisplay = document.getElementById('booking-cart-price');
            
            const drinksContainer = document.getElementById('drinks-cart-container');
            const emptyCartText = document.getElementById('empty-cart-text');
            
            const summaryBookingTotal = document.getElementById('summary-booking-total');
            const summaryDrinksTotal = document.getElementById('summary-drinks-total');
            const summaryGrandTotal = document.getElementById('summary-grand-total');

            let cart = {}; // key: inventory_id, value: { name, price, qty, stock }
            let bookingPrice = 0;

            function formatIDR(amount) {
                return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0
                }).format(amount);
            }

            function updateBookingRow() {
                const opt = bookingSelect.options[bookingSelect.selectedIndex];
                bookingPrice = parseFloat(opt.getAttribute('data-price')) || 0;
                
                if (bookingPrice > 0) {
                    bookingRow.style.display = 'flex';
                    bookingTitle.textContent = opt.getAttribute('data-studio');
                    bookingDetail.textContent = `Penyewa: ${opt.getAttribute('data-user')}`;
                    bookingPriceDisplay.textContent = formatIDR(bookingPrice);
                } else {
                    bookingRow.style.display = 'none';
                }
                updateTotals();
            }

            function updateTotals() {
                let drinksTotal = 0;
                for (let key in cart) {
                    drinksTotal += cart[key].price * cart[key].qty;
                }

                const grandTotal = bookingPrice + drinksTotal;

                summaryBookingTotal.textContent = formatIDR(bookingPrice);
                summaryDrinksTotal.textContent = formatIDR(drinksTotal);
                summaryGrandTotal.textContent = formatIDR(grandTotal);
            }

            function renderCart() {
                const keys = Object.keys(cart);
                
                if (keys.length === 0) {
                    emptyCartText.style.display = 'block';
                    const oldInputs = drinksContainer.querySelectorAll('.cart-item-input');
                    oldInputs.forEach(i => i.remove());
                } else {
                    emptyCartText.style.display = 'none';
                }

                const rows = drinksContainer.querySelectorAll('.cart-row');
                rows.forEach(r => r.remove());

                keys.forEach((key, index) => {
                    const item = cart[key];
                    const subtotal = item.price * item.qty;
                    const rowHtml = `
                        <div class="cart-row flex items-center justify-between p-3 border-2 border-black bg-white text-xs shadow-[2px_2px_0px_0px_rgba(13,13,13,1)]">
                            <div class="flex-1 min-w-0 pr-2">
                                <h4 class="font-bold text-gray-800 truncate">${item.name}</h4>
                                <span class="text-[10px] text-zinc-500 font-mono">${formatIDR(item.price)}</span>
                            </div>
                            
                            <!-- Qty counter -->
                            <div class="flex items-center space-x-1 mr-4">
                                <button type="button" class="qty-btn-minus w-5 h-5 border border-black bg-[#F4F1EA] font-bold text-xs" data-id="${key}">-</button>
                                <span class="font-mono font-bold w-4 text-center text-sm">${item.qty}</span>
                                <button type="button" class="qty-btn-plus w-5 h-5 border border-black bg-[#F4F1EA] font-bold text-xs" data-id="${key}">+</button>
                            </div>

                            <div class="text-right pr-3 font-bold w-24">
                                ${formatIDR(subtotal)}
                            </div>

                            <button type="button" class="remove-btn text-[#E14D2A] hover:text-black font-extrabold text-base" data-id="${key}">&times;</button>
                            
                            <input type="hidden" name="items[${index}][inventory_id]" value="${key}">
                            <input type="hidden" name="items[${index}][qty]" value="${item.qty}">
                        </div>
                    `;
                    drinksContainer.insertAdjacentHTML('beforeend', rowHtml);
                });

                bindCartRowEvents();
                updateTotals();
            }

            function bindCartRowEvents() {
                drinksContainer.querySelectorAll('.qty-btn-minus').forEach(btn => {
                    btn.onclick = function() {
                        const id = this.getAttribute('data-id');
                        if (cart[id].qty > 1) {
                            cart[id].qty--;
                        } else {
                            delete cart[id];
                        }
                        renderCart();
                    }
                });

                drinksContainer.querySelectorAll('.qty-btn-plus').forEach(btn => {
                    btn.onclick = function() {
                        const id = this.getAttribute('data-id');
                        if (cart[id].qty < cart[id].stock) {
                            cart[id].qty++;
                        } else {
                            alert(`Stok maksimal ${cart[id].stock} botol.`);
                        }
                        renderCart();
                    }
                });

                drinksContainer.querySelectorAll('.remove-btn').forEach(btn => {
                    btn.onclick = function() {
                        const id = this.getAttribute('data-id');
                        delete cart[id];
                        renderCart();
                    }
                });
            }

            addDrinkButtons.forEach(btn => {
                btn.onclick = function() {
                    const id = this.getAttribute('data-id');
                    const name = this.getAttribute('data-name');
                    const price = parseFloat(this.getAttribute('data-price'));
                    const stock = parseInt(this.getAttribute('data-stock'));

                    if (cart[id]) {
                        if (cart[id].qty < stock) {
                            cart[id].qty++;
                        } else {
                            alert(`Stok maksimal ${stock} botol.`);
                        }
                    } else {
                        cart[id] = { name, price, qty: 1, stock };
                    }
                    renderCart();
                }
            });

            bookingSelect.addEventListener('change', updateBookingRow);

            updateBookingRow();
            renderCart();
        });
    </script>
</x-app-layout>
