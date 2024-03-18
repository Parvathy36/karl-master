<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect the user to the login page if not logged in
    header("Location: login.php");
    exit();
}

// Include your database connection file
require("connect.php");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize the input data
    $productName = $_POST['productName'];
    $quantity = $_POST['quantity'];

    // Fetch the category ID for the selected product
    $sql = "SELECT category_id FROM tbl_products WHERE p_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $productName);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $category = $row['category_id']; // Extract the category ID
    } else {
        echo "Error fetching product category";
        exit(); // Stop further processing if category cannot be determined
    }

    // Set size to NULL if category is 2
    if ($category == 2) {
        $size = NULL;
    } else {
        $size = $_POST['size'];
    }


    // Construct the SQL query to insert data into tbl_stock
    $sql = "INSERT INTO tbl_stock (p_id, qty, size) VALUES (
                (SELECT p_id FROM tbl_products WHERE p_name = ?),
                ?,
                ?
            )";

    // Prepare the SQL statement
    $stmt = $conn->prepare($sql);

    // Bind parameters and execute the statement
    $stmt->bind_param("sss", $productName, $quantity, $size);
    $stmt->execute();

    // Check if the insertion was successful
    if ($stmt->affected_rows > 0) {
        // Redirect or show success message
        echo "Stock added successfully!";
    } else {
        echo "Error adding stock: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
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
            <li class="active"><a href="adminstock.php"><i class="fa fa-shopping-basket"></i>
                    <span>Manage Stock</span></a>
            </li>
            <li><a href="adminproductrec.php"><i class="fas fa-store"></i>
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
                <a href="adminprofile.php" style="color: black; text-decoration: none;"><i class="fa fa-user" aria-hidden="true"><span style="margin-left: 5px;"><?php echo $_SESSION['username'] ?></i></a>
            </div>
        </div>
        <div class="section1">
            <h3 style="color: #696969; font-size:20px;">Manage Stock</h3>
            <br>
            <button id="addBtn">Add stock</button>
            <button id="viewBtn">View stock</button>
            <br><br>

            <!-- Add stock Form Container -->
            <div id="addstockForm" class="form-container">
                <!-- Add stock form -->
                <h4 style="color:#922B21">Add Stock</h4><br>
                <form action="" id="AddstockForm" method="POST" enctype="multipart/form-data">
                <label for="productName">Product Name:</label>
                <select id="productName" name="productName" required onchange="toggleSizeField()">
                    <option value="">Select Product</option>
                    <?php 
    // Fetch product names and category_id from tbl_products
    $sql = "SELECT p_name, category_id FROM tbl_products";
    $result = $conn->query($sql);

    // Output product names and category_id as options in the select element
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo '<option value="' . $row['p_name'] . '" data-category="' . $row['category_id'] . '">' . $row['p_name'] . '</option>';
        }
    } else {
        echo "<option value=''>No products found</option>";
    }
    ?>
</select><br><br>


                
        
                    <label for="quantity">Quantity:</label>
                    <input type="number" id="quantity" name="quantity" required><br><br>

                    <label for="size" id="sizeLabel" style="display:none;">Size:</label>
                    <select id="size" name="size" required style="display:none;">
                        <!-- Size options will be dynamically populated based on the selected category -->
                    </select><br>


                    <input type="submit" value="Add" style="width:120px; height:50px"></input>
                </form>
            </div>

       

            <!-- View Products Container -->
            <div id="viewstock" class="form-container" style="display:none;">
                <!-- View style tips container -->
                <h4 style="color:#922B21">View Style Tips</h4><br>
                <table>
                    <tr>
                        <th>Sl no.</th>
                        <th>Product Name</th>
                        <th>Category Name</th>
                        <th>Quantity</th>
                        <th>Size</th>
                        <th>Action</th>
                    </tr>
                    <!-- Display style tips from the database -->
                    <?php
                    $sql = "SELECT s.p_id, p.p_name, c.category_name, s.qty, s.size
                    FROM tbl_stock s
                    INNER JOIN tbl_products p ON s.p_id = p.p_id
                    INNER JOIN tbl_category c ON p.category_id = c.category_id;";
            
                    $result = mysqli_query($conn, $sql);
                    $sl=0;
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>
                                    <td> ".++$sl."</td>
                                    <td>" . $row['p_name'] . "</td>
                                    <td>" . $row['category_name'] . "</td>
                                    <td>" . $row['qty'] . "</td>
                                    <td>" . $row['size'] . "</td>
                                    <td>
                                        
                                            <button type='submit' name='act' class='btn btn-sm btn-success'><i class='fa fa-pencil' aria-hidden='true'></i></button><br><br>
                                            <button type='submit' name='del' class='btn btn-sm btn-danger'><i class='fa fa-trash' aria-hidden='true'></i></button>
                                        
                                    </td>
                                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>No style tip found</td></tr>";
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Select DOM elements
            const addBtn = document.getElementById('addBtn');
            const viewBtn = document.getElementById('viewBtn');
            const addstockForm = document.getElementById('addstockForm');
            const viewstock = document.getElementById('viewstock');
            

            // Add event listeners
            addBtn.addEventListener('click', function () {
                showForm(addstockForm);
            });

            viewBtn.addEventListener('click', function () {
                showForm(viewstock);
            });

    

            // Function to show the form and hide the other
            function showForm(form) {
                // Hide all forms
                addstockForm.style.display = 'none';
                viewstock.style.display = 'none';

                // Show the selected form
                form.style.display = 'block';
            }

        })();

        
        function toggleSizeField() {
    var productNameSelect = document.getElementById('productName');
    var category = productNameSelect.options[productNameSelect.selectedIndex].getAttribute('data-category');
    var sizeLabel = document.getElementById('sizeLabel');
    var sizeSelect = document.getElementById('size');

    if (category === "1" || category === "3") {
        sizeLabel.style.display = "block";
        sizeSelect.style.display = "block";
        sizeSelect.innerHTML = ''; // Clear existing options

        // Add size options dynamically based on category
        if (category === "1") {
            addSizeOptions([6, 8, 10, 12, 14, 16, 18, 20]);
        } else if (category === "3") {
            addSizeOptions([36, 37, 38, 39, 40, 41]);
        }
    } else {
        sizeLabel.style.display = "none";
        sizeSelect.style.display = "none";
    }
}

function addSizeOptions(sizes) {
    var sizeSelect = document.getElementById('size');
    sizes.forEach(function (size) {
        var option = document.createElement("option");
        option.text = size;
        option.value = size;
        sizeSelect.add(option);
    });
}

    </script>

</body>

</html>