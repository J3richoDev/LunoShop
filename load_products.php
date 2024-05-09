<?php
$xml = simplexml_load_file('xml/products.xml');

foreach ($xml->product as $product) {
    $id = (string) $product->id;
    $name = (string) $product->name;
    $description = (string) $product->description;
    $price = (float) $product->price;
    $onsale = (string) $product->onsale;
    $img_url = (string) $product->img_url;

    echo '
        <div class="col mb-5">
            <div class="card h-100">
                <!-- Sale badge - show if on sale -->
                ' . ($onsale == "true" ? '<div class="badge bg-dark text-white position-absolute" style="top: 0.5rem; right: 0.5rem">Sale</div>' : '') . '
                <!-- Product image -->
                <img class="card-img-top" src="' . $img_url . '" alt="' . $name . '" />
                <!-- Product details -->
                <div class="card-body p-4">
                    <div class="text-center">
                        <h5 class="fw-bolder">' . $name . '</h5>
                        <p class="text-truncate font-weight-light">' . $description . '</p>
                        <h6>$' . number_format($price, 2) . '</h6>
                    </div>
                </div>
                <!-- Product actions -->
                <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                    <div class="text-center">
                        <!-- Add to cart form -->
                        <button onclick="return confirmAddToCart(\'' . $id . '\');" class="btn btn-outline-dark mt-auto">Add to cart</button>
                    </div>
                </div>
            </div>
        </div>';
}
?>
