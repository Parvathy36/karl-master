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
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title  -->
    <title>Karl - Fashion Ecommerce Template | Cart</title>

    <!-- Favicon  -->
    <link rel="icon" href="img/core-img/favicon.ico">

    <!-- Core Style CSS -->
    <link rel="stylesheet" href="css/core-style.css">
    <link rel="stylesheet" href="style.css">

    <!-- Responsive CSS -->
    <link href="css/responsive.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

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
                            <li><a href="#">Eyewear</a></li>
                            <li><a href="#">watches</a></li>
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
                                    <!-- Cart Area -->
                                    <div class="cart">
                                        <a href="cart.php" id="header-cart-btn" target="_blank"><i class="ti-bag"></i></a>
                                        
                                    </div>
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
                                            <li class="nav-item active"><a class="nav-link" href="index.php">Home</a></li>
                                            <li class="nav-item"><a class="nav-link" href="shop.php">Products</a></li>
                                            <li class="nav-item"><a class="nav-link" href="blog.php">Blog</a></li>
                                            <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
                                            <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
                                            <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $user ?></a>
                                                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                                     <a class="dropdown-item" href="uprofile.php">Profile</a>
                                                     
                                                     <a class="dropdown-item" href="logout.php">Logout</a>
                                                </div>
                                            </li>
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

        <!-- ****** Top Discount Area End ****** -->

        <!-- ****** Cart Area Start ****** -->
<div class="cart_area section_padding_100 clearfix">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="cart-table clearfix">
                    <table class="table table-responsive">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th>     </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            require_once "connect.php";

                            $sql = "SELECT c.p_id, c.quantity, c.status, p.p_name, p.image, p.price 
                                    FROM tbl_cart c
                                    INNER JOIN tbl_products p ON c.p_id = p.p_id AND c.status = 1";

                            $result = mysqli_query($conn, $sql);

                            $subtotal = 0;

                            if ($result) {
                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr>";
                                        echo "<td class='cart_product_img d-flex align-items-center'>";
                                        echo "<a href='#'><img src='img/product-img/" . $row["image"] . "' alt='Product'></a>";
                                        echo "<h6>" . $row["p_name"] . "</h6>";
                                        echo "</td>";
                                        echo "<td class='price'><span>₹" . $row["price"] . "</span></td>";
                                        echo "<td class='qty'>";
                                        echo "<div class='quantity'>";
                                        echo "<span class='qty-minus' onclick='updateQuantity(" . $row["p_id"] . ", -1)'><i class='fa fa-minus' aria-hidden='true'></i></span>";
                                        echo "<input type='number' class='qty-text' id='qty" . $row["p_id"] . "' step='1' min='1' max='99' name='quantity' value='" . $row["quantity"] . "'>";
                                        echo "<span class='qty-plus' onclick='updateQuantity(" . $row["p_id"] . ", 1)'><i class='fa fa-plus' aria-hidden='true'></i></span>";
                                        echo "</div>";
                                        echo "</td>";
                                        echo "<td class='total_price'><span>₹" . $row["price"] * $row["quantity"] . "</span></td>";
                                        echo "<td><i class='material-icons'>delete</i></td>";
                                        echo "</tr>";

                                        $subtotal += ($row["price"] * $row["quantity"]);
                                    }
                                } else {
                                    echo "<tr><td colspan='4'>No items in the cart</td></tr>";
                                }
                            } else {
                                echo "Error: " . mysqli_error($conn);
                            }

                            mysqli_close($conn);

                            $total = $subtotal;
                            ?>
                        </tbody>
                    </table>
                </div>

                <div class="cart-footer d-flex mt-30">
                    <div class="back-to-shop w-50">
                        <a href="shop.php">Continue shopping</a>
                    </div>
                    <div class="update-checkout w-50 text-right">
                        <a href="#">Update cart</a>
                    </div>
                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-12 col-md-6 col-lg-4">
            </div>
            <div class="col-12 col-md-6 col-lg-4">
            </div>
            <div class="col-12 col-lg-4">
                <div class="cart-total-area mt-70">
                    <div class="cart-page-heading">
                        <h5>Cart total</h5>
                        <p>Final info</p>
                    </div>
                     <form action="checkout.php" method="post">
                    <ul class="cart-total-chart">
                        <li><span>Subtotal</span> <span>₹<?php echo number_format($subtotal, 2); ?></span></li>
                        <li><span>Shipping</span> <span>Free</span></li>
                        <li><span><strong>Total</strong></span> <span><strong>₹<?php echo number_format($total, 2); ?></strong></span></li>
                    </ul>
                    <input type="hidden" name="total" value="<?php echo $total; ?>"/>
                    <a href="checkout.php"><button type="submit" class="btn karl-checkout-btn" name="checkout">Proceed to checkout</button></a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ****** Cart Area End ****** -->

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

</body>

<script>
    function updateQuantity(productId, change) {
        var input = document.getElementById('qty' + productId);
        var quantity = parseInt(input.value);
        quantity += change;
        if (quantity < 1 || isNaN(quantity)) {
            quantity = 1;
        }
        input.value = quantity;
    }
</script>

</html>