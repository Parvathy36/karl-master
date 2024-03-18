<?php
session_start();

// Redirect if the user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Include the database connection file
require_once "connect.php";

// Initialize variables
$errorMessage = "";
$productDetails = [];

// Fetch categories and their subcategories
$categories = [];
$queryCategories = "SELECT * FROM tbl_category";
$resultCategories = mysqli_query($conn, $queryCategories);

if ($resultCategories && mysqli_num_rows($resultCategories) > 0) {
    while ($row = mysqli_fetch_assoc($resultCategories)) {
        $categoryId = $row['category_id'];
        $categories[$categoryId] = $row;

        // Fetch subcategories for each category
        $subQuery = "SELECT * FROM tbl_subcate WHERE category_id = $categoryId";
        $subResult = mysqli_query($conn, $subQuery);

        $subcategories = [];
        while ($subRow = mysqli_fetch_assoc($subResult)) {
            $subcategories[] = $subRow;
        }

        // Assign subcategories to each category
        $categories[$categoryId]['subcategories'] = $subcategories;
    }
} else {
    $errorMessage = "Error fetching categories. Please try again later.";
}

// Fetch product details for updating
if(isset($_GET['p_id']) && !empty($_GET['p_id'])) {
    $productId = $_GET['p_id'];
    $productQuery = "SELECT * FROM tbl_products WHERE p_id = $productId";
    $productResult = mysqli_query($conn, $productQuery);

    if($productResult && mysqli_num_rows($productResult) > 0) {
        $productDetails = mysqli_fetch_assoc($productResult);
    } else {
        $errorMessage = "Product not found.";
    }
}
// Handle form submission for updating product
if(isset($_POST['Update'])) {
    // Retrieve form data
    $productName = mysqli_real_escape_string($conn, $_POST['productName']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = floatval($_POST['price']);
    $category = intval($_POST['category']);
    $subcategory = intval($_POST['subcategory']);
    // Check if a new image file has been uploaded
    if(isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        // Process the uploaded image file
        $image = $_FILES['image']['name']; // Get the name of the uploaded file
        $image_temp = $_FILES['image']['tmp_name']; // Get the temporary location of the file

        // Move the uploaded file to the desired location
        $target_directory = "img/product-img/"; // Specify the directory where you want to store uploaded images
        $target_file = $target_directory . basename($image);

        if(move_uploaded_file($image_temp, $target_file)) {
            // File uploaded successfully, proceed with the update query
            $updateQuery = "UPDATE tbl_products 
                            SET p_name = '$productName', 
                                description = '$description',  
                                price = '$price', 
                                category_id = '$category', 
                                subcategory_id = '$subcategory',
                                image = '$image' 
                            WHERE p_id = $productId";

            $updateResult = mysqli_query($conn, $updateQuery);

            if($updateResult) {
                // Redirect after updating
                header("Location: adminproductrec.php");
                exit();
            } else {
                // Handle update failure
                $errorMessage = "Failed to update product. Please try again.";
            }
        } else {
            // Failed to move the uploaded file
            $errorMessage = "Failed to upload the image file.";
        }
    } else {
        // No new image file uploaded, proceed with updating other fields
        $updateQuery = "UPDATE tbl_products 
                        SET p_name = '$productName', 
                            description = '$description',
                            price = '$price', 
                            category_id = '$category', 
                            subcategory_id = '$subcategory'
                        WHERE p_id = $productId";

        $updateResult = mysqli_query($conn, $updateQuery);

        if($updateResult) {
            // Redirect after updating
            header("Location: adminproductrec.php");
            exit();
        } else {
            // Handle update failure
            $errorMessage = "Failed to update product. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product</title>
    <style>
        /* Add your CSS styles here */
    </style>
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
    .header{
        border-radius: 5px;
        background-color: #922D21;
        text-decoration: none;
        text-align: center;
        margin-bottom: 50px;
        height: 100px;
        margin-top: 10px;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    /* CSS for the Previous Page link */
    .previous-page-link { 
            border-radius: 5px;
            background-color: #922D21;
            text-decoration: none;
            text-align: center;
            margin-bottom: 20px;
            height: 50px;
            margin-top: 50px;
        }
    /* Form container styles */
#updateProductForm {
    background-color: #f9f9f9;
    padding: 20px;
    border-radius: 8px;
    margin: 20px auto;
    max-width: 80%;
    height: auto;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

/* Form label styles */
label {
    color: #333;
    font-size: 16px;
    margin-bottom: 8px;
    display: block;
}

/* Form input styles */
input[type="text"],
input[type="number"],
textarea,
select {
    width: 100%;
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    font-size: 16px;
}

/* Form submit button styles */
input[type="submit"] {
    background-color: #922B21;
    color: white;
    padding: 12px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s;
    font-size: 16px;
}

/* Form submit button hover effect */
input[type="submit"]:hover {
    background-color: #D89992;
}

/* Error message style */
.error-message {
    color: red;
    font-size: 14px;
    margin-top: 10px;
}

/* Heading style */
h4 {
    color: #922B21;
    font-size: 24px;
    margin-bottom: 20px;
}

/* Subcategory container style */
.subcategories {
    margin-top: 10px;
}

</style>
<body>
    <div class= "header">
        <h4 style="color: white; margin-top: 10px; padding: 10px;">Update Product</h4><br>
    </div>
     
    <div id="updateProductForm">
        <?php if (!empty($errorMessage)): ?>
            <p style="color: red;"><?php echo $errorMessage; ?></p>
        <?php endif; ?>
        <form action="" id="UpdateProductForm" method="POST" enctype="multipart/form-data">
            <label for="productName">Product Name:</label>
            <input type="text" id="productName" name="productName" value="<?php echo isset($productDetails['p_name']) ? $productDetails['p_name'] : ''; ?>" required><br><br>

            <label for="description">Description:</label>
            <textarea id="description" name="description" required><?php echo isset($productDetails['description']) ? $productDetails['description'] : ''; ?></textarea><br><br>

            <label for="price">Price:</label>
            <input type="number" id="price" name="price" value="<?php echo isset($productDetails['price']) ? $productDetails['price'] : ''; ?>" step="0.01" min="0" required><br><br>

            <label for="category">Category:</label>
            <select id="category" name="category" required onchange="toggleSubcategories()">
                <option value="">Select Category</option>
                <?php foreach ($categories as $categoryId => $category) { ?>
                    <option value="<?php echo $categoryId; ?>" <?php echo isset($productDetails['category_id']) && $productDetails['category_id'] == $categoryId ? 'selected' : ''; ?>><?php echo $category['category_name']; ?></option>
                <?php } ?>
            </select><br><br>

            <?php foreach ($categories as $categoryId => $category) { ?>
                <div id="Subcategories<?php echo $categoryId; ?>" class="subcategories" style="display: none;">
                    <label for="subcategory">Subcategory:</label>
                    <select id="subcategory" name="subcategory">
                        <option value="">Select Subcategory</option>
                        <?php foreach ($category['subcategories'] as $subcategory) { ?>
                            <option value="<?php echo $subcategory['subcategory_id']; ?>" <?php echo isset($productDetails['subcategory_id']) && $productDetails['subcategory_id'] == $subcategory['subcategory_id'] ? 'selected' : ''; ?>><?php echo $subcategory['subcategory_name']; ?></option>
                        <?php } ?>
                    </select><br><br>
                </div>
            <?php } ?>

            <label for="image">Product Image:</label>
            <!-- Display the current product image if available -->
            <?php if (isset($productDetails['image'])) { ?>
            
            <!-- Allow user to upload a new image if needed -->
            <input type="file" id="image" name="image" accept="<?php echo $productDetails['image']; ?>"><br><br>
            <?php } ?>

            <input type="submit" value="Update" name="Update" style="width:120px; height:50px">
        </form>
    </div>
    <!-- Previous page link outside the form -->
    <div style="padding: 10px; display: flex; justify-content: center; align-items: center;" class="previous-page-link">
        <a href="javascript:history.go(-1);" style="color: white; text-decoration: none; ">Back to Dashboard</a>
    </div>
</body>
</html>
