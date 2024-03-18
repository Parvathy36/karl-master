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
    <title>Admin dashboard</title>
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<style>
    
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

.main-content {
            flex: 1;
            margin-top: 15%;
            padding: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
        }

.statistic-box {
    width: 250px;
    height: 200px;
    background-color: #fff;
    border-radius: 8px;
    margin: 10px;
    padding: 20px;
    text-align: center;
}

.statistic-box h3 {
    margin-bottom: 10px;
    color: #922D32;
    font-weight: bold;
    font-size: 25px;
    font-family: Garamond, "Consolas";
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
}

.statistic-box p {
    font-family: Garamond;
    font-weight: bold;
    font-size: 60px; 
    color: #922D32; 
    margin-top: 30px; 
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
    -webkit-text-stroke-width: 1px;
    -webkit-text-stroke-color: #333;
}

</style>

<body>
    <div class="sidebar">
        <div class="logo">
            <img src="img/core-img/aura_.png" alt="">
        </div>
        <ul class="menu">
            <li class="active"><a href="admin.php"><i class="fas fa-tachometer"></i>
                    <span>Dashboard</span></a>
            </li>
            <li><a href="adminstock.php"><i class="fa fa-shopping-basket"></i>
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

        
        <!-- You can add more sections here if needed -->
        <div class="main-content">
        <?php
// Include the connect.php file
include 'connect.php';

// SQL query to count users where role = 1
$sql = "SELECT COUNT(*) as user_count FROM tbl_register WHERE role = 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        $userCount = $row["user_count"];
        // Output the user count within the h3 element
        echo "<div class='statistic-box'>";
        echo "<h3>Total Users</h3>";
        echo "<p>" . $userCount . "</p>";
        echo "</div>";
    }
} else {
    echo "0 results";
}
$conn->close();
?>
<?php
// Include the connect.php file
include 'connect.php';

// SQL query to count products
$sql = "SELECT COUNT(*) as product_count FROM tbl_products";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        $productCount = $row["product_count"];
        // Output the product count within the h3 element
        echo "<div class='statistic-box'>";
        echo "<h3>Total Products</h3>";
        echo "<p>" . $productCount . "</p>";
        echo "</div>";
    }
} else {
    echo "0 results";
}
$conn->close();
?>
            <div class="statistic-box">
                <h3>Total Orders</h3>
                <p></p>
            </div>
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

    </script>
    </div>
</body>

</html>
