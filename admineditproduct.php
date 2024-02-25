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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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

</style>
<body>
    <!-- Add Product Form Container -->
    <div id="addProductForm" class="form-container">
                <h4 style="color:#922B21">Add Product</h4><br>
                <form action="" id="AddProductForm" method="GET" enctype="multipart/form-data">
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

</body>
</html>