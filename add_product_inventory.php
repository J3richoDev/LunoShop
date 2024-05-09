<?php
// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the JSON data sent from the client
    $json_data = file_get_contents("php://input");
    
    // Decode JSON data
    $data = json_decode($json_data);
    
    // Check if the imageUrl is present
    if (isset($data->imageUrl)) {
        $imageUrl = $data->imageUrl;
        
        // Extract other form data
        $productName = $data->productName;
        $productQuantity = $data->productQuantity;
        $productPrice = $data->productPrice;
        $productDesc = $data->productDesc;
        $onSale = $data->onSale;
        
        // Load existing XML or create a new XML if it doesn't exist
        $xml = simplexml_load_file("xml/products.xml");
        if ($xml === false) {
            // Error handling: Log error and send response
            error_log("Failed to load products.xml");
            http_response_code(500);
            echo json_encode(array('success' => false, 'message' => 'Error: Failed to load products.xml'));
            exit;
        }
        
        // Find the maximum existing ID and increment it by 1 for the new product
        $maxId = 0;
        foreach ($xml->product as $product) {
            $idValue = (int)$product->id;
            if ($idValue > $maxId) {
                $maxId = $idValue;
            }
        }
        $newId = $maxId + 1;
        
        // Create a new 'product' element
        $product = $xml->addChild('product');
        
        // Add elements to the 'product' element
        $product->addChild('id', $newId);
        $product->addChild('name', $productName);
        $product->addChild('description', $productDesc);
        $product->addChild('price', $productPrice);
        $product->addChild('quantity', $productQuantity);
        $product->addChild('onsale', $onSale);
        $product->addChild('img_url', $imageUrl);
        
        // Save the XML file
        $saved = $xml->asXML("xml/products.xml");
        if ($saved === false) {
            // Error handling: Log error and send response
            error_log("Failed to save products.xml");
            http_response_code(500);
            echo json_encode(array('success' => false, 'message' => 'Error: Failed to save products.xml'));
            exit;
        }
        
        // Send a success response
        echo json_encode(array('success' => true, 'message' => 'Data saved successfully.'));
        exit; // exit after sending the success response
    } else {
        // Send an error response if imageUrl is not present
        http_response_code(400);
        echo json_encode(array('success' => false, 'message' => 'Error: imageUrl is missing in the request.'));
        exit;
    }
} else {
    // Send an error response if the request method is not POST
    http_response_code(405);
    echo json_encode(array('success' => false, 'message' => 'Error: Only POST requests are allowed.'));
    exit;
}
?>