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
    <title>Karl - Fashion Ecommerce Template | Product Details</title>

    <!-- Favicon  -->
    <link rel="icon" href="img/core-img/favicon.ico">

    <!-- Core Style CSS -->
    <link rel="stylesheet" href="css/core-style.css">
    <link rel="stylesheet" href="style.css">

    <!-- Responsive CSS -->
    <link href="css/responsive.css" rel="stylesheet">

</head>
<style>
    .custom-list {
    counter-reset: custom-counter;
    list-style-type: none; 
}

.custom-list li {
    position: relative;
    padding-left: 20px;
    margin-bottom: 10px;
}

.custom-list li::before {
    content: counter(custom-counter);
    counter-increment: custom-counter;
    position: absolute;
    left: 0;
    top: 0;
    background-color: #922D21;
    color: #fff;
    width: 20px;
    height: 20px;
    line-height: 20px;
    text-align: center;
    border-radius: 50%;
    font-weight: bold;
}

</style>

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

        <!-- <<<<<<<<<<<<<<<<<<<< Breadcumb Area Start <<<<<<<<<<<<<<<<<<<< -->
        <div class="breadcumb_area">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <ol class="breadcrumb d-flex align-items-center">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Dresses</a></li>
                            <li class="breadcrumb-item active">Long Dress</li>
                        </ol>
                        <!-- btn -->
                        <a href="shop.php" class="backToHome d-block"><i class="fa fa-angle-double-left"></i> Back to Category</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- <<<<<<<<<<<<<<<<<<<< Breadcumb Area End <<<<<<<<<<<<<<<<<<<< -->

        <!-- <<<<<<<<<<<<<<<<<<<< Single Product Details Area Start >>>>>>>>>>>>>>>>>>>>>>>>> -->
        <?php
// Include your database connection file here
include 'connect.php';

// Function to fetch product details from the database
function getProductDetails($p_id, $conn) {
    // Replace this with your actual database query to fetch product details
    $query = "SELECT * FROM tbl_products WHERE p_id = $p_id";
    $result = $conn->query($query);
    $product_details = mysqli_fetch_assoc($result);
    return $product_details;
    // Make sure to handle database connection and error handling appropriately
}

// Function to fetch available sizes for a product from tbl_stock
function getProductSizes($p_id, $conn) {
    $sizes = array(); // Initialize an array to store sizes
    $query = "SELECT size FROM tbl_stock WHERE p_id = $p_id";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $sizes[] = $row['size']; // Add size to the array
        }
    }
    return $sizes;
}

