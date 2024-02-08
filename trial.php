<?php

session_start();

include 'connect.php';
if(isset($_session['email'])){
    header("location: guestindex.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form data
    $productName = isset($_POST['productName']) ? mysqli_real_escape_string($conn, $_POST['productName']) : '';
    $description = isset($_POST['description']) ? mysqli_real_escape_string($conn, $_POST['description']) : '';
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 0;
    $price = isset($_POST['price']) ? floatval($_POST['price']) : 0.0;
    $categoryName = isset($_POST['category']) ? intval($_POST['category']) : 0; // Assuming category_id is an integer in the database
    $subcategoryName = isset($_POST['subcategory']) ? intval($_POST['subcategory']) : 0; // Assuming subcategory_id is an integer in the database
    $image = isset($_POST['image']) ? mysqli_real_escape_string($conn, $_POST['image']) : '';

    // Insert product into tbl_products with category and subcategory IDs
    $insertProductQuery = "INSERT INTO tbl_products (p_name, description, qty, price, category_id, image, subcategory_id) 
                            VALUES ('$productName', '$description', '$quantity', '$price', '$categoryName', '$image', '$subcategoryName')";
    
    if (mysqli_query($conn, $insertProductQuery)) {
        // Redirect to the same page after successful insertion
        header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "Error: " . $insertProductQuery . "<br>" . mysqli_error($conn);
    }
}
?>





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin dashboard</title>
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<style>
    /* Add your custom CSS styles here */
.section1 {
    margin-top: 20px;
}

.form-container {
    display: none;
    background-color: #f4f4f4;
    padding: 20px;
    border-radius: 5px;
    margin-top: 10px;
}

.products-container {
    display: none;
    background-color: #f4f4f4;
    padding: 20px;
    border-radius: 5px;
    margin-top: 10px;
}

.active-tab {
    display: block;
}

.subcategories {
            display: none;
        }

/* Add more styles as needed */
</style>

<body>
    <div class="sidebar">
        <div class="logo"></div>
        <ul class="menu">
            <li class="active"><a href="#"><i class="fas fa-store"></i>
                    <span>Manage Products</span></a>
            </li>
            <li><a href="#"><i class="fas fa-lightbulb"></i>
                    <span>Manage Tips</span></a>
            </li>
            <li><a href="#"><i class="fas fa-clipboard-list"></i>
                    <span>Orders</span></a>
            </li>
            <li><a href="#"><i class="fas fa-users"></i>
                    <span>Users Record</span></a>
            </li>
            <li><a href="#"><i class="fas fa-question-circle"></i>
                    <span>FAQ</span></a>
            </li>
            <li><a href="#"><i class="fas fa-cog"></i>
                    <span>Settings</span></a>
            </li>
            <li class="logout"><a href="logout.php"><i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span></a>
            </li>
        </ul>
    </div>
    <div class="main--content">
        <div class="header--wrapper">
            <div class="header--title">
                <span>Admin</span>
                <h2>Dashboard</h2>
            </div>
            <div class="user--info">
                <div class="search--box">
                    <i class="fa-solid fa-search"></i>
                    <input type="text" placeholder="search">
                </div>
                <img src="" alt="">
            </div>
        </div>
        <div class="section1">
            <h3 style="color:#922B21">Manage Products</h3>
            <br>
            <button id="addBtn"style="width:120px; height:50px; border-radius:5px">Add Products</button>
            <button id="viewBtn"style="width:120px; height:50px; border-radius:5px">View Products</button>

            <!-- Add Product Form Container -->
            <div id="addProductForm" class="form-container">
                <h4 style="color:#922B21">Add Product</h4><br>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <label for="productName">Product Name:</label>
        <input type="text" id="productName" name="productName" required><br><br>

        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea><br><br>

        <label for="quantity">Quantity:</label>
        <input type="number" id="quantity" name="quantity" min="1" required><br><br>

        <label for="price">Price:</label>
        <input type="number" id="price" name="price" step="0.01" min="0" required><br><br>

        <label for="category">Category:</label>
        <select id="category" name="category" required onchange="toggleSubcategories()">
            <option value="">Select Category</option>
            <option value="1">Women's Wear</option>
            <option value="2">Accessories</option>
            <option value="3">Footwear</option>
        </select><br><br>

        <!-- Subcategories for Women's Wear -->
<div id="Subcategories1" class="subcategories" style="display: none;">
    <label for="Subcategory">Subcategory:</label>
    <select id="Subcategory" name="Subcategory">
        <option value="">Select Subcategory</option>
        <option value="1">Dresses</option>
        <option value="2">Co-ords Sets</option>
        <option value="3">Tops</option>
        <option value="4">Bottoms</option>
        <option value="5">Jackets</option>
        <option value="6">Jumpsuits</option>
        <option value="7">Scarfs & Stoles</option>
    </select><br><br>
</div>

<!-- Subcategories for Accessories -->
<div id="Subcategories2" class="subcategories" style="display: none;">
    <label for="Subcategory">Subcategory:</label>
    <select id="Subcategory" name="Subcategory">
        <option value="">Select Subcategory</option>
        <option value="8">Jewellery</option>
        <option value="9">Bag</option>
    </select><br><br>
</div>

<!-- Subcategories for Footwear -->
<div id="Subcategories3" class="subcategories" style="display: none;">
    <label for="Subcategory">Subcategory:</label>
    <select id="Subcategory" name="Subcategory">
        <option value="">Select Subcategory</option>
        <option value="10">Shoes</option>
        <option value="11">Sandals</option>
    </select><br><br>
</div>


        <label for="image">Product Image:</label>
        <input type="file" id="image" name="image" accept="image/*" required><br><br>

        <input type="submit" value="Add" style="width:120px; height:50px">
    </form>
            </div>

            <!-- View Products Container -->
            <div id="viewProducts" class="products-container">
            <h4 style="color:#922B21">View Products</h4>
    <table>
        <tr>
            <th>Product Name</th>
            <th>Description</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Category</th>
            <th>Subcategory</th>
        </tr>
                <!-- Display your products here -->
            </div>
        </div>
        <!-- You can add more sections here if needed -->

        <script>
        // JavaScript for handling button clicks and showing/hiding tabs
        document.addEventListener("DOMContentLoaded", function () {
            var addBtn = document.getElementById('addBtn');
            var viewBtn = document.getElementById('viewBtn');
            var addProductForm = document.getElementById('addProductForm');
            var viewProducts = document.getElementById('viewProducts');

            addBtn.addEventListener('click', function () {
                addProductForm.classList.add('active-tab');
                viewProducts.classList.remove('active-tab');
            });

            viewBtn.addEventListener('click', function () {
                viewProducts.classList.add('active-tab');
                addProductForm.classList.remove('active-tab');
            });

            // Add more JavaScript functionality here, such as form submission handling
        });

        // Function to toggle subcategories based on the selected category
        function toggleSubcategories() {
            var category = document.getElementById('category').value;
            var subcategories = document.getElementsByClassName('subcategories');

            // Hide all subcategories initially
            for (var i = 0; i < subcategories.length; i++) {
                subcategories[i].style.display = 'none';
            }

            // Show subcategories based on the selected main category
            if (category === '1') {
                document.getElementById('Subcategories1').style.display = 'block';
            } else if (category === '2') {
                document.getElementById('Subcategories2').style.display = 'block';
            } else if (category === '3') {
                document.getElementById('Subcategories3').style.display = 'block';
            }
        }
    </script>
    </div>
</body>

</html>
