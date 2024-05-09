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
                <a class="navbar-brand" href="#!">Luno</a>
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
                <h2 class="fw-bolder mb-4">Add New Product</h2>
                </div>
                <div class="d-flex justify-content-between mb-4 px-4 row">
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
                            <input type="file" id="imageInput" accept="image/*">
                        </div>
                        <div class="mb-3 mt-2 form-check">
                            <input type="checkbox" class="form-check-input" id="onSale">
                            <label class="form-check-label" for="onSale">Is it on sale?</label>
                        </div>
                    </form>
                    </div>
                    <div class="mt-4">
                        <button type="button" class="btn btn-primary btn-save-changes" id="saveChangesBtn">Save changes</button>
                    </div>     

                    <div id="result"></div>

                </div>
            </div>
            
            <script>

document.getElementById('saveChangesBtn').addEventListener('click', function() {
     UploadProduct();
  });

function UploadProduct() {
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
    .then(response => response.text())
    .then(data => {
      // Handle response from add_product_inventory.php if needed
      console.log(data);
    })
    .catch(error => {
      console.error('Error:', error);
    });

    const resultDiv = document.getElementById('result');
    resultDiv.innerHTML = `<img src="${imageUrl}" alt="Uploaded Image" width="300">`;

  })
  .catch(error => {
    console.error('Error:', error);
    const resultDiv = document.getElementById('result');
    resultDiv.innerHTML = 'Error uploading image';
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
