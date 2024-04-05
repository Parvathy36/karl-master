<?php
session_start();

// Redirect if the user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Include the database connection file
require_once "connect.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['Update'])) {
    // Retrieve form data after sanitizing
    $subcategory_id = filter_input(INPUT_POST, 'subcategory_id', FILTER_SANITIZE_NUMBER_INT);
    $subcategory_name = filter_input(INPUT_POST, 'subcategoryName', FILTER_SANITIZE_STRING);
    $category_id = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_NUMBER_INT);

    // Prepare and execute update query
    $update_query = "UPDATE tbl_subcate SET subcategory_name=?, category_id=? WHERE subcategory_id=?";
    $stmt = mysqli_prepare($conn, $update_query);
    mysqli_stmt_bind_param($stmt, "sii", $subcategory_name, $category_id, $subcategory_id);
    
    if (mysqli_stmt_execute($stmt)) {
        // Subcategory updated successfully
        echo "<script>alert('Subcategory updated successfully');</script>";
    } else {
        // Error updating subcategory
        echo "<script>alert('Error updating subcategory: " . mysqli_error($conn) . "');</script>";
    }
    mysqli_stmt_close($stmt);
}


// Fetch categories from the database
$sql_categories = "SELECT category_id, category_name FROM tbl_category";
$result_categories = mysqli_query($conn, $sql_categories);
$categories = [];

// Store categories in an associative array
while ($row = mysqli_fetch_assoc($result_categories)) {
    $categories[$row['category_id']] = $row['category_name'];
}

// Close the database connection
mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product</title>
  
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
            text-decoration: none;
            text-align: center;
            margin-bottom: 20px;
            height: 50px;
            margin-top: 50px;
        }
    /* Form container styles */
#updateSubcategoryForm {
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
        <h4 style="color: white; margin-top: 10px; padding: 10px;">Update Category</h4><br>
    </div>
     
    <div id="updateSubcategoryForm">
        
        <form action="" id="UpdateSubcategoryForm" method="POST" enctype="multipart/form-data">

        <label for="category1">Category:</label>
        <select id="category" name="category" required onchange="toggleSubcategories()">
            <option value="">Select Category</option>
            <?php foreach ($categories as $categoryId => $categoryName) { ?>
                <option value="<?php echo $categoryId; ?>"><?php echo $categoryName; ?></option>
            <?php } ?>
        </select>
        <div id="categoryError" class="error-message" style="color: #922B21;"></div><br><br>

        <label for="subcategoryName">Subcategory Name:</label>
        <input type="text" id="subcategoryName" name="subcategoryName" required>

            <input type="submit" value="Update" name="Update" style="width:120px; height:50px">
        </form>
    </div>
    <!-- Previous page link outside the form -->
    <div style="padding: 10px; display: flex; justify-content: center; align-items: center;" class="previous-page-link">
        <a href="javascript:history.go(-1);" style="color: #922D21; text-decoration: none; font-weight: bold; ">Back to Dashboard</a>
    </div>
</body>
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
</html>
