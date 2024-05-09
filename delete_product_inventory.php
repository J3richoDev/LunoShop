<?php
// Read XML file
$xml = simplexml_load_file('xml/products.xml');

// Get product ID from POST data
$productId = isset($_POST['id']) ? $_POST['id'] : '';

if ($productId !== '') {
    // Find the product node with the given ID
    $productNode = $xml->xpath("//product[id='$productId']");

    // If product node found, remove it
    if (!empty($productNode)) {
        $dom = dom_import_simplexml($productNode[0]);
        $dom->parentNode->removeChild($dom);

        // Save changes back to XML file
        $xml->asXML('xml/products.xml');

        // Return success message
        $response = ['success' => true];
    } else {
        // Return error message if product node not found
        $response = ['success' => false, 'message' => 'Product not found'];
    }
} else {
    // Return error message if product ID is not provided
    $response = ['success' => false, 'message' => 'Product ID not provided'];
}

// Output JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>