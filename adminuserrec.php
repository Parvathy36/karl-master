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
    border-collapse: collapse;
    width: 60%;
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
    width: 100px;
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

<body>
    <div class="sidebar">
        <div class="logo">
            <img src="img/core-img/aura_.png" alt="">
        </div>
        <ul class="menu">
            <li><a href="admin.php"><i class="fas fa-tachometer"></i>
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
            <li class="active"><a href="adminuserrec.php"><i class="fas fa-users"></i>
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
        
        <div class="container-fluid pt-4 px-4">
    <div class="bg-light text-center rounded p-4">
        
        <div class="table-responsive"><br>
            <h3 style="color:#922B21; margin-left:10px;">User Records</h3><br>
            <table class="table text-start align-middle table-bordered table-hover mb-0">
                <thead>
                    <tr class="text-dark">
                        <th scope="col">Sl no.</th>
                        <th scope="col">Username</th>
                        <th scope="col">Email</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include 'connect.php';

                    $sql = "SELECT * FROM tbl_register WHERE username NOT LIKE 'admin' AND email NOT LIKE 'admin@example.com'";
                    $result = $conn->query($sql);
                    $sl=0;
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td> ".++$sl."</td>
                                    <td>" . $row['username'] . "</td>
                                    <td>" . $row['email'] . "</td>
                                    <td>
                                        
                                            <button type='submit' name='act' class='btn btn-sm btn-success'>Approve</button><br><br>
                                            <button type='submit' name='del' class='btn btn-sm btn-danger'>Reject</button>
                                        
                                    </td>
                                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='10'>No sellers found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
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

        
    </div>
</body>

</html>
