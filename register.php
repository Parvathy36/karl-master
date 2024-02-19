<?php
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['customer']['name'];
    $email = $_POST['customer']['email'];
    $password = $_POST['customer']['password'];

    if (empty($username) || empty($email) || empty($password)) {
        header("Location: register.php"); 
        exit();
    }

    // Sanitize inputs
    $username = mysqli_real_escape_string($conn, $username);
    $email = mysqli_real_escape_string($conn, $email);
    $hashedPassword = md5($password); // Convert the password to MD5 hash

    // Prepare the SQL statement
    $sql = "INSERT INTO tbl_register (username, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Bind parameters and execute the statement
        $stmt->bind_param("sss", $username, $email, $hashedPassword);
        if ($stmt->execute()) {
            header("Location: login.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Error in preparing statement: " . $conn->error;
    }

    // Close the connection
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title  -->
    <title>Karl - Fashion Ecommerce Template | Home</title>

    <!-- Favicon  -->
    <link rel="icon" href="img/core-img/favicon.ico">

    <!-- Core Style CSS -->
    <link rel="stylesheet" href="css/core-style.css">
    <link rel="stylesheet" href="style.css">

    <link rel="stylesheet" href="css/form.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Courier+Prime:wght@700&display=swap" rel="stylesheet">
    <!-- Responsive CSS -->
    <link href="css/responsive.css" rel="stylesheet">

</head>

<body>
    <div class="catagories-side-menu">
        <!-- Close Icon -->
        <div id="sideMenuClose">
            <i class="ti-close"></i>
        </div>
        <!--  Side Nav  -->
        <div class="nav-side-menu">
            <div class="menu-list">
                <h6>Categories</h6>
                <ul id="menu-content" class="menu-content collapse out">
                    <!-- Single Item -->
                    <li data-toggle="collapse" data-target="#women" class="collapsed active">
                        <a href="#">Woman wear <span class="arrow"></span></a>
                        <ul class="sub-menu collapse" id="women">
                            <li><a href="#">Dresses</a></li>
                            <li><a href="#">Co-ords sets</a></li>
                            <li><a href="#">Tops</a></li>
                            <li><a href="#">Bottoms</a></li>
                            <li><a href="#">Jackets</a></li>
                            <li><a href="#">Jumpsuits</a></li>
                            <li><a href="#">Scarves &amp; Stoles</a></li>
                        </ul>
                    </li>
                  
                    <!-- Single Item -->
                    <li data-toggle="collapse" data-target="#bags" class="collapsed">
                        <a href="#">Accessories <span class="arrow"></span></a>
                        <ul class="sub-menu collapse" id="bags">
                            <li><a href="#">Bags</a></li>
                            <li><a href="#">Jewellery</a></li>
                            <li><a href="#">Fragrances</a></li>
                        </ul>
                    </li>
                    <!-- Single Item -->
                    <li data-toggle="collapse" data-target="#footwear" class="collapsed">
                        <a href="#">Footwear <span class="arrow"></span></a>
                        <ul class="sub-menu collapse" id="footwear">
                            <li><a href="#">Shoes</a></li>
                            <li><a href="#">Sandals</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div id="wrapper">


        <!-- ****** Header Area Start ****** -->
        <header class="header_area bg-img background-overlay-white" style="background-image: url(img/bg-img/bg-11.jpg);">
            <!-- Top Header Area Start -->
            <div class="top_header_area">
                <div class="container h-100">
                    <div class="row h-100 align-items-center justify-content-end">

                        <div class="col-12 col-lg-7">
                            <div class="top_single_area d-flex align-items-center">
                                <!-- Logo Area -->
                                <div class="top_logo">
                                    <a href="#"><img src="img/core-img/aura_.png" alt=""></a>
                                </div>
                                <!-- Cart & Menu Area -->
                                <div class="header-cart-menu d-flex align-items-center ml-auto">
                                    
                                    <div class="header-right-side-menu ml-15">
                                        <a href="#" id="sideMenuBtn"><i class="ti-menu" aria-hidden="true"></i></a>
                                    </div>
                                   
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Top Header Area End -->
            <div class="main_header_area">
                <div class="container h-100">
                    <div class="row h-100">
                        <div class="col-12 d-md-flex justify-content-between">
                            <!-- Header Social Area -->
                            <div class="header-social-area">
                                <a href="https://in.pinterest.com/stylebyand/"><i class="fa fa-pinterest" aria-hidden="true"></i></a>
                                <a href="https://www.facebook.com/stylebyand/"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                                <a href="https://twitter.com/stylebyand/"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                                <a href="https://www.youtube.com/anddesignsindia"><i class="fa fa-youtube-square" aria-hidden="true"></i></a>
                                <a href="https://www.instagram.com/stylebyand/"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                            </div>
                            <!-- Menu Area -->
                            <div class="main-menu-area">
                                <nav class="navbar navbar-expand-lg align-items-start">

                                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#karl-navbar" aria-controls="karl-navbar" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"><i class="ti-menu"></i></span></button>

                                    <div class="collapse navbar-collapse align-items-start collapse" id="karl-navbar">
                                        <ul class="navbar-nav animated" id="nav">
                                        <li class="nav-item active"><a class="nav-link" href="guestindex.php">Home</a></li>
                                            <li class="nav-item"><a class="nav-link" href="guestshop.php">Products</a></li>
                                            <li class="nav-item"><a class="nav-link" href="guestblog.php">Blog</a></li>
                                            <li class="nav-item"><a class="nav-link" href="guestabout.php">About</a></li>
                                            <li class="nav-item"><a class="nav-link" href="guestcontact.php">Contact</a></li>
                                            <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                                        </ul>
                                    </div>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- ****** Header Area End ****** -->

    <!--Body Content-->
    <div id="page-content">
    	<!--Page Title-->
    	<div class="page section-header text-center">
			<div class="page-title">
        		<div class="wrapper"><h1 class="page-width">Create an Account</h1></div>
      		</div>
		</div>
        <!--End Page Title-->
        <div class="background" style="background-image: url('img/bg-img/bg-19.jpg'); background-size: cover; background-position: center; background-attachment: fixed;">
    <div class="new_container" style="padding: 40px 10px;">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-6 col-lg-6 main-col offset-md-4">
                <div class="mb-4">
                    <form method="post" action="" id="CustomerLoginForm" accept-charset="UTF-8" class="contact-form" >
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label for="Username">Username</label>
                                    <input type="text" name="customer[name]" placeholder="" id="name" autofocus="">
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label for="Email">Email</label>
                                    <input type="email" name="customer[email]" placeholder="" id="CustomerEmail" class="" autocorrect="off" autocapitalize="off" autofocus="">
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label for="Password">Password</label>
                                    <input type="password" value="" name="customer[password]" placeholder="" id="CustomerPassword" class="" >
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label for="Confirm Password">Confirm Password</label>
                                    <input type="password" value="" name="customer[confirm password]" placeholder="" id="CustomerConfirmPassword" class="">                        	
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="text-center col-12 col-sm-12 col-md-10 col-lg-9">
                                <input type="submit" class="btn mb-3" value="Create">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

        <!-- ****** Footer Area Start ****** -->
        <footer class="footer_area">
            <div class="container">
                <div class="row">
                    <!-- Single Footer Area Start -->
                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="single_footer_area">
                            <div class="footer-logo">
                                <img src="img/core-img/aura_.png" alt="">
                            </div>
                            
                        </div>
                    </div>
                    <!-- Single Footer Area Start -->
                    <div class="col-12 col-sm-6 col-md-3 col-lg-2">
                        <div class="single_footer_area">
                            <ul class="footer_widget_menu">
                                <li><a href="#">About</a></li>
                                <li><a href="#">Blog</a></li>
                                <li><a href="#">Faq</a></li>
                                <li><a href="#">Returns</a></li>
                                <li><a href="#">Contact</a></li>
                            </ul>
                        </div>
                    </div>
                    <!-- Single Footer Area Start -->
                    <div class="col-12 col-sm-6 col-md-3 col-lg-2">
                        <div class="single_footer_area">
                            <ul class="footer_widget_menu">
                                <li><a href="#">My Account</a></li>
                                <li><a href="#">Shipping</a></li>
                                <li><a href="#">Our Policies</a></li>
                                <li><a href="#">Afiliates</a></li>
                            </ul>
                        </div>
                    </div>
                    <!-- Single Footer Area Start -->
                    <div class="col-12 col-lg-5">
                        <div class="single_footer_area">
                            <div class="footer_heading mb-30">
                                <h6>Subscribe to our newsletter</h6>
                            </div>
                            <div class="subscribtion_form">
                                <form action="#" method="post">
                                    <input type="email" name="mail" class="mail" placeholder="Your email here">
                                    <button type="submit" class="submit">Subscribe</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="line"></div>

                <!-- Footer Bottom Area Start -->
                <div class="footer_bottom_area">
                    <div class="row">
                        <div class="col-12">
                            <div class="footer_social_area text-center">
                                <a href="#"><i class="fa fa-pinterest" aria-hidden="true"></i></a>
                                <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                                <a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                                <a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- ****** Footer Area End ****** -->
    </div>
    <!-- /.wrapper end -->

    <!-- jQuery (Necessary for All JavaScript Plugins) -->
    <script src="js/jquery/jquery-2.2.4.min.js"></script>
    <!-- Popper js -->
    <script src="js/popper.min.js"></script>
    <!-- Bootstrap js -->
    <script src="js/bootstrap.min.js"></script>
    <!-- Plugins js -->
    <script src="js/plugins.js"></script>
    <!-- Active js -->
    <script src="js/active.js"></script>
<!-- validation -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var form = document.getElementById("CustomerLoginForm");

        var usernameInput = document.getElementById("name");
            var emailInput = document.getElementById("CustomerEmail");
            var passwordInput = document.getElementById("CustomerPassword");
            var confirmPasswordInput = document.getElementById("CustomerConfirmPassword");


        form.addEventListener("submit", function(event) {
            // Select all input fields
            var usernameInput = document.getElementById("name");
            var emailInput = document.getElementById("CustomerEmail");
            var passwordInput = document.getElementById("CustomerPassword");
            var confirmPasswordInput = document.getElementById("CustomerConfirmPassword");

            // Check if any of the fields are empty
            if (usernameInput.value.trim() === '' || 
                emailInput.value.trim() === '' || 
                passwordInput.value.trim() === '' || 
                confirmPasswordInput.value.trim() === '') {
                event.preventDefault(); // Prevent form submission
                alert("Please fill in all the fields."); // Display an alert message
            }
        })
        // Add blur event listeners to validate individual fields
        usernameInput.addEventListener("blur", validateUsername);
        emailInput.addEventListener("blur", validateEmail);
        passwordInput.addEventListener("blur", validatePassword);
        confirmPasswordInput.addEventListener("blur", validateConfirmPassword);

        // Validation functions for individual fields
        function validateUsername() {
            var username = usernameInput.value.trim();
            if (!validateUsernameFormat(username)) {
                displayErrorMessage("*Invalid username format. Use only letters and underscores.", usernameInput);
            } else {
                clearErrorMessage(usernameInput);
            }
        }

        function validateEmail() {
            var email = emailInput.value.trim();
            if (!validateEmailFormat(email)) {
                displayErrorMessage("*Please enter a valid email address.", emailInput);
            } else {
                clearErrorMessage(emailInput);
            }
        }

        function validatePassword() {
            var password = passwordInput.value.trim();
            if (!validatePasswordFormat(password)) {
                displayErrorMessage("*Password must be at least 8 characters and include one special character, one number, and one capital letter.", passwordInput);
            } else {
                clearErrorMessage(passwordInput);
            }
        }

        function validateConfirmPassword() {
            var confirmPassword = confirmPasswordInput.value.trim();
            var password = passwordInput.value.trim();
            if (password !== confirmPassword) {
                displayErrorMessage("*Passwords do not match.", confirmPasswordInput);
            } else {
                clearErrorMessage(confirmPasswordInput);
            }
        }

        // Regular expressions for format validation
        function validateUsernameFormat(username) {
            return /^[a-zA-Z_]+$/.test(username);
        }

        function validateEmailFormat(email) {
            return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
        }

        function validatePasswordFormat(password) {
            return /^(?=.*[!@#$%^&*])(?=.*[0-9])(?=.*[A-Z]).{8,}$/.test(password);
        }

        function displayErrorMessage(message, inputField) {
        clearErrorMessage(inputField); // Clear existing errors
        var errorMessageElement = document.createElement('div');
        errorMessageElement.classList.add('error-message');
        errorMessageElement.style.color = 'black'; // Set color to red
        errorMessageElement.style.fontWeight = 'bold'; // Set font weight to bold
        errorMessageElement.style.fontSize = '13px'; // Adjust font size
        errorMessageElement.style.fontFamily = 'Sans Serif'; // Change font-family
        errorMessageElement.textContent = message;
        inputField.parentNode.insertBefore(errorMessageElement, inputField.nextSibling);
    }


        function clearErrorMessage(inputField) {
            var errorMessage = inputField.parentNode.querySelector('.error-message');
            if (errorMessage) {
                errorMessage.remove();
            }
        }
    });
</script>



</body>

</html>