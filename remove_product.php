<?php
// Check if ID is set
if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Load cart XML
    $xml = simplexml_load_file('xml/cart.xml');

    // Find the product by ID
    $product = $xml->xpath("//product[id='$id']")[0];

    // Remove the product node
    unset($product[0]);

    // Save updated XML
    $xml->asXML('xml/cart.xml');
}
?>