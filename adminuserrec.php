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
        width: 100%;
        border-collapse: collapse;
    }
    
    /* Header row styles */
    th {
        background-color: #f2f2f2;
        font-weight: bold;
        text-align: left;
        padding: 10px;
        border: 1px solid #dddddd;
    }
    
    /* Data row styles */
    td {
        padding: 10px;
        border: 1px solid #dddddd;
    }
    
    /* Alternating row colors */
    tr:nth-child(even) {
        background-color: #f9f9f9;
    }
    
    /* Button styles */
    .btn {
        padding: 8px 16px;
        border: none;
        cursor: pointer;
        border-radius: 4px;
        transition: background-color 0.3s;
    }
    
    /* Success button style */
    .btn-success {
        background-color: #BA4A00;
        color: white;
    }
    
    /* Danger button style */
    .btn-danger {
        background-color: #922B21;
        color: white;
    }
    
    /* Button hover effect */
    .btn:hover {
        background-color: #BA4A00;
    }


</style>

<body>
    <div class="sidebar">
        <div class="logo"></div>
        <ul class="menu">
            <li><a href="admin.php"><i class="fas fa-tachometer"></i>
                    <span>Dashboard</span></a>
            </li>
            <li><a href="adminproductrec.php"><i class="fas fa-store"></i>
                    <span>Manage Products</span></a>
            </li>
            <li><a href="#"><i class="fas fa-lightbulb"></i>
                    <span>Manage Tips</span></a>
            </li>
            <li><a href="#"><i class="fas fa-clipboard-list"></i>
                    <span>Orders</span></a>
            </li>
            <li class="active"><a href="adminuserrec.php"><i class="fas fa-users"></i>
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
        <div class="header--wrapper">
            <div class="header--title">
                <span>Admin</span>
                <h2>Dashboard</h2>
            </div>
            <div class="user--info">
                <div class="search--box">
                    <i class="fa-solid fa-search"></i>
                    <input type="text" placeholder="search">
                </div>
                <img src="" alt="">
            </div>
        </div>
        
        <div class="container-fluid pt-4 px-4">
    <div class="bg-light text-center rounded p-4">
        
        <div class="table-responsive">
            <table class="table text-start align-middle table-bordered table-hover mb-0">
                <thead>
                    <tr class="text-dark">
                        <th scope="col"></th>
                        <th scope="col">Username</th>
                        <th scope="col">Email</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Zipcode</th>
                        <th scope="col">State</th>
                        <th scope="col">City</th>
                        <th scope="col">Reg Date</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include 'connect.php';

                    $sql = "SELECT * FROM tbl_register WHERE username NOT LIKE 'admin' AND email NOT LIKE 'admin@example.com'";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td><input class='form-check-input' type='checkbox'></td>
                                    <td>" . $row['username'] . "</td>
                                    <td>" . $row['email'] . "</td>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                    <td>
                                        <form action='' method='post'>
                                            <input type='hidden' name='username' value='" . $row['email'] . "'>
                                            <button type='submit' name='act' class='btn btn-sm btn-success'>Approve</button><br><br>
                                            <button type='submit' name='del' class='btn btn-sm btn-danger'>Reject</button>
                                        </form>
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