// Check if the product ID is provided in the URL
if (isset($_GET['p_id'])) {
    $p_id = $_GET['p_id'];

    // Fetch product details from the database using the product ID
    $product_details = getProductDetails($p_id, $conn);

    // Check if product details are fetched successfully
    if ($product_details) {
?>
        <section class="single_product_details_area section_padding_0_100">
            <div class="container">
                <div class="row">

                    <div class="col-12 col-md-6">
                        <div class="single_product_thumb">
                            <div id="product_details_slider" class="carousel slide" data-ride="carousel">

                            <ol class="carousel-indicators">
                                <li class="active" data-target="#product_details_slider" data-slide-to="0" style="background-image: url(img/product-img/<?php echo $product_details['image']; ?>);">
                                </li>
                            </ol>

                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <a class="gallery_img" href="img/product-img/<?php echo $product_details['image']; ?>">
                                        <img class="d-block w-100" src="img/product-img/<?php echo $product_details['image']; ?>" alt="First slide">
                                    </a>
                                </div>
                            </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="single_product_desc">

                            <h4 class="title"><a href="#"><?php echo $product_details['p_name']; ?></a></h4>

                            <h4 class="price">₹<?php echo $product_details['price']; ?></h4>

                            <p class="available">Available: <span class="text-muted">In Stock</span></p>

                            <div class="single_product_ratings mb-15">
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star-o" aria-hidden="true"></i>
                            </div>

                            <div class="widget size mb-50">
                                <h6 class="widget-title">Size</h6>
                                <div class="widget-desc">
                                    <ul>
                                    <?php
                                        // Fetch available sizes for the product
                                        $sizes = getProductSizes($p_id, $conn);
                                        // Display each size
                                        foreach ($sizes as $size) {
                                            echo "<li><a href='#'>$size</a></li> ";
                                        }
                                    ?>
                                    </ul>
                                </div>
                            </div>

                            <!-- Add to Cart Form -->
                            <form class="cart clearfix mb-50 d-flex" method="post">
                                <div class="quantity">
                                    <span class="qty-minus" onclick="var effect = document.getElementById('qty'); var qty = effect.value; if( !isNaN( qty ) && qty > 1 ) effect.value--;return false;"><i class="fa fa-minus" aria-hidden="true"></i></span>
                                    <input type="number" class="qty-text" id="qty" step="1" min="1" max="12" name="quantity" value="1">
                                    <span class="qty-plus" onclick="var effect = document.getElementById('qty'); var qty = effect.value; if( !isNaN( qty )) effect.value++;return false;"><i class="fa fa-plus" aria-hidden="true"></i></span>
                                </div>
                                <button type="submit" name="addtocart" value="5" class="btn cart-submit d-block">Add to cart</button>
                            </form>

                            <div id="accordion" role="tablist">
                                <div class="card">
                                    <div class="card-header" role="tab" id="headingOne">
                                        <h6 class="mb-0">
                                            <a data-toggle="collapse" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Information</a>
                                        </h6>
                                    </div>

                                    <div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
                                        <div class="card-body">
                                            <p><?php echo $product_details['description']; ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" role="tab" id="headingTwo">
                                        <h6 class="mb-0">
                                            <a class="collapsed" data-toggle="collapse" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">Cart Details</a>
                                        </h6>
                                    </div>
                                    <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo" data-parent="#accordion">
                                        <div class="card-body">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Explicabo quis in veritatis officia inventore, tempore provident dignissimos nemo, nulla quaerat. Quibusdam non, eos, voluptatem reprehenderit hic nam! Laboriosam, sapiente! Praesentium.</p>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Officia magnam laborum eaque.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" role="tab" id="headingThree">
                                        <h6 class="mb-0">
                                            <a class="collapsed" data-toggle="collapse" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">shipping &amp; Returns</a>
                                        </h6>
                                    </div>
                                    <div id="collapseThree" class="collapse" role="tabpanel" aria-labelledby="headingThree" data-parent="#accordion">
                                        <div class="card-body">
                                            <p>Standard Delivery in 2-8 working days <br>
                                            Free shipping on orders of INR 1499 and above</p>
                                            <p>This item is eligible for free return within 30 days of delivery.</p>
                                            <p><b>Note:</b> We do not exchange products online. If something is not right, you may return the merchandise and place a new order. Alternatively, you can exchange the product for another style or size at any of our exclusive stores.</p>
                                            <a class="size-chart__anchor body-type--centi font-weight-400" style="color: #1e1e1e; font-weight: bold; font-family: Georgia; cursor: pointer;" data-toggle="modal" data-target="#moreInfoModal">More Info</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php
    } else {
        // Product not found or error fetching details
        echo "Product not found.";
    }
} else {
    // If no product ID is provided in the URL
    echo "No product ID specified.";
}
?>
        <!-- <<<<<<<<<<<<<<<<<<<< Single Product Details Area End >>>>>>>>>>>>>>>>>>>>>>>>> -->

        <!-- more info -->
        <div class="modal fade" id="moreInfoModal" tabindex="-1" role="dialog" aria-labelledby="moreInfoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-right" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="moreInfoModalLabel">How it works - Returns & Exchanges</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <p class="lead">Returning items is easy with our hassle-free process. Here's how it works:</p>
                        <ol class="custom-list">
                            <li>Request Return: Login and go to Account > My Orders > Return Item and select the products you wish to return along with the reason for return.</li>
                            <li>Return Pickup: Our delivery agent will pick up the package within 1-2 business days. Please ensure products are unused and tags are intact.</li>
                            <li>Refund: Refund will be processed on receiving the product, it may take 5-7 days to get credited at its source.</li>
                        </ol>
                        <p class="mb-0"><strong>Note:</strong> We do not exchange products online. If something is not right, you may return the merchandise and place a new order. Alternatively, you can exchange the product for another style or size at any of our exclusive stores.</p>
                        <p class="mt-2">To learn about international returns please refer to our <a href="#">return policy</a>.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

        <!-- more info -->

        

        <section class="you_may_like_area clearfix">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="section_heading text-center">
                            <h2>related Products</h2>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                
                    <div class="col-12">
                    <?php
                    include('connect.php');
                    $sql11 = "SELECT * FROM tbl_products";
                    $result = $conn->query($sql11);
                    while ($row = $result->fetch_assoc()){
                        ?>
                        <div class="you_make_like_slider owl-carousel">
                        
                            <!-- Single gallery Item -->
                            <div class="single_gallery_item">
                                <!-- Product Image -->
                                <div class="product-img">
                                    <img src="img/product-img/<?php echo $row['image']; ?>" alt="">
                                    <div class="product-quicview">
                                        <a href="#" data-toggle="modal" data-target="#quickview"><i class="ti-plus"></i></a>
                                    </div>
                                </div>
                                <!-- Product Description -->
                                <div class="product-description">
                                    <h4 class="product-price">₹<?php echo $row['price']; ?></h4>
                                    <p><?php echo $row['p_name']; ?></p>
                                    <!-- Add to Cart -->
                                    <a href="#" class="add-to-cart-btn">ADD TO CART</a>
                                </div>
                            </div>

                            
                        </div>
                        <?php
}
?>
                    </div>
                    
                </div>
            </div>
        </section>    

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
                                <a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
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

</html>