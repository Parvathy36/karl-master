<?php
session_start();

// Redirect if the user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Include the database connection file
require_once "connect.php";

// Check if category ID is provided in the URL
if (isset($_GET['category_id'])) {
    $category_id = $_GET['category_id'];

    // Check if the form is submitted
    if (isset($_POST['Update'])) {
        // Retrieve the updated category name from the form
        $categoryName = $_POST['categoryName'];

        // Update the category in the database
        $update_query = "UPDATE tbl_category SET category_name='$categoryName' WHERE category_id='$category_id'";

        if (mysqli_query($conn, $update_query)) {
            // Category updated successfully
            echo "<script>alert('Category updated successfully');</script>";
        } else {
            // Error updating category
            echo "<script>alert('Error updating category: " . mysqli_error($conn) . "');</script>";
        }
    }

    // Fetch the category name associated with the category ID
    $select_query = "SELECT category_name FROM tbl_category WHERE category_id='$category_id'";
    $result = mysqli_query($conn, $select_query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $categoryName = $row['category_name'];
    } else {
        // Handle error if category ID is invalid or not found
        echo "<script>alert('Category not found');</script>";
        // Redirect to the previous page if category ID is not valid
        header("Location: admineditcategory.php");
        exit();
    }
} else {
    // Redirect to the previous page if category ID is not provided
    header("Location: admineditcategory.php");
    exit();
}

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
#updateCategoryForm {
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
     
    <div id="updateCategoryForm">
        
        <form action="" id="UpdateCategoryForm" method="POST" enctype="multipart/form-data">

            <label for="categoryName">Category Name:</label>
            <input type="text" id="categoryName" name="categoryName" value="<?php echo isset($categoryName) ? $categoryName : ''; ?>" required><br>

            <input type="submit" value="Update" name="Update" style="width:120px; height:50px">
        </form>
    </div>
    <!-- Previous page link outside the form -->
    <div style="padding: 10px; display: flex; justify-content: center; align-items: center;" class="previous-page-link">
        <a href="javascript:history.go(-1);" style="color: #922D21; text-decoration: none; font-weight: bold; ">Back to Dashboard</a>
    </div>
</body>
</html>
