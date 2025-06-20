<?php

session_start();

if (isset($_SESSION['username'])) {
    $user = $_SESSION['username'];
} else {
    // Redirect the user to the login page if not logged in
    header("Location: login.php");
    exit();
}

include "connect.php";
$email = "";
// Fetch email from tbl_register based on UID
$uid = $_SESSION['uid'];

$select_query = "SELECT email FROM tbl_register WHERE uid = '$uid'";
$result = mysqli_query($conn, $select_query);
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $email = $row['email'];
}

// Initialize variables to avoid warnings
$firstname = "";
$lastname = "";
$phone = "";
$address = "";

// Retrieve existing profile data from tbl_profile
$select_profile_query = "SELECT * FROM tbl_profile WHERE uid = '$uid'";
$profile_result = mysqli_query($conn, $select_profile_query);
if ($profile_result && mysqli_num_rows($profile_result) > 0) {
    $profile_row = mysqli_fetch_assoc($profile_result);
    $firstname = $profile_row['firstname'];
    $lastname = $profile_row['lastname'];
    $phone = $profile_row['phoneno'];
    $address = $profile_row['address'];
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    // Update form data in tbl_profile
    $update_query = "UPDATE tbl_profile SET firstname='$firstname', lastname='$lastname', phoneno='$phone', address='$address' WHERE uid='$uid'";

    if (mysqli_query($conn, $update_query)) {
        // Update successful
        echo "Profile updated successfully";
    } else {
        // Error handling
        echo "Error: " . $update_query . "<br>" . mysqli_error($conn);
    }
}

// Close database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin dashboard</title>
    <style>
    .profilecontainer {
            max-width: 600px;
            margin: auto;
            padding-top: 10px;
            padding-right: 10px;
            padding-left: 10px;
            padding-bottom: 70px;
            border-radius: 0;
        }
        h2 {
            text-align: center;
            padding-bottom: 20px;
        }
        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
            color: #555;
        }
        .form-group {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .form-group label {
            flex: 1;
        }
        .form-group input {
            flex: 2;
            margin-left: 10px;
        }
        input[type="text"],
        input[type="email"],
        input[type="tel"],
        textarea {
            width: 67%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
        }
        textarea {
            resize: vertical;
            height: 100px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>
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

        <!-- body content -->

        <div class="profilecontainer">
        <h2 style="font-family: Garamond; color: #922B21;">Profile</h2>

        

            <form action="#" method="POST">
                <div class="form-group">
                    <label for="firstname">First Name:</label>
                    <input type="text" id="firstname" name="firstname" value="<?php echo $firstname; ?>" required>
                </div>

                <div class="form-group">
                    <label for="lastname">Last Name:</label>
                    <input type="text" id="lastname" name="lastname" value="<?php echo $lastname; ?>" required>
                </div>
                
                <div class="form-group">    
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo $email; ?>" readonly>
                </div>

                <div class="form-group">
                    <label for="phone">Phone Number:</label>
                    <input type="tel" id="phone" name="phone" value="<?php echo $phone; ?>" required>
                </div>

                <div class="form-group">
                    <label for="address">Address:</label>
                    <textarea id="address" name="address" rows="3" cols="30" required><?php echo $address; ?></textarea>
                </div>

                <input type="submit" value="Edit">
            </form>
        </div>
        <!-- end body content -->

        <!-- Previous page link outside the form -->
    <div style="padding: 10px; display: flex; justify-content: center; align-items: center;" class="previous-page-link">
        <a href="javascript:history.go(-1);" style="color: #922D21; text-decoration: none; font-weight: bold; ">Back to Dashboard</a>
    </div>
    </div>

    
</body>
</html>