<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = $_POST['product_id'];

    // Load or create the cart XML file
    $cartXmlFile = 'xml/cart.xml';
    if (file_exists($cartXmlFile)) {
        $cartXml = simplexml_load_file($cartXmlFile);
    } else {
        $cartXml = new SimpleXMLElement('<cart></cart>');
        $cartXml->asXML($cartXmlFile);
    }

    // Check if the product already exists in the cart
    $existingProduct = $cartXml->xpath("//product[id='$productId']");

    if ($existingProduct) {
        // If the product already exists, increment its quantity
        $existingProduct[0]->quantity = intval($existingProduct[0]->quantity) + 1;
    } else {
        // If the product doesn't exist, add it with quantity 1
        $product = $cartXml->addChild('product');
        $product->addChild('id', $productId);
        $product->addChild('quantity', 1);
    }

    // Save the updated cart XML
    $cartXml->asXML($cartXmlFile);

    // Return success message as JSON
    $response = array('status' => 'success', 'message' => 'Product added to cart successfully!');
    echo json_encode($response);
} else {
    // Return error message as JSON if request method is not POST
    $response = array('status' => 'error', 'message' => 'Invalid request method');
    echo json_encode($response);
}
?>