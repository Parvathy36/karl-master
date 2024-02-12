<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include your database connection file
    include "connect.php";

    // Retrieve form data and sanitize it
    $productName = mysqli_real_escape_string($conn, $_POST['productName']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $category_id = $_POST['category'];

    // Determine the subcategory based on the selected category
    $subcategory_id = null;
    switch ($category_id) {
        case '1':
            $subcategory_id = $_POST['Subcategory1'];
            break;
        case '2':
            $subcategory_id = $_POST['Subcategory2'];
            break;
        case '3':
            $subcategory_id = $_POST['Subcategory3'];
            break;
        default:
            // Handle default case if needed
            break;
    }

// Handle file upload for the image
$image = file_get_contents($_FILES['image']['tmp_name']);

if ($image === false) {
    echo "Error: Failed to read the image file.";
    exit;
}

// Encode the image data to base64
$image_base64 = base64_encode($image);

// Prepare SQL statement with placeholders for the image
$sql = "INSERT INTO tbl_products (p_name, description, qty, price, category_id, image, subcategory_id)
        VALUES (?, ?, ?, ?, ?, ?, ?)";

// Prepare the statement
$stmt = mysqli_prepare($conn, $sql);
if ($stmt) {
    // Bind parameters to the statement
    mysqli_stmt_bind_param($stmt, "ssiiibs", $productName, $description, $quantity, $price, $category_id, $image, $subcategory_id);

    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Product added successfully.')</script>";
        header("Location: adminproductrec.php");
        exit; // Make sure to exit after redirection
    } else {
        echo "<script>alert('Error: " . mysqli_stmt_error($stmt) . "')</script>";
    }

    // Close the statement
    mysqli_stmt_close($stmt);
} else {
    echo "Error: Unable to prepare statement: " . mysqli_error($conn);
}
    // Close database connection
    mysqli_close($conn);
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

/* Table styles */
table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    /* Table header styles */
    th {
        background-color: #f2f2f2;
        padding: 8px;
        text-align: left;
    }

    /* Table row styles */
    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    /* Table cell styles */
    td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    /* Hover effect for table rows */
    tr:hover {
        background-color: #f2f2f2;
    }

    /* Image styles */
    .product-image {
        max-width: 100px;
        max-height: 100px;
    }

</style>

<body>
    <div class="sidebar">
        <div class="logo"></div>
        <ul class="menu">
            <li><a href="admin.php"><i class="fas fa-tachometer"></i>
                    <span>Dashboard</span></a>
            </li>
            <li class="active"><a href="adminproductrec.php"><i class="fas fa-store"></i>
                    <span>Manage Products</span></a>
            </li>
            <li><a href="#"><i class="fas fa-lightbulb"></i>
                    <span>Manage Tips</span></a>
            </li>
            <li><a href="#"><i class="fas fa-clipboard-list"></i>
                    <span>Orders</span></a>
            </li>
            <li><a href="adminuserrec.php"><i class="fas fa-users"></i>
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
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
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
    <label for="Subcategory1">Subcategory:</label>
    <select id="Subcategory1" name="Subcategory1">
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
    <label for="Subcategory2">Subcategory:</label>
    <select id="Subcategory2" name="Subcategory2">
        <option value="">Select Subcategory</option>
        <option value="8">Jewellery</option>
        <option value="9">Bag</option>
    </select><br><br>
</div>

<!-- Subcategories for Footwear -->
<div id="Subcategories3" class="subcategories" style="display: none;">
    <label for="Subcategory3">Subcategory:</label>
    <select id="Subcategory3" name="Subcategory3">
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
            <th>Image</th> <!-- New th for the product image -->
        </tr>
        <!-- Fetch products from the database and display them in the table -->
        <?php
        include 'connect.php';

        // Perform SQL query to fetch products
        $sql = "SELECT p_name, description, qty, price, category_id, subcategory_id, image FROM tbl_products";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            // Output data of each row
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>" . $row['p_name'] . "</td>
                        <td>" . $row['description'] . "</td>
                        <td>" . $row['qty'] . "</td>
                        <td>$" . $row['price'] . "</td>
                        <td>" . $row['category_id'] . "</td>
                        <td>" . $row['subcategory_id'] . "</td>
                        <td><img src='data:image/jpeg;base64," . base64_encode($row['image']) . "' width='100' height='100'></td> <!-- Display image -->
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No products found</td></tr>";
        }

        // Close the database connection
        mysqli_close($conn);
        ?>
    </table>
</div>

        <!-- You can add more sections here if needed -->
</div>
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
