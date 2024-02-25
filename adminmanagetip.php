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
    // Validate form data
    if (!empty($_POST['tipdescription']) && isset($_FILES['image']['name']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        // Sanitize and validate form data
        $tipdescription = mysqli_real_escape_string($conn, $_POST['tipdescription']);
        $image_name = basename($_FILES['image']['name']);
        $target_dir = "img/tip-img/";
        $target_file = $target_dir . $image_name;

        // Move uploaded file to the target directory
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            // Prepare SQL statement with placeholders for the image
            $sql = "INSERT INTO tbl_tip (image, tipdescription) VALUES (?, ?)";

            // Prepare the statement
            $stmt = mysqli_prepare($conn, $sql);
            if ($stmt) {
                // Bind parameters to the statement
                mysqli_stmt_bind_param($stmt, "ss", $image_name, $tipdescription);

                // Execute the statement
                if (mysqli_stmt_execute($stmt)) {
                    echo "<script>alert('Style tip added successfully.')</script>";
                    header("Location: adminmanagetip.php");
                    exit; // Make sure to exit after redirection
                } else {
                    echo "<script>alert('Error: " . mysqli_stmt_error($stmt) . "')</script>";
                }

                // Close the statement
                mysqli_stmt_close($stmt);
            } else {
                echo "Error: Unable to prepare statement: " . mysqli_error($conn);
            }
        } else {
            echo "<script>alert('Error uploading file.')</script>";
        }
    } else {
        echo "<script>alert('Please fill out all fields and upload an image.')</script>";
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
                
            <i class="fa fa-user" aria-hidden="true"></i><?php echo $_SESSION['username'] ?>
            </div>
        </div>
        <div class="section1">
            <h3 style="color: #696969; font-size:20px;">Manage Style Tip</h3>
            <br>
            <button id="addBtn">Add style tips</button>
            <button id="viewBtn">View tips</button>
            <br><br>

            <!-- Add Product Form Container -->
            <div id="addstyletipForm" class="form-container">
                <!-- Add style tips form -->
                <h4 style="color:#922B21">Add Style Tips</h4><br>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" id="AddstyletipForm" method="POST" enctype="multipart/form-data">
                    <label for="image">Product Image:</label>
                    <input type="file" id="image" name="image" accept="image/*" required><br><br>

                    <label for="tipdescription">Tip:</label>
                    <textarea id="tipdescription" name="tipdescription" required></textarea><br><br>

                    <input type="submit" value="Add" style="width:120px; height:50px"></input>
                </form>
            </div>

       

            <!-- View Products Container -->
            <div id="viewstyletip" class="form-container" style="display:none;">
                <!-- View style tips container -->
                <h4 style="color:#922B21">View Style Tips</h4><br>
                <table>
                    <tr>
                        <th>Sl no.</th>
                        <th>Product Image</th>
                        <th>Tip</th>
                        <th> </th>
                    </tr>
                    <!-- Display style tips from the database -->
                    <?php
                    $sql = "SELECT * FROM tbl_tip";
                    $result = mysqli_query($conn, $sql);
                    $sl=0;
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>
                                    <td> ".++$sl."</td>
                                    <td><img src='img/tip-img/" . $row['image'] . "' alt='Product Image' width='100'></td>
                                    <td>" . $row['tipdescription'] . "</td>
                                    <td>
                                        <form action='' method='post'>
                                            <button type='submit' name='act' class='btn btn-sm btn-success'><i class='fa fa-pencil' aria-hidden='true'></i></button><br><br>
                                            <button type='submit' name='del' class='btn btn-sm btn-danger'><i class='fa fa-trash' aria-hidden='true'></i></button>
                                        </form>
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

</body>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var form = document.getElementById("AddstyletipForm");
        var imageInput = document.getElementById("image");
        var tipdescriptionInput = document.getElementById("tipdescription");

        form.addEventListener("submit", function (event) {
            var isValid = true;

            if (!validateImage(imageInput)) {
                isValid = false;
            }
            if (!validateField(tipdescriptionInput, validateDescriptionFormat)) {
                isValid = false;
            }

            if (!isValid) {
                event.preventDefault(); // Prevent form submission
            }
        });

        imageInput.addEventListener("change", function () {
            validateImage(imageInput);
        });

        tipdescriptionInput.addEventListener("blur", function () {
            validateField(tipdescriptionInput, validateDescriptionFormat, "*Please enter a valid description.");
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
            var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i; // Regular expression for allowed image extensions

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

        function validateDescriptionFormat(tipdescription) {
            return tipdescription.trim() !== '' && !/\s{2,}/.test(tipdescription);
        }

        // Function to display error messages
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

        // Function to clear error messages
        function clearErrorMessage(inputField) {
            var errorMessage = inputField.parentNode.querySelector('.error-message');
            if (errorMessage) {
                errorMessage.remove();
            }
        }
    });
</script>

</html>