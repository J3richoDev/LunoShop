<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Shop Homepage - Start Bootstrap Template</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        
    </head>
    <body>
  
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container px-4 px-lg-4">
                <a class="navbar-brand" href="index.php">Luno</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="index.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="inventory.php">Inventory</a></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Shop</a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="index.php">All Products</a></li>
                            </ul>
                        </li>
                    </ul>
                    
                </div>
            </div>
        </nav>

        <!--Inventory-->

        <section class="py-4">
            <div class="container px-4 px-lg-4">
                <div>
                <h2 class="fw-bolder">Product Inventory</h2>
                </div>
                <div class="d-flex justify-content-between mb-4 row">
                    <div class="col">
                        <input type="text" id="search_input_all" onkeyup="filterProducts()" placeholder="Search.." class="form-control">
                    </div>
                    <div class="col d-flex justify-content-end">
                            <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#addProduct">
                                <i class="bi-plus-lg me-1"></i>
                                Add new product
                            </button>

                            <div class="modal fade" id="addProduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Add New Product</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                    <form>
                                        <div class="mb-3">
                                            <div class="form-outline">
                                                <label for="productName" class="form-label">Product Name</label>
                                                <input type="text" id="productName" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-5">
                                                <div class="form-outline">
                                                    <label for="productQuantity" class="form-label">Quantity</label>
                                                    <input type="text" id="productQuantity" class="form-control" />
                                                </div>
                                            </div>
                                            <div class="col-7">
                                                <div class="form-outline">
                                                    <label for="productPrice" class="form-label">Price</label>
                                                    <div class="input-group mb-2 mr-sm-2">
                                                        <div class="input-group-prepend">
                                                        <div class="input-group-text">$</div>
                                                        </div>
                                                        <input type="text" id="productPrice" class="form-control" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="productDesc" class="form-label">Product description</label>
                                            <textarea class="form-control" id="productDesc" rows="4"></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="productIMG" class="form-label">Upload Image</label>
                                            <input class="form-control" type="file" id="imageInput" accept="image/*">
                                        </div>
                                        <div class="mb-3 form-check">
                                            <input type="checkbox" class="form-check-input" id="onSale">
                                            <label class="form-check-label" for="onSale">Is it on sale?</label>
                                        </div>
                                    </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary" id="saveChangesBtn">Save changes</button>
                                    </div>
                                    </div>
                                </div>
                            </div>

                    </div>
                </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered verticle-middle table-responsive-sm">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%">ID</th>
                                                <th style="width: 35%">Product Name</th>
                                                <th style="width: 8%">Price</th>
                                                <th style="width: 7%">Quantity</th>
                                                <th style="width: 30%">Description</th>
                                                <th style="width: 15%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="productTable">


                                            



                                        </tbody>
                                    </table>

                                    <div class='pagination-container'>
                                        <nav>
                                        <ul class="pagination" id="pagination">
                                        <!--	Here the JS Function Will Add the Rows -->
                                        </ul>
                                        </nav>
                                    </div>
                                    <div class="rows_count" id="rowsCount">Showing 11 to 20 of 91 entries</div>

                                </div>
                            </div>


            </div>

            <script>

                // Function to load products via AJAX
                function loadProducts(page = 1, searchTerm = '') {
                        $.ajax({
                            url: 'load_products_inventory.php',
                            type: 'GET',
                            data: { page: page, searchTerm: searchTerm },
                            success: function(response) {
                                $('#productTable').html(response.products_html);
                                $('#pagination').html(response.pagination_html);
                                $('#rowsCount').html(response.rows_count);
                            },
                            error: function(xhr, status, error) {
                                console.error(xhr.responseText);
                            }
                        });
                    }

                    // Function to filter products by keyword
                    function filterProducts() {
                        var searchTerm = $('#search_input_all').val().toLowerCase();
                        loadProducts(1, searchTerm);
                    }

                    // Load products when the page is ready
                    $(document).ready(function() {
                        loadProducts();
                    });

                    // Function to handle pagination click
                    $(document).on('click', '.pagination a', function(e) {
                        e.preventDefault();
                        var page = $(this).attr('data-page');
                        var searchTerm = $('#search_input_all').val().toLowerCase();
                        loadProducts(page, searchTerm);
                    });

                    $(document).on('click', '.btn-delete-product', function() {
                        // Get product ID from data attribute
                        var productId = $(this).data('product-id');
                        // Call deleteProduct function
                        deleteProduct(productId);
                    });

                    function deleteProduct(productId) {
                        // Confirm deletion with SweetAlert
                        Swal.fire({
                            title: 'Are you sure?',
                            text: 'You will not be able to recover this product!',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: 'Yes, delete it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // User confirmed, send AJAX request to delete product
                                $.ajax({
                                    url: 'delete_product_inventory.php',
                                    type: 'POST',
                                    data: { id: productId },
                                    success: function(response) {
                                        // Reload products after deletion
                                        loadProducts();
                                        Swal.fire(
                                            'Deleted!',
                                            'Your product has been deleted.',
                                            'success'
                                        );
                                    },
                                    error: function(xhr, status, error) {
                                        console.error(xhr.responseText);
                                    }
                                });
                            }
                        });
                    }

                    document.getElementById('saveChangesBtn').addEventListener('click', function() {
                        UploadProduct();
                    });

                    function UploadProduct() {
                        Swal.fire({
                        title: 'Loading...',
                        allowOutsideClick: false,
                        onBeforeOpen: () => {
                            Swal.showLoading();
                        }
                    });


                    const productName = document.getElementById('productName').value;
                    const productQuantity = document.getElementById('productQuantity').value;
                    const productPrice = document.getElementById('productPrice').value;
                    const productDesc = document.getElementById('productDesc').value;
                    const onSale = document.getElementById('onSale').checked ? 'true' : 'false';

                    const input = document.getElementById('imageInput');
                    const file = input.files[0];
                    
                    const formData = new FormData();
                    formData.append('image', file);
                    formData.append('productName', productName);
                    formData.append('productQuantity', productQuantity);
                    formData.append('productPrice', productPrice);
                    formData.append('productDesc', productDesc);
                    formData.append('onSale', onSale);

                    fetch('https://api.imgbb.com/1/upload?key=e22ccd88fc01bc57d145d03f866096b9', {
                        method: 'POST',
                        body: formData,
                    })
                    .then(response => response.json())
                    .then(data => {
                        const imageUrl = data.data.url;

                        // Send imageUrl and form data to add_product_inventory.php
                        fetch('add_product_inventory.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({ 
                            imageUrl: imageUrl,
                            productName: productName,
                            productQuantity: productQuantity,
                            productPrice: productPrice,
                            productDesc: productDesc,
                            onSale: onSale
                        }),
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            console.log(data);
                        // Handle response from add_product_inventory.php if needed
                        if (data.success) {
                            // Show success message
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: data.message
                            }).then((result) => {
                                // Reload the page after the user presses OK
                                if (result.isConfirmed || result.isDismissed) {
                                    location.reload();
                                }
                            });
                        } else {
                            Swal.fire({
                            icon: 'error',
                            title: 'Error kahit success',
                            text: data.message
                            });
                        }
                        })

                    })
                    .catch(error => {
                        // Handle any errors during the fetch request
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'An error occurred. Please try again later.'
                        });
                    });
                    }
            </script>


            

        </section>
        <!-- Footer-->
        <footer class="py-5 bg-dark">
            <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Luno Website 2024</p></div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        
    </body>
</html>
