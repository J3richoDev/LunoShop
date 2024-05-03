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
        
    </head>
    <body>
        <!--Script for cart-->
        <?php
            session_start();

            // Function to save cart to XML file
            function saveCartToXML() {
                // Create cart XML document
                $cartXml = new SimpleXMLElement('<?xml version="1.0"?><cart></cart>');

                // Add products to cart XML
                foreach ($_SESSION['cart'] as $productId => $quantity) {
                    $product = $cartXml->addChild('product');
                    $product->addChild('id', $productId);
                    $product->addChild('quantity', $quantity);
                }

                // Save cart XML to file
                $cartXml->asXML('xml/cart.xml');
            }

            // Check if cart needs to be saved to XML
            if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                saveCartToXML();
            }
            ?>


        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand" href="#!">Luno</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="#!">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="#!">About</a></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Shop</a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#!">All Products</a></li>
                                <li><hr class="dropdown-divider" /></li>
                                <li><a class="dropdown-item" href="#!">Popular Items</a></li>
                                <li><a class="dropdown-item" href="#!">New Arrivals</a></li>
                            </ul>
                        </li>
                    </ul>
                    <form class="d-flex">
                        <button class="btn btn-outline-dark" type="submit">
                            <i class="bi-cart-fill me-1"></i>
                            Cart
                            <span class="badge bg-dark text-white ms-1 rounded-pill">0</span>
                        </button>
                    </form>
                </div>
            </div>
        </nav>
        <!-- Header-->
        <header class="bg-dark py-5">
            <div class="container px-4 px-lg-5 my-5">
                <div class="text-center text-white">
                    <h1 class="display-4 fw-bolder">Shop in style</h1>
                    <p class="lead fw-normal text-white-50 mb-0">With this shop hompeage template</p>
                </div>
            </div>
        </header>
        <!-- Section-->
        <section class="py-5">
            <div class="container px-4 px-lg-5 mt-5">
                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                <?php
                    // Load the XML file
                    $xml = simplexml_load_file('xml/products.xml');

                    // Function to add product to cart
                    function addToCart($productId) {
                        // Initialize cart array if not already set
                        if (!isset($_SESSION['cart'])) {
                            $_SESSION['cart'] = [];
                        }

                        // Add product to cart or increment quantity if already in cart
                        if (isset($_SESSION['cart'][$productId])) {
                            $_SESSION['cart'][$productId]++;
                        } else {
                            $_SESSION['cart'][$productId] = 1;
                        }
                    }

                    // Check if add to cart button is pressed
                    if (isset($_POST['add_to_cart'])) {
                        // Get product ID from form
                        $productId = $_POST['product_id'];

                        // Add product to cart
                        addToCart($productId);

                        echo "
                        <script>
                            Swal.fire({
                                icon: 'success',
                                title: 'Added to cart!',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        </script>";

                    }
                    ?>

                    <!-- Loop through each product and display card div -->
                    <?php foreach ($xml->product as $product): ?>
                        <?php
                        // Get product details
                        $id = (string)$product->id;
                        $name = (string)$product->name;
                        $description = (string)$product->description;
                        $price = (float)$product->price;
                        $onsale = (string)$product->onsale;
                        $img_url = (string)$product->img_url;
                        ?>

                        <!-- Card div for each product -->
                        <div class="col mb-5">
                            <div class="card h-100">
                                <!-- Sale badge - show if on sale -->
                                <?php if ($onsale == "true"): ?>
                                    <div class="badge bg-dark text-white position-absolute" style="top: 0.5rem; right: 0.5rem">Sale</div>
                                <?php endif; ?>

                                <!-- Product image -->
                                <img class="card-img-top" src="<?php echo $img_url; ?>" alt="<?php echo $name; ?>" />

                                <!-- Product details -->
                                <div class="card-body p-4">
                                    <div class="text-center">
                                        <h5 class="fw-bolder"><?php echo $name; ?></h5>
                                        <p class="text-truncate font-weight-light"><?php echo $description; ?></p>
                                        <h6>$<?php echo number_format($price, 2); ?></h6>
                                    </div>
                                </div>

                                <!-- Product actions -->
                                <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                    <div class="text-center">
                                        <!-- Add to cart form -->
                                        <form method="post" onsubmit="return confirmAddToCart();">
                                            <input type="hidden" name="product_id" value="<?php echo $id; ?>">
                                            <button type="submit" name="add_to_cart" class="btn btn-outline-dark mt-auto">Add to cart</button>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <script>
                        function confirmAddToCart(productId) {
                            Swal.fire({
                                title: 'Are you sure?',
                                text: 'Do you want to add this product to your cart?',
                                icon: 'question',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Yes, add it!',
                                cancelButtonText: 'No, cancel'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    document.getElementById('add_to_cart_form_' + productId).submit();
                                }
                                return false;
                            });
                        }
                    </script>
    
                </div>
            </div>
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
        <script src="sweetalert2.all.min.js"></script>
    </body>
</html>
