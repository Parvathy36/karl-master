<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include your database connection file
    require_once "connect.php";

    // Define variables and initialize them
    $productName = $description = $image_name = $subcategory_id = "";
    $quantity = $price = $category_id = 0;

    // Sanitize and validate form data
    if (isset($_POST['productName'])) {
        $productName = mysqli_real_escape_string($conn, $_POST['productName']);
    }
    if (isset($_POST['description'])) {
        $description = mysqli_real_escape_string($conn, $_POST['description']);
    }
    if (isset($_POST['quantity']) && isset($_POST['price']) && isset($_POST['category'])) {
        $quantity = (int)$_POST['quantity'];
        $price = (float)$_POST['price'];
        $category_id = (int)$_POST['category'];
    }

    // Determine the subcategory based on the selected category
    switch ($category_id) {
        case 1:
        case 2:
        case 3:
            $subcat_key = 'Subcategory'.$category_id;
            if(isset($_POST[$subcat_key])){
                $subcategory_id = (int)$_POST[$subcat_key];
            }
            break;
        default:
            // Handle default case if needed
            break;
    }

    // Handle file upload for the image
    if(isset($_FILES['image']['name'])){
        $image_name = $_FILES['image']['name'];
        $target_dir = "img/product-img/";
        $target_file = $target_dir . basename($image_name);
    }

    // Prepare SQL statement with placeholders for the image
    $sql = "INSERT INTO tbl_products (p_name, description, qty, price, category_id, image, subcategory_id)
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    // Prepare the statement
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt) {
        // Bind parameters to the statement
        mysqli_stmt_bind_param($stmt, "ssiiisi", $productName, $description, $quantity, $price, $category_id, $image_name, $subcategory_id);

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
button {
        margin-right: 10px; /* Adjust the right margin to change the gap */
}

#addBtn, #viewBtn, #subcateBtn, #catBtn {
    width: 20%;
    height: 100px;
    border-radius: 5px;
    font-size: 20px; /* Adjust the font size as per your requirement */
    background: white;
    color: #922B21;
    font-weight: bold;
    font-family: 'Garamond';
    border: none;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

#addBtn:hover, #viewBtn:hover, #subcateBtn:hover, #catBtn:hover {
    background-color: #D89992;
    color: white;
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

/* Style the table */
table {
    border-collapse: collapse;
    width: 100%;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

/* Style table header and cells */
th, td {
    border: 1px solid #ddd;
    padding: 12px;
    text-align: left;
}

/* Style table header */
th {
    background-color: #f2f2f2;
    color: #333;
    font-weight: bold;
    text-transform: uppercase;
}

/* Style alternate table rows */
tr:nth-child(even) {
    background-color: #f9f9f9;
}

/* Style the product image */
td img {
    display: block;
    margin: 0 auto;
    border-radius: 4px;
}

/* Style the buttons */
button {
    padding: 8px 16px;
    border: none;
    cursor: pointer;
    border-radius: 4px;
    transition: background-color 0.3s, color 0.3s;
}

/* Style success button */
button.btn-success {
    background-color: #922B21;
    color: white;
}

/* Style danger button */
button.btn-danger {
    background-color: #922B21;
    color: white;
}

/* Hover effect for buttons */
button.btn-success:hover,
button.btn-danger:hover {
    background-color: #1e7e34; /* Darken success button */
    color: #fff; /* Change color to white on hover */
}


</style>

<body style="font-family: math;">
    <div class="sidebar">
        <div class="logo">
            <img src="img/core-img/aura_.png" alt="">
        </div>
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
        <div class="header--wrapper" >
            <div class="header--title">
                <span>Admin</span>
                <h2>Dashboard</h2>
            </div>
            <div class="user--info">
                
                <img src="" alt="">
            </div>
        </div>
        <div class="section1">
            <h3 style="color: #696969; font-size:20px;">Manage Products</h3>
            <br>
            <button id="addBtn">Add Products</button>
            <button id="viewBtn">View Products</button>
            <button id="catBtn">Add Category</button>
            <button id="subcateBtn">Add Subcategory</button>
            <br><br>

            <!-- Add Product Form Container -->
            <div id="addProductForm" class="form-container">
                <h4 style="color:#922B21">Add Product</h4><br>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" id="AddProductForm" method="POST" enctype="multipart/form-data">
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
    <h4 style="color:#922B21">View Products</h4><br>
    
    <table>
        <tr>
            <th>Product Name</th>
            <th>Description</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Category</th>
            <th>Subcategory</th>
            <th>Image</th> <!-- New th for the product image -->
            <th> </th>
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
                        <td>₹" . $row['price'] . "</td>
                        <td>" . $row['category_id'] . "</td>                                                  
                        <td>" . $row['subcategory_id'] . "</td>
                        <td><img src='img/product-img/" . $row['image'] . "'width=100' 'height=135'></td> <!-- Display image -->

                        <td>
                            <form action='' method='post'>
                                <button type='submit' name='act' class='btn btn-sm btn-success'><i class='fa fa-pencil' aria-hidden='true'></i></button><br><br>
                                <button type='submit' name='del' class='btn btn-sm btn-danger'><i class='fa fa-trash' aria-hidden='true'></i></button>
                            </form>
                        </td>
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

<!-- Add category form -->

<!-- Add category form -->
<div id="addCategoryForm" class="form-container" style="display: none;">
    <h4 style="color:#922B21">Add Category</h4><br>
    <form action="add_category.php" id="CategoryForm" method="POST" onclick="return validateCategoryForm();">
        <label for="categoryName">Category Name:</label>
        <input type="text" id="categoryName" name="categoryName" required><br>
        <div id="categoryError" style="color: #922B21; font-size: 12px; font-weight: bold; font-family: sans-serif;"></div><br> <!-- Container for error messages -->
        <input type="submit" value="Add" style="width:120px; height:50px">
    </form>
</div>

<script>
    function validateCategoryForm() {
        var categoryName = document.getElementById('categoryName').value.trim();
        var categoryError = document.getElementById('categoryError');
        categoryError.innerHTML = ''; // Clear previous error messages

        // Check if the categoryName is empty
        if (categoryName === '') {
            categoryError.innerHTML = '*Category Name cannot be empty.';
            return false;
        }

        // Check for repeated blank spaces
        if (/\s{2,}/.test(categoryName)) {
            categoryError.innerHTML = '*Repeated blank spaces are not allowed.';
            return false;
        }

        // Check if the categoryName contains numbers or special characters other than '-'
        if (/[^a-zA-Z-\s]/.test(categoryName)) {
            categoryError.innerHTML = '*Please enter valid category name.';
            return false;
        }

        return true; // Form is valid
    }
</script>

<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include your database connection file
    require_once "connect.php";

    // Retrieve form data and perform basic input validation
    $categoryName = $_POST['categoryName'] ?? ''; // Using the null coalescing operator to handle undefined index
    $categoryName = trim($categoryName); // Remove leading/trailing whitespace

    if (!empty($categoryName)) {
        // Prepare SQL statement (using prepared statement to prevent SQL injection)
        $stmt = $conn->prepare("INSERT INTO tbl_category (category_name) VALUES (?)");

        // Bind parameters and execute the statement
        $stmt->bind_param("s", $categoryName); // "s" indicates the parameter type (string)
        if ($stmt->execute()) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Category name is required";
    }

    // Close the connection
    $conn->close();
}
?>

<!-- Add subcategory form -->
<div id="addSubcategoryForm" class="form-container" style="display: none;">
    <h4 style="color:#922B21">Add Subcategory</h4><br>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" id="subCategoryForm" method="POST" onclick="return validateSubcategoryForm();">
        <label for="category">Category:</label>
        <select id="category" name="category" required>
            <option value="">Select Category</option>
            <option value="1">Women's Wear</option>
            <option value="2">Accessories</option>
            <option value="3">Footwear</option>
        </select>
        <div id="categoryError" class="error-message" style="color: #922B21;"></div><br><br>

        <label for="subcategoryName">Subcategory Name:</label>
        <input type="text" id="subcategoryName" name="subcategoryName" required>
        <div id="subcategoryNameError" class="error-message" style="color: #922B21;"></div><br><br>

        <input type="submit" value="Add" style="width:120px; height:50px">
    </form>
</div>

<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include your database connection file
    require_once "connect.php";

    // Sanitize and validate form data
    $subcategoryName = $_POST['subcategoryName'];
    $category = $_POST['category'];

    // Perform SQL insert
    $sql = "INSERT INTO tbl_subcate (subcategory_name, category_id) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "si", $subcategoryName, $category);

    if (mysqli_stmt_execute($stmt)) {
        // Insertion successful
        echo "<script>alert('Subcategory added successfully.')</script>";
    } else {
        // Insertion failed
        echo "<script>alert('Error: " . mysqli_error($conn) . "')</script>";
    }

    // Close statement and connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>

<script>
    function validateSubcategoryForm() {
        var category = document.getElementById('category').value;
        var subcategoryName = document.getElementById('subcategoryName').value.trim();
        var categoryError = document.getElementById('categoryError');
        var subcategoryNameError = document.getElementById('subcategoryNameError');
        categoryError.innerHTML = '';
        subcategoryNameError.innerHTML = '';

        // Check if a category is selected
        if (category === '') {
            categoryError.innerHTML = '*Please select a category.';
            return false;
        }

        // Check if the subcategoryName is empty
        if (subcategoryName === '') {
            subcategoryNameError.innerHTML = '*Subcategory Name cannot be empty.';
            return false;
        }

        // Check for repeated blank spaces
        if (/\s{2,}/.test(subcategoryName)) {
            subcategoryNameError.innerHTML = '*Repeated blank spaces are not allowed.';
            return false;
        }

        // Check if the subcategoryName contains numbers or special characters other than '-'
        if (/[^a-zA-Z-\s]/.test(subcategoryName)) {
            subcategoryNameError.innerHTML = '*Only alphabets, blank spaces, and "-" are allowed.';
            return false;
        }

        return true; // Form is valid
    }
</script>


<script>
    // Wrap all the code in an IIFE to prevent polluting the global scope
    (function () {
        // Define variables for DOM elements
        var addBtn = document.getElementById('addBtn');
        var viewBtn = document.getElementById('viewBtn');
        var catBtn = document.getElementById('catBtn');
        var subcateBtn = document.getElementById('subcateBtn');
        var addProductForm = document.getElementById('addProductForm');
        var viewProducts = document.getElementById('viewProducts');
        var addCategoryForm = document.getElementById('addCategoryForm');
        var addSubcategoryForm = document.getElementById('addSubcategoryForm');

        // Add event listeners using a function
        addBtn.addEventListener('click', showAddForm);
        viewBtn.addEventListener('click', showViewForm);
        catBtn.addEventListener('click', showCategoryForm);
        subcateBtn.addEventListener('click', showSubcategoryForm);

        // Function to show add product form
        function showAddForm() {
            showForm(addProductForm);
        }

        // Function to show view product form
        function showViewForm() {
            showForm(viewProducts);
        }

        // Function to show category form
        function showCategoryForm() {
            showForm(addCategoryForm);
        }

        // Function to show subcategory form
        function showSubcategoryForm() {
            showForm(addSubcategoryForm);
        }

        // Function to hide all forms and display the selected form
        function showForm(form) {
            addProductForm.style.display = 'none';
            viewProducts.style.display = 'none';
            addCategoryForm.style.display = 'none';
            addSubcategoryForm.style.display = 'none';

            form.style.display = 'block';
        }

        // Add more JavaScript functionality here, such as form submission handling

        // Function to toggle subcategories based on the selected category
        function toggleSubcategories() {
            var category = document.getElementById('category').value;
            var subcategories = document.getElementsByClassName('subcategories');

            // Hide all subcategories initially
            for (var i = 0; i < subcategories.length; i++) {
                subcategories[i].style.display = 'none';
            }

            // Show subcategories based on the selected main category
            document.getElementById('Subcategories' + category).style.display = 'block';
        }

        // Initialize event listeners for form validation
        document.addEventListener("DOMContentLoaded", function () {
            var productNameInput = document.getElementById("productName");
            var descriptionInput = document.getElementById("description");
            var quantityInput = document.getElementById("quantity");
            var priceInput = document.getElementById("price");
            var categoryInput = document.getElementById("category");

            productNameInput.addEventListener("blur", function () {
                validateField(productNameInput, validateProductNameFormat, "*Please enter a valid product name.");
            });

            descriptionInput.addEventListener("blur", function () {
                validateField(descriptionInput, validateDescriptionFormat, "*Please enter a valid description.");
            });

            quantityInput.addEventListener("blur", function () {
                validateField(quantityInput, validateQuantityFormat, "*Please enter a valid quantity.");
            });

            priceInput.addEventListener("blur", function () {
                validateField(priceInput, validatePriceFormat, "*Please enter a valid price.");
            });

            categoryInput.addEventListener("change", function () {
                validateField(categoryInput, validateCategoryFormat, "*Please select a category.");
            });
        });

        // Function to validate a field
        function validateField(inputField, validationFunction, errorMessage) {
            var value = inputField.value.trim();
            if (!validationFunction(value)) {
                displayErrorMessage(errorMessage, inputField);
            } else {
                clearErrorMessage(inputField);
            }
        }

        // Validation functions
        function validateProductNameFormat(productName) {
            return /^[a-zA-Z\s]*$/.test(productName) && !/\s{2,}/.test(productName);
        }

        function validateDescriptionFormat(description) {
            return description.trim() !== '' && !/\s{2,}/.test(description);
        }

        function validateQuantityFormat(quantity) {
        return !isNaN(quantity) && parseInt(quantity) > 0;
        }   


        function validatePriceFormat(price) {
            return !isNaN(price) && parseFloat(price) > 0;
        }

        function validateCategoryFormat(category) {
            return category !== "";
        }

        // Function to display error messages
        function displayErrorMessage(message, inputField) {
            clearErrorMessage(inputField); // Clear existing errors
            var errorMessageElement = document.createElement('div');
            errorMessageElement.classList.add('error-message');
            errorMessageElement.textContent = message;

            // Apply styles to the error message element
            errorMessageElement.style.color = '#922B21'; // Change color to red
            errorMessageElement.style.fontWeight = 'bold'; // Set font weight to bold
            errorMessageElement.style.fontSize = '13px'; // Adjust font size
            errorMessageElement.style.fontFamily = 'Sans Serif'; // Change font-family

            inputField.parentNode.insertBefore(errorMessageElement, inputField.nextSibling);
        }

        // Function to clear error messages
        function clearErrorMessage(inputField) {
            var errorMessage = inputField.parentNode.querySelector('.error-message');
            if (errorMessage) {
                errorMessage.remove();
            }
        }
    })();

    
</script>



    
    </div>
</body>

</html>
