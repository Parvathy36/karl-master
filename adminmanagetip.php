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

#addBtn, #viewBtn {
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

#addBtn:hover, #viewBtn:hover {
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
            <li><a href="adminproductrec.php"><i class="fas fa-store"></i>
                    <span>Manage Products</span></a>
            </li>
            <li class="active"><a href="adminmanagetip.php"><i class="fas fa-lightbulb"></i>
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
            <button id="addBtn">Add style tips</button>
            <button id="viewBtn">View tips</button>
            <br><br>

            <!-- Add Product Form Container -->
            <div id="addstyletipForm" class="form-container">
                <h4 style="color:#922B21">Add Style Tips</h4><br>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" id="AddstyletipForm" method="POST" enctype="multipart/form-data">
        <label for="image">Product Image:</label>
        <input type="file" id="image" name="image" accept="image/*" required><br><br>

        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea><br><br>

        <input type="submit" value="Add" style="width:120px; height:50px">
    </form>
            </div>

            <!-- View Products Container -->
<div id="viewstyletip" class="styletip-container">
    <h4 style="color:#922B21">View Style Tips</h4><br>
    
    <table>
        <tr>
            <th>Product Image</th>
            <th>Description</th>
            <th> </th>
        </tr>
        <!-- Fetch products from the database and display them in the table -->
       
    </table>
</div>




<script>
    // JavaScript code

    document.addEventListener("DOMContentLoaded", function () {
            // Select DOM elements
            const addBtn = document.getElementById('addBtn');
            const viewBtn = document.getElementById('viewBtn');
            const addstyletipForm = document.getElementById('addstyletipForm');
            const viewstyletip = document.getElementById('viewstyletip');

            // Add event listeners
            addBtn.addEventListener('click', function () {
                showForm(addstyletipForm);
            });

            viewBtn.addEventListener('click', function () {
                showForm(viewstyletip);
            });

            // Function to show the form and hide the other
            function showForm(form) {
                addstyletipForm.style.display = 'none';
                viewstyletip.style.display = 'none';

                form.style.display = 'block';
            }
        });

        // Add more JavaScript functionality here, such as form submission handling

    
</script>



    
    </div>
</body>

</html>
