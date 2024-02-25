<?php
session_start();

if (isset($_SESSION['username'])) {
    $user = $_SESSION['username'];
} else {
    // Redirect the user to the login page if not logged in
    header("Location: login.php");
    exit();
}
?>
<?php
require_once "connect.php";



if(isset($_POST['Add'])) {
    // Check if required fields are not empty
    if (!empty($_POST['productName']) && !empty($_POST['description']) && !empty($_POST['quantity']) && !empty($_POST['price']) && !empty($_POST['category'])) {
        $productName = mysqli_real_escape_string($conn, $_POST['productName']);
        $description = mysqli_real_escape_string($conn, $_POST['description']);
        $quantity = (int)$_POST['quantity'];
        $price = (float)$_POST['price'];
        $category_id = (int)$_POST['category'];
        $subcategory_id = null; // Initialize subcategory_id

        // Determine the subcategory based on the selected category
        if ($category_id >= 1 && $category_id <= 3) {
            $subcat_key = 'Subcategory'.$category_id;
            if(isset($_POST[$subcat_key])){
                $subcategory_id = (int)$_POST[$subcat_key];
            }
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
                $alert_message = 'Product added successfully.';
            } else {
                $alert_message = 'Error: ' . mysqli_stmt_error($stmt);
            }
            mysqli_stmt_close($stmt);
        } else {
            $alert_message = 'Error: Unable to prepare statement: ' . mysqli_error($conn);
        }
    } else {
        $alert_message = 'Error: Required fields are empty.';
    }
}

// JavaScript code for displaying alert message
// echo "<script>";
// echo "alert('$alert_message');";
// echo "window.location.href = 'adminproductrec.php';";
// echo "</script>";
?>

<?php

// Fetch categories
$query = "SELECT * FROM tbl_category";
$result = mysqli_query($conn, $query);

$categories = array();
while ($row = mysqli_fetch_assoc($result)) {
    $categoryId = $row['category_id'];
    $categories[$categoryId] = $row;
}

