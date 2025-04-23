<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pos System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
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

    <div class="container-fluid">
        <div class="row">

            <!-- Product Grid -->
            <div class="col-md-9">
                <div class="mb-2 mt-2">
                    <input type="text" class="form-control" placeholder="Search product by name" disabled>
                </div>

                <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-6 g-3 product-grid">
                    <div class="col">
                        <div class="card h-100 shadow-sm">
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRlndpwDalSNF8TzBG6T7kGv73l0IOReNJpKw&s" class="card-img-top" alt="Sample Product">
                            <div class="card-body text-center p-2 d-flex flex-column">
                                <div class="card-title text-truncate">Product Name</div>
                                <div class="text-muted small">1 Unit | SKU123</div>
                                <div class="text-muted small">Stock: 25</div>

                                <div class="price-tag mt-1 mb-2">
                                    <span class="text-success fw-bold">$9.99</span>
                                    <span class="text-muted text-decoration-line-through small">$14.99</span>
                                </div>

                                <div class="mt-auto">
                                    <button class="btn btn-sm btn-outline-success w-100" disabled>Add to cart</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card h-100 shadow-sm">
                            <img src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?fm=jpg&q=60&w=3000&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8cHJvZHVjdHxlbnwwfHwwfHx8MA%3D%3D" class="card-img-top" alt="Sample Product">
                            <div class="card-body text-center p-2 d-flex flex-column">
                                <div class="card-title text-truncate">Product Name</div>
                                <div class="text-muted small">1 Unit | SKU123</div>
                                <div class="text-muted small">Stock: 25</div>

                                <div class="price-tag mt-1 mb-2">
                                    <span class="text-success fw-bold">$9.99</span>
                                    <span class="text-muted text-decoration-line-through small">$14.99</span>
                                </div>

                                <div class="mt-auto">
                                    <button class="btn btn-sm btn-outline-success w-100" disabled>Add to cart</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card h-100 shadow-sm">
                            <img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?fm=jpg&q=60&w=3000&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8cHJvZHVjdHxlbnwwfHwwfHx8MA%3D%3D" class="card-img-top" alt="Sample Product">
                            <div class="card-body text-center p-2 d-flex flex-column">
                                <div class="card-title text-truncate">Product Name</div>
                                <div class="text-muted small">1 Unit | SKU123</div>
                                <div class="text-muted small">Stock: 25</div>

                                <div class="price-tag mt-1 mb-2">
                                    <span class="text-success fw-bold">$9.99</span>
                                    <span class="text-muted text-decoration-line-through small">$14.99</span>
                                </div>

                                <div class="mt-auto">
                                    <button class="btn btn-sm btn-outline-success w-100" disabled>Add to cart</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card h-100 shadow-sm">
                            <img src="https://d2v5dzhdg4zhx3.cloudfront.net/web-assets/images/storypages/primary/ProductShowcasesampleimages/JPEG/Product+Showcase-1.jpg" class="card-img-top" alt="Sample Product">
                            <div class="card-body text-center p-2 d-flex flex-column">
                                <div class="card-title text-truncate">Product Name</div>
                                <div class="text-muted small">1 Unit | SKU123</div>
                                <div class="text-muted small">Stock: 25</div>

                                <div class="price-tag mt-1 mb-2">
                                    <span class="text-success fw-bold">$9.99</span>
                                    <span class="text-muted text-decoration-line-through small">$14.99</span>
                                </div>

                                <div class="mt-auto">
                                    <button class="btn btn-sm btn-outline-success w-100" disabled>Add to cart</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card h-100 shadow-sm">
                            <img src="data:image/jpeg;base64,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" class="card-img-top" alt="Sample Product">
                            <div class="card-body text-center p-2 d-flex flex-column">
                                <div class="card-title text-truncate">Product Name</div>
                                <div class="text-muted small">1 Unit | SKU123</div>
                                <div class="text-muted small">Stock: 25</div>

                                <div class="price-tag mt-1 mb-2">
                                    <span class="text-success fw-bold">$9.99</span>
                                    <span class="text-muted text-decoration-line-through small">$14.99</span>
                                </div>

                                <div class="mt-auto">
                                    <button class="btn btn-sm btn-outline-success w-100" disabled>Add to cart</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card h-100 shadow-sm">
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRHOCzaEM17rj4LhXRx3nOezr76b-3BZ_WN_A&s" class="card-img-top" alt="Sample Product">
                            <div class="card-body text-center p-2 d-flex flex-column">
                                <div class="card-title text-truncate">Product Name</div>
                                <div class="text-muted small">1 Unit | SKU123</div>
                                <div class="text-muted small">Stock: 25</div>

                                <div class="price-tag mt-1 mb-2">
                                    <span class="text-success fw-bold">$9.99</span>
                                    <span class="text-muted text-decoration-line-through small">$14.99</span>
                                </div>

                                <div class="mt-auto">
                                    <button class="btn btn-sm btn-outline-success w-100" disabled>Add to cart</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card h-100 shadow-sm">
                            <img src="https://img.freepik.com/premium-psd/skincare-product-sale-poster-template_597316-411.jpg?semt=ais_hybrid&w=740" class="card-img-top" alt="Sample Product">
                            <div class="card-body text-center p-2 d-flex flex-column">
                                <div class="card-title text-truncate">Product Name</div>
                                <div class="text-muted small">1 Unit | SKU123</div>
                                <div class="text-muted small">Stock: 25</div>

                                <div class="price-tag mt-1 mb-2">
                                    <span class="text-success fw-bold">$9.99</span>
                                    <span class="text-muted text-decoration-line-through small">$14.99</span>
                                </div>

                                <div class="mt-auto">
                                    <button class="btn btn-sm btn-outline-success w-100" disabled>Add to cart</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card h-100 shadow-sm">
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQbKIqXLMy8_rCu9Rs6y81EC2VXSeqrPH2RXnv_kSdH9EGY3T6dyMoIUCQ&s" class="card-img-top" alt="Sample Product">
                            <div class="card-body text-center p-2 d-flex flex-column">
                                <div class="card-title text-truncate">Product Name</div>
                                <div class="text-muted small">1 Unit | SKU123</div>
                                <div class="text-muted small">Stock: 25</div>

                                <div class="price-tag mt-1 mb-2">
                                    <span class="text-success fw-bold">$9.99</span>
                                    <span class="text-muted text-decoration-line-through small">$14.99</span>
                                </div>

                                <div class="mt-auto">
                                    <button class="btn btn-sm btn-outline-success w-100" disabled>Add to cart</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card h-100 shadow-sm">
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSYi1C2_l30-1V3GjBIsQEvOPgm6ndBZ_T3AysUnc_tz8o-BVnvy0YhPdo&s" class="card-img-top" alt="Sample Product">
                            <div class="card-body text-center p-2 d-flex flex-column">
                                <div class="card-title text-truncate">Product Name</div>
                                <div class="text-muted small">1 Unit | SKU123</div>
                                <div class="text-muted small">Stock: 25</div>

                                <div class="price-tag mt-1 mb-2">
                                    <span class="text-success fw-bold">$9.99</span>
                                    <span class="text-muted text-decoration-line-through small">$14.99</span>
                                </div>

                                <div class="mt-auto">
                                    <button class="btn btn-sm btn-outline-success w-100" disabled>Add to cart</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card h-100 shadow-sm">
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQEnmJZMDQVl89A7ZWl2NRg1jZ3UhRUXMUxHIsZZlX1Lkm0visCNgXDObs&s" class="card-img-top" alt="Sample Product">
                            <div class="card-body text-center p-2 d-flex flex-column">
                                <div class="card-title text-truncate">Product Name</div>
                                <div class="text-muted small">1 Unit | SKU123</div>
                                <div class="text-muted small">Stock: 25</div>

                                <div class="price-tag mt-1 mb-2">
                                    <span class="text-success fw-bold">$9.99</span>
                                    <span class="text-muted text-decoration-line-through small">$14.99</span>
                                </div>

                                <div class="mt-auto">
                                    <button class="btn btn-sm btn-outline-success w-100" disabled>Add to cart</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card h-100 shadow-sm">
                            <img src="https://cdn.baymard.com/blog/ux-product-image-categories-6-usage-inspiration-1.jpg" class="card-img-top" alt="Sample Product">
                            <div class="card-body text-center p-2 d-flex flex-column">
                                <div class="card-title text-truncate">Product Name</div>
                                <div class="text-muted small">1 Unit | SKU123</div>
                                <div class="text-muted small">Stock: 25</div>

                                <div class="price-tag mt-1 mb-2">
                                    <span class="text-success fw-bold">$9.99</span>
                                    <span class="text-muted text-decoration-line-through small">$14.99</span>
                                </div>

                                <div class="mt-auto">
                                    <button class="btn btn-sm btn-outline-success w-100" disabled>Add to cart</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Repeat above block for more static products -->

                </div>
            </div>

            <!-- Cart Section -->
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
                                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSYi1C2_l30-1V3GjBIsQEvOPgm6ndBZ_T3AysUnc_tz8o-BVnvy0YhPdo&s" alt="Product" class="img-fluid rounded">
                                    </div>
                                    <div>
                                        <strong>Product A</strong>
                                        <div>৳10.00</div>
                                    </div>
                                    <div class="quantity-control">
                                        <button class="btn btn-sm btn-outline-secondary" disabled>-</button>
                                        <input type="number" class="form-control form-control-sm quantity-input" value="1" disabled>
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
            </div>
        </div>
    </div>

</body>
</html>