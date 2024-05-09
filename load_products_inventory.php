<?php
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$searchTerm = isset($_GET['searchTerm']) ? $_GET['searchTerm'] : '';

$xml = simplexml_load_file('xml/products.xml');

// Pagination
$limit = 10;
$totalProducts = count($xml->product);
$totalPages = ceil($totalProducts / $limit);
$offset = ($page - 1) * $limit;

// Filter products by search term
$filteredProducts = [];
foreach ($xml->product as $product) {
    $name = strtolower((string)$product->name);
    $description = strtolower((string)$product->description);
    if (empty($searchTerm) || strpos($name, $searchTerm) !== false || strpos($description, $searchTerm) !== false) {
        $filteredProducts[] = $product;
    }
}

$paginatedProducts = array_slice($filteredProducts, $offset, $limit);

$productsHtml = '';
foreach ($paginatedProducts as $product) {
    $id = (string)$product->id;
    $name = (string)$product->name;
    $description = (string)$product->description;
    $price = (int)$product->price;
    $quantity = (int)$product->quantity;
    $img_url = (string)$product->img_url;

    $productsHtml .= '
    <tr>
        <td>' . $id . '</td>
        <td>
            <div class="d-flex justify-content-start gap-3">
                <img class="img-thumbnail" style="height: 40px; margin: 2px;" src="' . $img_url . '"/>
                <h6>' . $name . '</h6>
            </div>
        </td>
        <td>$ ' . $price . '</td>
        <td>' . $quantity . '</td>
        <td class="d-inline-block text-truncate" style="max-width: 400px;">' . $description . '</td>
        <td>
            <button class="btn btn-outline-dark" type="submit">
                <i class="bi bi-pencil-square"></i>
            </button>
            <button class="btn btn-outline-dark btn-delete-product" type="button" data-product-id="' . $id . '">
                <i class="bi bi-trash-fill"></i>
            </button>
        </td>
    </tr>';
}

$paginationHtml = '';
for ($i = 1; $i <= $totalPages; $i++) {
    $active = ($i == $page) ? 'active' : '';
    $paginationHtml .= '<li class="page-item ' . $active . '"><a class="page-link" href="#" data-page="' . $i . '">' . $i . '</a></li>';
}

$response = [
    'products_html' => $productsHtml,
    'pagination_html' => $paginationHtml,
    'rows_count' => 'Showing ' . ($offset + 1) . ' to ' . min(($offset + $limit), $totalProducts) . ' of ' . $totalProducts . ' entries'
];


header('Content-Type: application/json');
echo json_encode($response);
?>