// Fetch subcategories for each category
foreach ($categories as $categoryId => $category) {
    $subQuery = "SELECT * FROM tbl_subcate WHERE category_id = $categoryId";
    $subResult = mysqli_query($conn, $subQuery);

    $subcategories = array();
    while ($subRow = mysqli_fetch_assoc($subResult)) {
        $subcategories[] = $subRow;
    }

    // Assign subcategories to each category
    $categories[$categoryId]['subcategories'] = $subcategories;
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
    <script>
        function toggleSubcategories() {
            var category = document.getElementById("category");
            var categoryId = category.value;
            var subcategories = document.querySelectorAll(".subcategories");

            subcategories.forEach(function (element) {
                element.style.display = "none";
            });

            var selectedSubcategory = document.getElementById("Subcategories" + categoryId);
            if (selectedSubcategory) {
                selectedSubcategory.style.display = "block";
            }
        }
    </script>
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

#addBtn, #viewBtn, #subcateBtn, #catBtn, #viewcateBtn {
    width: 18%;
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

#addBtn:hover, #viewBtn:hover, #subcateBtn:hover, #catBtn:hover, #viewcateBtn:hover {
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

.categoryListContainer {
    display: flex; /* Hide the category list container by default */
    background-color: #f4f4f4;
    padding: 20px;
    border-radius: 5px;
    margin-top: 10px;
    width: 100%; /* Adjust the width of the container */
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

.categoryListContainer {
    display: flex; /* Use flexbox layout */
    justify-content: space-between; /* Distribute items evenly */
    margin-bottom: 20px; /* Add some space between the containers */
}

.categoryListContainer table {
    width: 45%; /* Adjust width as needed */
}

.categoryListContainer h4 {
    color: #922B21;
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
            <li><a href="adminmanagetip.php"><i class="fas fa-lightbulb"></i>
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
                
            <i class="fa fa-user" aria-hidden="true"></i><?php echo $user ?>
            </div>
        </div>
        <div class="section1">
            <h3 style="color: #696969; font-size:20px;">Manage Products</h3>
            <br>
            <button id="addBtn">Add Products</button>
            <button id="viewBtn">View Products</button>
            <button id="catBtn">Add Category</button>
            <button id="subcateBtn">Add Subcategory</button>
            <button id="viewcateBtn">View Category</button>
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
                <?php foreach ($categories as $categoryId => $category) { ?>
                    <option value="<?php echo $categoryId; ?>"><?php echo $category['category_name']; ?></option>
                <?php } ?>
            </select><br><br>

            <?php foreach ($categories as $categoryId => $category) { ?>
                <div id="Subcategories<?php echo $categoryId; ?>" class="subcategories" style="display: none;">
                    <label for="Subcategory<?php echo $categoryId; ?>">Subcategory:</label>
                    <select id="Subcategory<?php echo $categoryId; ?>" name="Subcategory<?php echo $categoryId; ?>">
                        <option value="">Select Subcategory</option>
                        <?php foreach ($category['subcategories'] as $subcategory) { ?>
                            <option value="<?php echo $subcategory['subcategory_id']; ?>"><?php echo $subcategory['subcategory_name']; ?></option>
                        <?php } ?>
                    </select><br><br>
                </div>
            <?php } ?>

        <label for="image">Product Image:</label>
        <input type="file" id="image" name="image" accept="image/*" required><br><br>

        <input type="submit" value="Add" name="Add" style="width:120px; height:50px">
    </form>
            </div>

            <!-- View Products Container -->
<div id="viewProducts" class="products-container">
    <h4 style="color:#922B21">View Products</h4><br>
    
    <table>
        <tr>
            <th>Sl no.</th>
            <th>Product Name</th>
            <th>Description</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Category</th>
            <th>Subcategory</th>
            <th>Image</th> <!-- New th for the product image -->
            <th>Actions</th>
        </tr>
        <!-- Fetch products from the database and display them in the table -->
        <?php
        require_once 'connect.php';
        
        // Perform SQL query to fetch products
        $sql = "SELECT 
            p.p_name, 
            p.description, 
            p.qty, 
            p.price, 
            c.category_name, 
            s.subcategory_name, 
            p.image 
        FROM tbl_products p 
        LEFT JOIN tbl_category c ON p.category_id = c.category_id 
        LEFT JOIN tbl_subcate s ON p.subcategory_id = s.subcategory_id";
        $result = mysqli_query($conn, $sql);
        $sl=0;
        if (mysqli_num_rows($result) > 0) {
            // Output data of each row
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td> ".++$sl."</td>
                        <td>" . $row['p_name'] . "</td>
                        <td>" . $row['description'] . "</td>
                        <td>" . $row['qty'] . "</td>
                        <td>₹" . $row['price'] . "</td>
                        <td>" . $row['category_name'] . "</td>                                                  
                        <td>" . $row['subcategory_name'] . "</td>
                        <td><img src='img/product-img/" . $row['image'] . "' width='100' height='135'></td> <!-- Display image -->
        
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
        // mysqli_close($result);
        ?>
    </table>
</div>


<!-- Add category form -->
<div id="addCategoryForm" class="form-container" style="display: none;">
    <h4 style="color:#922B21">Add Category</h4><br>
    <form action="#" id="CategoryForm" method="POST">
        <label for="categoryName">Category Name:</label>
        <input type="text" id="categoryName" name="categoryName" required><br>
        <div id="categoryError" style="color: #922B21; font-size: 12px; font-weight: bold; font-family: sans-serif;"></div><br> <!-- Container for error messages -->
        <input type="submit" value="Add" name="addcate" style="width:120px; height:50px">
    </form>
</div>

<?php
// Include the database connection
require_once("connect.php");

// Check if the form is submitted
if(isset($_POST['addcate'])) {
    // Validate and sanitize the input
    if (!empty($_POST["categoryName"])) {
        $categoryName = $_POST["categoryName"];
        // Prepare SQL statement to insert data into tbl_category
        $sql = "INSERT INTO `tbl_category` (`category_name`) VALUES (?)";

        // Prepare and bind parameters
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die('Error: ' . $conn->error); // Handle preparation error
        }
        $stmt->bind_param("s", $categoryName);
        
        // Execute the statement
        if ($stmt->execute() === TRUE) {
            $alert_message = 'New record created successfully.';
        } else {
            $alert_message = 'Error: ' . $conn->error;
        }

        // Close statement
        $stmt->close();
    } else {
        $alert_message = 'Category name cannot be empty.';
    }
}

// JavaScript code for displaying alert message
echo "<script>";
echo "alert('$alert_message');";
echo "window.location.href = 'adminproductrec.php';";
echo "</script>";
?>



<!-- Add subcategory form -->
<div id="addSubcategoryForm" class="form-container" style="display: none;">
    <h4 style="color:#922B21">Add Subcategory</h4><br>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" id="subCategoryForm" method="POST" >
        <label for="category1">Category:</label>
        <select id="category" name="category" required onchange="toggleSubcategories()">
                <option value="">Select Category</option>
                <?php foreach ($categories as $categoryId => $category) { ?>
                    <option value="<?php echo $categoryId; ?>"><?php echo $category['category_name']; ?></option>
                <?php } ?>
            </select>
        <div id="categoryError" class="error-message" style="color: #922B21;"></div><br><br>

        <label for="subcategoryName">Subcategory Name:</label>
        <input type="text" id="subcategoryName" name="subcategoryName" required>
        <div id="subcategoryNameError" class="error-message" style="color: #922B21;"></div><br><br>

        <input type="submit" value="Add" name="addsubcat" style="width:120px; height:50px">
    </form>
</div>

<?php
// Include the database connection
require_once("connect.php");

// Check if the form is submitted
if(isset($_POST['addsubcat'])) {
    // Validate and sanitize the input
    if (!empty($_POST["subcategoryName"]) && !empty($_POST["category"])) {
        $subcategoryName = $_POST["subcategoryName"];
        $categoryId = $_POST["category"];

        // Prepare SQL statement to insert data into tbl_subcate
        $sql = "INSERT INTO `tbl_subcate` (`subcategory_name`, `category_id`) VALUES (?, ?)";

        // Prepare and bind parameters
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die('Error: ' . $conn->error); // Handle preparation error
        }
        $stmt->bind_param("si", $subcategoryName, $categoryId);
        
        // Execute the statement
        if ($stmt->execute() === TRUE) {
            $alert_message = 'New subcategory created successfully.';
        } else {
            $alert_message = 'Error: ' . $conn->error;
        }

        // Close statement
        $stmt->close();
    } else {
        $alert_message = 'Subcategory name and category selection are required.';
    }

    // JavaScript code for displaying alert message
    echo "<script>";
    echo "alert('$alert_message');";
    echo "window.location.href = 'adminproductrec.php';";
    echo "</script>";
}
?>



<?php
include 'connect.php';
// Fetch and display category list from tbl_category
$sql_categories = "SELECT category_name FROM tbl_category";
$result_categories = mysqli_query($conn, $sql_categories);

// Fetch and display subcategory data from tbl_subcate
$sql_subcategories = "SELECT s.subcategory_name, c.category_name FROM tbl_subcate s LEFT JOIN tbl_category c ON s.category_id = c.category_id ";
$result_subcategories = mysqli_query($conn, $sql_subcategories);
mysqli_close($conn);
?>

<!-- Display category list -->
<div id="categoryListContainer" class="categoryListContainer" style="display:none;">
    <h4 style="color:#922B21">Category List</h4><br>
    <table>
        <tr>
            <th>Sl no.</th>
            <th>Category Name</th>
            <th>Actions</th>
        </tr>
        <?php
        $sl = 0;
        if (mysqli_num_rows($result_categories) > 0) {
            while ($row = mysqli_fetch_assoc($result_categories)) {
                echo "<tr>
                        <td> ".++$sl."</td>
                        <td>" . $row['category_name'] . "</td>
                        <td>
                            <form action='' method='post'>
                                <button type='submit' name='act' class='btn btn-sm btn-success'><i class='fa fa-pencil' aria-hidden='true'></i></button><br><br>
                                <button type='submit' name='del' class='btn btn-sm btn-danger'><i class='fa fa-trash' aria-hidden='true'></i></button>
                            </form>
                        </td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='2'>No categories found</td></tr>";
        }
        ?>
    </table>
</div>

<!-- Display subcategory data -->
<div id="subcategoryListContainer" class="categoryListContainer" style="display:none;">
    <h4 style="color:#922B21">Subcategory List</h4><br>
    <table>
        <tr>
            <th>Sl no.</th>
            <th>Subcategory Name</th>
            <th>Category Nmae</th>
            <th>Actions</th> <!-- Changed from an empty header -->
        </tr>
        <?php
        $sl = 0;
        if (mysqli_num_rows($result_subcategories) > 0) {
            while ($row = mysqli_fetch_assoc($result_subcategories)) {
                echo "<tr>
                        <td> ". ++$sl ."</td>
                        <td>" . $row['subcategory_name'] . "</td>
                        <td>" . $row['category_name'] . "</td>
                        <td>
                            <form action='' method='post'>
                                <button type='submit' name='act' class='btn btn-sm btn-success'><i class='fa fa-pencil' aria-hidden='true'></i></button><br><br>
                                <button type='submit' name='del' class='btn btn-sm btn-danger'><i class='fa fa-trash' aria-hidden='true'></i></button>
                            </form>
                        </td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No subcategories found</td></tr>";
        }
        ?>
    </table>
</div>



<script>
// Wrap all the code in an IIFE to prevent polluting the global scope
(function () {
    // Define variables for DOM elements
    var addBtn = document.getElementById('addBtn');
    var viewBtn = document.getElementById('viewBtn');
    var catBtn = document.getElementById('catBtn');
    var subcateBtn = document.getElementById('subcateBtn');
    var viewcateBtn = document.getElementById('viewcateBtn');
    var addProductForm = document.getElementById('addProductForm');
    var viewProducts = document.getElementById('viewProducts');
    var addCategoryForm = document.getElementById('addCategoryForm');
    var addSubcategoryForm = document.getElementById('addSubcategoryForm');
    var categoryListContainer = document.getElementById('categoryListContainer');
    var subcategoryListContainer = document.getElementById('subcategoryListContainer'); // Added this line

    // Add event listeners using a function
    addBtn.addEventListener('click', function () {
        showForm(addProductForm);
    });
    viewBtn.addEventListener('click', function () {
        showForm(viewProducts);
    });
    catBtn.addEventListener('click', function () {
        showForm(addCategoryForm);
    });
    subcateBtn.addEventListener('click', function () {
        showForm(addSubcategoryForm);
    });
    viewcateBtn.addEventListener('click', function () {
        // Hide other containers
        addProductForm.style.display = 'none';
        viewProducts.style.display = 'none';
        addCategoryForm.style.display = 'none';
        addSubcategoryForm.style.display = 'none';

        // Show category list container
        categoryListContainer.style.display = 'block';
        // Show subcategory list container
        subcategoryListContainer.style.display = 'block';
    });

    // Function to hide all forms and display the selected form
    function showForm(form) {
        addProductForm.style.display = 'none';
        viewProducts.style.display = 'none';
        addCategoryForm.style.display = 'none';
        addSubcategoryForm.style.display = 'none';
        categoryListContainer.style.display = 'none';
        subcategoryListContainer.style.display = 'none';


        form.style.display = 'block';
    }
})();
        
        document.addEventListener("DOMContentLoaded", function () {
    var form = document.getElementById("AddProductForm");

    form.addEventListener("submit", function (event) {
        var productNameInput = document.getElementById("productName");
        var descriptionInput = document.getElementById("description");
        var quantityInput = document.getElementById("quantity");
        var priceInput = document.getElementById("price");
        var categoryInput = document.getElementById("category");
        var imageInput = document.getElementById("image");

        var isValid = true;

        if (!validateField(productNameInput, validateProductNameFormat, "*Please enter a valid product name.")) {
            isValid = false;
        }
        if (!validateField(descriptionInput, validateDescriptionFormat, "*Please enter a valid description.")) {
            isValid = false;
        }
        if (!validateField(quantityInput, validateQuantityFormat, "*Please enter a valid quantity.")) {
            isValid = false;
        }
        if (!validateField(priceInput, validatePriceFormat, "*Please enter a valid price.")) {
            isValid = false;
        }
        if (!validateField(categoryInput, validateCategoryFormat, "*Please select a category.")) {
            isValid = false;
        }
        if (!validateImage(imageInput)) {
            isValid = false;
        }

        if (!isValid) {
            event.preventDefault(); // Prevent form submission
        }
    });

    var fieldsToValidate = [
        { input: document.getElementById("productName"), validationFunction: validateProductNameFormat, errorMessage: "*Please enter a valid product name." },
        { input: document.getElementById("description"), validationFunction: validateDescriptionFormat, errorMessage: "*Please enter a valid description." },
        { input: document.getElementById("quantity"), validationFunction: validateQuantityFormat, errorMessage: "*Please enter a valid quantity." },
        { input: document.getElementById("price"), validationFunction: validatePriceFormat, errorMessage: "*Please enter a valid price." },
        { input: document.getElementById("category"), validationFunction: validateCategoryFormat, errorMessage: "*Please select a category." },
        { input: document.getElementById("image"), validationFunction: validateImage, errorMessage: "*Please select an image." }
    ];

    fieldsToValidate.forEach(function (field) {
        field.input.addEventListener("blur", function () {
            validateField(field.input, field.validationFunction, field.errorMessage);
        });
    });

    function validateField(inputField, validationFunction, errorMessage) {
        var value = inputField.value.trim();
        if (!validationFunction(value)) {
            displayErrorMessage(errorMessage, inputField);
            return false;
        } else {
            clearErrorMessage(inputField);
            return true;
        }
    }

    function validateImage(imageInput) {
        var file = imageInput.files[0];
        var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i; 

        if (!file) {
            displayErrorMessage("*Please select an image.", imageInput);
            return false;
        }

        if (!allowedExtensions.test(file.name)) {
            displayErrorMessage("*Supported image formats: JPEG, JPG, PNG", imageInput);
            return false;
        } 

        clearErrorMessage(imageInput);
        return true;
    }

    function displayErrorMessage(message, inputField) {
        clearErrorMessage(inputField); 
        var errorMessageElement = document.createElement('div');
        errorMessageElement.classList.add('error-message');
        errorMessageElement.style.color = '#922B21'; 
        errorMessageElement.style.fontWeight = 'bold'; 
        errorMessageElement.style.fontSize = '13px'; 
        errorMessageElement.style.fontFamily = 'Sans Serif';
        errorMessageElement.textContent = message;
        inputField.parentNode.insertBefore(errorMessageElement, inputField.nextSibling);
    }

    function clearErrorMessage(inputField) {
        var errorMessage = inputField.parentNode.querySelector('.error-message');
        if (errorMessage) {
            errorMessage.remove();
        }
    }

    function validateProductNameFormat(productName) {
        return /^[a-zA-Z\s]*$/.test(productName) && !/\s{2,}/.test(productName);
    }

    function validateDescriptionFormat(description) {
        return description.trim() !== '' && !/\s{2,}/.test(description);
    }

    // Function to validate the format of the quantity
function validateQuantityFormat(quantity) {
    // Check if the quantity is a valid positive integer and has less than 6 digits
    return /^\d{1,5}$/.test(quantity) && Number.isInteger(parseFloat(quantity)) && parseInt(quantity) > 0;
}


    function validatePriceFormat(price) {
        return !isNaN(price) && parseFloat(price) > 0;
    }

    function validateCategoryFormat(category) {
        return category !== "";
    }

});



document.addEventListener("DOMContentLoaded", function () {
    var categoryNameInput = document.getElementById("categoryName");
    var category1Input = document.getElementById("category1");
    var subcategoryNameInput = document.getElementById("subcategoryName");

    if (categoryNameInput) {
        categoryNameInput.addEventListener("blur", function () {
            validateName(categoryNameInput, "*Invalid category name format.");
        });
    }

    if (category1Input) {
        category1Input.addEventListener("change", function () {
            validateCategory1(category1Input);
        });
    }

    if (subcategoryNameInput) {
        subcategoryNameInput.addEventListener("blur", function () {
            validateName(subcategoryNameInput, "*Invalid subcategory name format.");
        });
    }

    function validateName(inputField, errorMessageText) {
        var inputValue = inputField.value.trim();
        if (!isValidName(inputValue)) {
            displayErrorMessage(errorMessageText, inputField);
        } else {
            clearErrorMessage(inputField);
        }
    }

    function isValidName(name) {
        return /^[a-zA-Z\s]*$/.test(name) && !/\s{2,}/.test(name);
    }

    function validateCategory1(category1Input) {
        var category1 = category1Input.value.trim();
        if (!category1) {
            displayErrorMessage("*Please select a category.", category1Input);
        } else {
            clearErrorMessage(category1Input);
        }
    }

    function displayErrorMessage(message, inputField) {
        clearErrorMessage(inputField); 
        var errorMessageElement = document.createElement('div');
        errorMessageElement.classList.add('error-message');
        errorMessageElement.style.color = '#922B21'; 
        errorMessageElement.style.fontWeight = 'bold'; 
        errorMessageElement.style.fontSize = '13px'; 
        errorMessageElement.style.fontFamily = 'Sans Serif'; 
        errorMessageElement.textContent = message;
        inputField.parentNode.insertBefore(errorMessageElement, inputField.nextSibling);
    }

    function clearErrorMessage(inputField) {
        var errorMessage = inputField.parentNode.querySelector('.error-message');
        if (errorMessage) {
            errorMessage.remove();
        }
    }
});

</script>
   
    </div>
</body>

</html>
