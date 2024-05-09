<?php
// Check if ID and action are set
if (isset($_POST['id']) && isset($_POST['action'])) {
    $id = $_POST['id'];
    $action = $_POST['action'];

    // Load cart XML
    $cartXmlPath = 'xml/cart.xml';
    $xml = simplexml_load_file($cartXmlPath);

    // Find the product by ID
    $productNode = $xml->xpath("//product[id='$id']")[0];

    // Update quantity based on action
    if ($action === 'increment') {
        $quantity = intval($productNode->quantity) + 1;
        $productNode->quantity = $quantity;
    } elseif ($action === 'decrement' && intval($productNode->quantity) > 0) {
        $quantity = intval($productNode->quantity) - 1;
        $productNode->quantity = $quantity;
    }

    // Save updated XML
    $xml->asXML($cartXmlPath);

    // Return updated quantity
    echo $quantity;
}
?>