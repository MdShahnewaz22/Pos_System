<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pos System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap CSS (if not already included) -->
    <!-- Bootstrap JS & Popper.js (needed for the close button) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>

    <style>
        body {
            background-color: #dfe4eb;
        }

        .product-grid {
            max-height: 85vh;
            overflow-y: auto;
            padding-right: 10px;
        }

        .card-img-top {
            height: 100px;
            object-fit: contain;
            cursor: pointer;
        }

        .card-title {
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 5px;
        }

        .price-tag {
            font-size: 13px;
        }

        .checkout-card {
            position: sticky;
            top: 20px;
        }

        .cart-item {
            border-bottom: 1px solid #eee;
            padding: 10px 0;
        }

        .quantity-control {
            display: flex;
            align-items: center;
        }

        .quantity-input {
            width: 50px;
            text-align: center;
            margin: 0 5px;
        }
    </style>
</head>


<body>
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="container-fluid">
        <div class="row">

            <!-- Product Grid -->
            <div class="col-md-9">
                <form action="{{ route('frontend.product.search') }}" method="GET">
                    <div class="mb-2 mt-2">
                        <input type="text" name="search" class="form-control" placeholder="Search product by name"
                            value="{{ request('search') }}">
                    </div>
                </form>


                <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-6 g-3 product-grid">
                    {{-- @dd($products); --}}
                    @if ($products->isEmpty())
                    <div class="alert alert-warning">
                        No products found for "{{ $searchTerm }}"
                    </div>
                    @else
                    @foreach ($products as $item)
                    <form action="{{ url('add-to-cart') }}" method="POST">
                        @csrf
                        <div class="col">
                            <div class="card h-100 shadow-sm">
                                <a href="{{ url('/productdetail/' . $item->id) }}">
                                    <img style="height: 120px; width: 170px;"
                                        src="{{ $item->productDetail->image }}" alt="Product Image">
                                </a>

                                <div class="card-body text-center p-2 d-flex flex-column">
                                    <div class="card-title text-truncate">{{ $item->name }}</div>
                                    

                                    <div class="price-tag mt-1 mb-2">
                                        <span class="text-success fw-bold">
                                            ৳{{ $item->productDetail->total_price }}</span>
                                        <span
                                            class="text-muted text-decoration-line-through small">৳{{ $item->productDetail->discount }}

                                        </span>
                                    </div>

                                    <input type="hidden" name="product_id" value="{{ $item->id }}">
                                    <input type="hidden" name="product_name" value="{{ $item->name }}">
                                    <input type="hidden" name="price"
                                        value="{{ $item->productDetail->total_price }}">
                                    <input type="hidden" name="image"
                                        value="{{ $item->productDetail->image }}">


                                    <div class="mt-auto">
                                        <button class="btn btn-sm btn-outline-success w-100" style="">Add
                                            to cart</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </form>
                    @endforeach
                    @endif
                </div>
            </div>




            <!-- Cart Section -->
            <div class="col-md-3">
                <a href="{{ url('/') }}">
                    <button class="mt-3 bg-blue-500  hover:bg-blue-500  text-white font-bold py-2 px-4 rounded">
                        Back
                    </button>
                </a>

                <div class="mt-2 card checkout-card shadow">

                    <div class="card-header text-white" style="background-color:rgb(63, 215, 108);">
                        <h5 class="mb-0">Billing Section</h5>
                    </div>
                    <div class="card-body">
                        <div style="max-height: 400px; overflow-y: auto;">
                            @php
                            $cart = session('cart', []);
                            $totalItems = 0;
                            $subtotal = 0;
                            @endphp

                            @forelse($cart as $id => $item)
                            @php
                            $totalItems += $item['quantity'];
                            $subtotal += $item['price'] * $item['quantity'];
                            @endphp
                            <div class="cart-item mb-2 border-bottom pb-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="me-3" style="width: 80px;">
                                        <img src="{{ $item['image'] }}" alt="Product" class="img-fluid rounded">
                                    </div>
                                    <div>
                                        <strong>{{ $item['name'] }}</strong>
                                        <div>৳{{ $item['price'] }}</div>
                                    </div>
                                    <div class="quantity-control d-flex align-items-center gap-1">
                                        <button type="button"
                                            class="btn btn-sm btn-outline-secondary btn-decrement"
                                            data-id="{{ $id }}">-</button>
                                        <input type="number" class="form-control form-control-sm quantity-input"
                                            value="{{ $item['quantity'] }}" disabled>
                                        <button type="button"
                                            class="btn btn-sm btn-outline-secondary btn-increment"
                                            data-id="{{ $id }}">+</button>
                                    </div>

                                </div>
                                <div class="text-end mt-1 d-flex justify-content-between align-items-center">
                                    <strong>৳{{ $item['price'] * $item['quantity'] }}</strong>
                                    <form action="{{ url('cart/remove') }}" method="POST" class="ms-2">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $id }}">
                                        <button class="btn btn-sm btn-danger" title="Remove item">×</button>
                                    </form>
                                </div>
                            </div>
                            @empty
                            <p class="text-muted">Your cart is empty.</p>
                            @endforelse
                        </div>

                        <div class="mt-3">
                            <div class="d-flex justify-content-between">
                                <strong>Total Items:</strong>
                                <span>{{ $totalItems }}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <strong>Subtotal:</strong>
                                <span>৳{{ number_format($subtotal, 2) }}</span>
                            </div>
                        </div>

                        <h6 class="mt-4">Shipping Details</h6>
                        <form action="{{ route('frontend.order.store') }}" method="post">
                            @csrf
                            <input type="hidden" class="form-control" name="subtotal" value="{{ $subtotal }}">
                            <div class="mb-2">
                                <input type="text" class="form-control" placeholder="Full Name" name="name">
                            </div>
                            <div class="mb-2">
                                <textarea class="form-control" rows="2" placeholder="Address" name="address"></textarea>
                            </div>
                            {{-- <div class="mb-3">
                                <select class="form-select" >
                                    <option selected>Select Payment</option>
                                </select>
                            </div> --}}
                            <div class="mb-3">

                                <select class="form-select" id="paymentMethod" name="payment_status">
                                    <option selected disabled>Select Payment</option>
                                    <option value="cash_on_delivery">Cash on Delivery</option>
                                    <option value="credit_card">Credit / Debit Card</option>
                                    <option value="bank_transfer">Bank Transfer</option>
                                    <option value="paypal">PayPal</option>
                                    <option value="mobile_payment">Mobile Payment (Bkash, Paytm, etc.)</option>
                                </select>

                            </div>
                            <a href="{{ url('/shippingdetail') }}">
                                <button class="btn btn-success w-100">Place Order</button>
                            </a>

                        </form>
                    </div>
                </div>
            </div>










            {{-- <!-- Cart Section -->
            <div class="col-md-3">
                <div class="mt-2 card checkout-card shadow">
                    <div class="card-header text-white" style="background-color:rgb(63, 215, 108);">
                        <h5 class="mb-0">Billing Section</h5>
                    </div>
                    <div class="card-body">
                        <div style="max-height: 400px; overflow-y: auto;">
                            <div class="cart-item">
                                <div class="d-flex justify-content-between">
                                    <div class="me-3" style="width: 80px;">
                                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSYi1C2_l30-1V3GjBIsQEvOPgm6ndBZ_T3AysUnc_tz8o-BVnvy0YhPdo&s"
                                            alt="Product" class="img-fluid rounded">
                                    </div>
                                    <div>
                                        <strong>Product A</strong>
                                        <div>৳10.00</div>
                                    </div>
                                    <div class="quantity-control">
                                        <button class="btn btn-sm btn-outline-secondary" disabled>-</button>
                                        <input type="number" class="form-control form-control-sm quantity-input"
                                            value="1" disabled>
                                        <button class="btn btn-sm btn-outline-secondary" disabled>+</button>
                                    </div>
                                </div>
                                <div class="text-end mt-1">
                                    <strong>৳10.00</strong>
                                    <button class="btn btn-sm btn-danger ms-2" disabled>×</button>
                                </div>
                            </div>

                            <p class="text-muted mt-2">Add more static cart items here...</p>
                        </div>

                        <div class="mt-3">
                            <div class="d-flex justify-content-between">
                                <strong>Total Items:</strong>
                                <span>1</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <strong>Subtotal:</strong>
                                <span>৳10.00</span>
                            </div>
                        </div>

                        <h6 class="mt-4">Shipping Details</h6>
                        <form>
                            <div class="mb-2">
                                <input type="text" class="form-control" placeholder="Full Name" disabled>
                            </div>
                            <div class="mb-2">
                                <textarea class="form-control" rows="2" placeholder="Address" disabled></textarea>
                            </div>
                            <div class="mb-3">
                                <select class="form-select" disabled>
                                    <option selected>Select Payment</option>
                                </select>
                            </div>
                            <button class="btn btn-success w-100" disabled>Place Order</button>
                        </form>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>

</body>

</html>


<script>
    document.querySelectorAll('.btn-increment').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            fetch('{{ url('
                    cart / increment ') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            product_id: id
                        })
                    })
                .then(res => res.json())
                .then(() => location.reload());
        });
    });

    document.querySelectorAll('.btn-decrement').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            fetch('{{ url('
                    cart / decrement ') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            product_id: id
                        })
                    })
                .then(res => res.json())
                .then(() => location.reload());
        });
    });
</script>