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
                    <form class="d-flex" action="cart.php">
                        <button class="btn btn-outline-dark" type="submit">
                            <i class="bi-cart-fill me-1"></i>
                            Cart
                            <span class="badge bg-dark text-white ms-1 rounded-pill">0</span>
                        </button>
                    </form>
                </div>
            </div>
        </nav>
        
        <!-- Section-->
        <section class="py-5 bg-light">

            <div class="container px-2 px-lg-4">
                <div>
                    <div class="justify-content-around mb-2">
                        <div class="col"><p class="fs-3" style="font-weight:500;"><a href="index.php" style="text-decoration: none; color: inherit;">&leftarrow;</a>Shopping Cart</p></h3></div>
                        <div class="col">
                            <h6><span id="total-items">0</span> items</h6>
                        </div>
                    </div>
                </div>
                    <div class="mb-4">
                        <div class="row">
                            <div class="col-md-8 cart my-2">
                                <div class="card p-3">
                                    <div class="table-responsive">
                                        <div class="overflow-auto" style="max-height:400px;">
                                        <table class="table">
                                            <tr>
                                                <td><p class="font-weight-light">Product Detail</p></td>
                                                <td><p class="font-weight-light text-center ">Quantity</p></td>
                                                <td><p class="font-weight-light text-center ">Price</p></td>
                                                <td><p class="font-weight-light text-center ">Total</p></td>
                                                <td></td>
                                            </tr>
                                            
                                            <tbody id="cart-body">
                                                <!-- Cart items will be added dynamically here -->
                                            </tbody>
                                           

                                        </table>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="col-md-4 my-2">
                                <div class="card p-3" id="order-summary">
                                    <div><h5 style="font-weight:500">Order Summary</h5></div>
                                    <hr>
                                    <div class="row">
                                    <div class="col">
                                        <p>Total items: <span id="total-items">0</span></p>
                                    </div>
                                    <div class="col text-right" id="total-price">
                                        &dollar; 0.00
                                    </div>
                                    </div>
                                    <form>
                                        <p>Shipping</p>
                                        <select id="shipping" name="shipping">
                                            <option value="5.00" selected>Standard Delivery - $5.00</option>
                                            <option value="2.00">Local Delivery - $2.00</option>
                                        </select>
                                        <p class="pt-3">Promo Code</p>
                                        <input id="code" placeholder="Enter your code">
                                    </form>
                                    <hr>
                                    <div class="row">
                                        <div class="col"><b>TOTAL</b></div>
                                        <div class="col text-right" id="overall-total"><b>&dollar; 4124</b></div>
                                    </div>
                                    <button type="submit" name="checkout" class="btn btn-dark my-3">Checkout</button>
                                    <a class="text-center" href="index.php" style="color: inherit;">Continue Shopping</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="back-to-shop"></div>
                </div>
                
                <script>
    $(document).ready(function() {
        // Load initial cart data
        loadCart();
        

        // Increment quantity
        $(document).on('click', '.increment', function() {
            var id = $(this).closest('tr').data('id');
            updateQuantity(id, 'increment');
            
        });

        // Decrement quantity
        $(document).on('click', '.decrement', function() {
            var id = $(this).closest('tr').data('id');
            updateQuantity(id, 'decrement');
           
        });

        $(document).on('click', '.close', function() {
            var id = $(this).closest('tr').data('id');
            removeProductFromCart(id);
        });
    });

    function loadCart() {
    $.ajax({
        url: 'xml/cart.xml', // Load cart.xml
        dataType: 'xml',
        success: function(data) {
            var total = 0;
            var totalItems = 0;
            $('#cart-body').empty();

            // Extract product IDs and quantities from cart.xml
            var products = [];
            $(data).find('product').each(function() {
                var id = $(this).find('id').text();
                var quantity = parseInt($(this).find('quantity').text());
                totalItems += quantity;
                products.push({ id: id, quantity: quantity });
            });

            // Load product details from product.xml based on product IDs
            $.ajax({
                url: 'xml/products.xml', // Load product.xml
                dataType: 'xml',
                success: function(productData) {
                    products.forEach(function(product) {
                        var id = product.id;
                        var quantity = product.quantity;

                        // Find product details in product.xml
                        var productDetail = $(productData).find('product').filter(function() {
                            return $(this).find('id').text() === id;
                        });

                        // Extract product details
                        var name = productDetail.find('name').text();
                        var price = parseFloat(productDetail.find('price').text());
                        var img_url = productDetail.find('img_url').text();

                        // Generate cart item row
                        var row = '<tr data-id="' + id + '">';
                        row += '<td>';
                        row += '<div class="d-flex align-items-center">';
                        row += '<div class="flex-shrink-0">';
                        row += '<a href="#"><img class="img-fluid img-thumbnail" style="height: 80px;" src="' + img_url + '"></a>';
                        row += '</div>';
                        row += '<div class="flex-grow-1 ms-3">';
                        row += '<a href="#" style="text-decoration: none; color: inherit;"><h6>' + name + '</h6></a>';
                        row += '</div>';
                        row += '</div>';
                        row += '</td>';
                        row += '<td>';
                        row += '<div class="d-flex justify-content-center align-items-center">';
                        row += '<div class="input-group justify-content-center align-items-center">';
                        row += '<button class="decrement btn btn-light  btn-sm">-</button>';
                        row += '<span class="quantity">' + quantity + '</span>';
                        row += '<button class="increment btn btn-light  btn-sm">+</button>';
                        row += '</div>';
                        row += '</div>';
                        row += '</td>';
                        row += '<td>';
                        row += '<div class="d-flex justify-content-center mx-3"><span class="price">&dollar;' + price + '</span></div>';
                        row += '</td>';
                        row += '<td>';
                        row += '<div class="d-flex justify-content-center mx-3">&dollar;' + parseFloat((price * quantity).toFixed(2)) + '</div>';
                        row += '</td>';
                        row += '<td>';
                        row += '<div class="d-flex justify-content-center mx-2">';
                        row += '<a href="#" style="text-decoration: none; color: inherit;"><span class="close">&#10005;</span></a>';
                        row += '</div>';
                        row += '</td>';
                        row += '</tr>';

                        $('#cart-body').append(row);
                        
                        total += parseFloat((price * quantity).toFixed(2));
                    });

                    // Update total price
                    $('#total-price').text(parseFloat(total.toFixed(2)));
                    $('#total-items').text(totalItems);

                    var shippingCost = parseFloat($('#shipping').val());
                    var totalPriceWithShipping = total + shippingCost;
                    $('#overall-total').html('<b>&dollar;' + totalPriceWithShipping.toFixed(2) + '</b>');
                   
                    
                }
            });

$('#shipping').change(function() {
        var totalPrice = parseFloat($('#total-price').text().replace('$', ''));
        var shippingCost = parseFloat($(this).val());
        var totalPriceWithShipping = total + shippingCost;
        $('#overall-total').html('<b>&dollar;' + totalPriceWithShipping.toFixed(2) + '</b>');
    });

        }
    });
}




    function updateQuantity(id, action) {
    $.ajax({
        type: 'POST',
        url: 'update_cart.php',
        data: { id: id, action: action },
        success: function() {
            loadCart();
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
    }

    function removeProductFromCart(id) {
        $.ajax({
            type: 'POST',
            url: 'remove_product.php', // PHP script to remove product from cart XML
            data: { id: id },
            success: function() {
                loadCart(); // Reload the cart after removing the product
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
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
