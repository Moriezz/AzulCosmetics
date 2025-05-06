<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- CSS -->
    <link rel="stylesheet" href="admincss.css">
    <link rel="icon" type="image/x-icon" href="file.png">
</head>
<body>
<?php
session_start(); // Start the session
if (!isset($_SESSION['user_id'])) { // Check if user is logged in
    header("Location: astrogear-login.php"); // Redirect to login page
    exit();
}
?>
<style>
    select#category {
        width: 150px; 
        height: 33px; 
        font-size: 16px;
        padding: 5px; 
    }
</style>
<nav class="navbar navbar-expand-md">
        <a class="navbar-brand" href="#"><img src="Astrogear black cropped.png" alt="Logo" class="logo"></a>
</nav>

<!-- Admin profile and functions -->
<div class="container mt-4">
    <div class="card">
        <div class="card-header text-white">
            <h3>Manage Details</h3>
        </div>
        <div class="card-body d-flex flex-column">
            <div class="button-pos d-flex align-items-center">
                <div class="admin-profile text-center">
                    <a href="#"><img src="productImages/gpu/MSIRTX4070Super12gb.png" alt=""></a>
                    <h5 class="profile-title">Admin Profile</h5>
                </div>
                <div class="text-content text-center">
                    <div class="admin-buttons-container">
                        <button class="admin-buttons"><a href="admin.php?insert_product">Insert Products</a></button>
                        <button class="admin-buttons"><a href="admin.php?view_categories">View Categories</a></button>
                        <button class="admin-buttons"><a href="admin.php?view_users">View Users</a></button> <!-- Updated link -->
                    </div>
                </div>
            </div>
            <!-- Buttons aligned to the lower-left -->
            <div class="footer-buttons mx-5">
                <a href="index.php" class="btn btn-success me-2">View Dashboard</a>
                <a href="logout.php" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </div>
</div>

<!-- if condition insert product -->
<div class="container">
    <div class="product-list">
        <div class="align-items-center" style="
            padding-left: 400px;
            padding-right: 90px;">
            <?php 
                if(isset($_GET['insert_product']))
                    include('insert_products.php');
            ?>
        </div>
        <?php 
            if(isset($_GET['view_categories']))
                include('view_categories.php');
        ?>
        <?php 
            if(isset($_GET['view_users'])) 
                include('view_users.php'); 
        ?>
    </div>
</div>

<div class="container">
<div class="product-list">
    <h1 class="title">E-Cart Product Listing</h1>

    <?php
    // Database connection
    $host = "localhost"; // Replace with your database host
    $user = "root";      // Replace with your database username
    $pass = "";          // Replace with your database password
    $db = "astrogear_db"; // Replace with your database name
    $port = 3308;        // Port number (3308 in your case)

    $connection = new mysqli($host, $user, $pass, $db, $port);

    // Check connection
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    if (isset($_GET['edit_user'])) {
        $id_code = $_GET['edit_user']; // Get user ID from URL
    
        // Fetch user details from the database
        $sql = "SELECT id, first_name, last_name, email, phone FROM Users WHERE id = '$id_code'";
        $result = $connection->query($sql);
        
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            
            // If the form is submitted, update user details
            if (isset($_POST['update'])) {
                // Get updated values from POST request
                $first_name = $_POST['first_name'];
                $last_name = $_POST['last_name'];
                $email = $_POST['email'];
                $phone = $_POST['phone'];
    
                // Update user details in the database
                $update_sql = "UPDATE Users SET first_name='$first_name', last_name='$last_name', email='$email', phone='$phone' WHERE id='$id_code'";
                
                if ($connection->query($update_sql) === TRUE) {
                    header("Location: admin.php"); // Redirect after update
                    exit();
                } else {
                    echo "Error updating user: " . $connection->error;
                }
            }
    
            // Display Edit User Form
            echo '<h2>Edit User</h2>';
            echo '<form method="POST" action="">
                    <div class="form-group">
                        <label for="first_name">First Name:</label>
                        <input type="text" id="first_name" name="first_name" class="form-control" value="' . htmlspecialchars($user['first_name']) . '" required>
                    </div>
                    <div class="form-group">
                        <label for="last_name">Last Name:</label>
                        <input type="text" id="last_name" name="last_name" class="form-control" value="' . htmlspecialchars($user['last_name']) . '" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" class="form-control" value="' . htmlspecialchars($user['email']) . '" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone Number:</label>
                        <input type="text" id="phone" name="phone" class="form-control" value="' . htmlspecialchars($user['phone']) . '" required>
                    </div>
                    <button type="submit" name="update" class="btn btn-primary">Update User</button>
                  </form>';
            
        } else {
            echo "User not found.";
        }
    }

    // Handle the "edit_product" URL parameter
    if (isset($_GET['edit_product'])) {
        $id_code = $_GET['edit_product']; // Get product ID from URL
        // Fetch product details from the database
        $sql = "SELECT ProductID, ProductName, Category, Quantity, Price, Status FROM Products WHERE ProductID = '$id_code'";
        $result = $connection->query($sql);
        
        if ($result->num_rows > 0) {
            $product = $result->fetch_assoc();
        } else {
            echo "Product not found.";
            exit;
        }

        // If the form is submitted, update product details
        if (isset($_POST['update'])) {
            $product_name = $_POST['product_name'];
            $category = $_POST['category'];
            $quantity = $_POST['quantity'];
            $price = $_POST['price'];
            $status = $_POST['status'];

            // Update product details in the database
            $update_sql = "UPDATE Products SET ProductName='$product_name', Category='$category', Quantity='$quantity', Price='$price', Status='$status' WHERE ProductID='$id_code'";
            
            if ($connection->query($update_sql) === TRUE) {
                header("Location: admin.php"); // Redirect after update
                exit();
            } else {
                echo "Error updating product: " . $connection->error;
            }
        }

        // Handle the "edit_product" URL parameter
if (isset($_GET['edit_product'])) {
    $id_code = $_GET['edit_product']; // Get product ID from URL
    // Fetch product details from the database
    $sql = "SELECT ProductID, ProductName, Category, Quantity, Price, Status FROM Products WHERE ProductID = '$id_code'";
    $result = $connection->query($sql);
    
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        echo "Product not found.";
        exit;
    }

    // If the form is submitted, update product details
    if (isset($_POST['update'])) {
        $product_name = $_POST['product_name'];
        $category = $_POST['category'];
        $quantity = $_POST['quantity'];
        $price = $_POST['price'];
        $status = $_POST['status'];

        // Update product details in the database
        $update_sql = "UPDATE Products SET ProductName='$product_name', Category='$category', Quantity='$quantity', Price='$price', Status='$status' WHERE ProductID='$id_code'";
        
        if ($connection->query($update_sql) === TRUE) {
            header("Location: admin.php"); // Redirect after update
            exit();
        } else {
            echo "Error updating product: " . $connection->error;
        }
    }

    // Display Edit Product Form with dropdowns
    echo '<h2>Edit Product</h2>';
    echo '<form method="POST" action="">
            <div class="form-group">
                <label for="product_name">Product Name:</label>
                <input type="text" id="product_name" name="product_name" class="form-control" value="' . htmlspecialchars($product['ProductName']) . '" required>
            </div>
            <div class="form-group">
                <label for="category">Category:</label>
                <select id="category" name="category" class="form-control" required>';

                // Fetch categories from the database to populate the dropdown
                $category_query = "SELECT CategoryID, CategoryName FROM Categories ORDER BY CategoryName";
                $category_result = $connection->query($category_query);

                // Populate the dropdown with categories
                if ($category_result->num_rows > 0) {
                    while ($category = $category_result->fetch_assoc()) {
                        $selected = ($category['CategoryID'] == $product['Category']) ? 'selected' : '';
                        echo "<option value='" . htmlspecialchars($category['CategoryID']) . "' $selected>" . htmlspecialchars($category['CategoryName']) . "</option>";
                    }
                }

    echo '      </select>
            </div>
            <div class="form-group">
                <label for="quantity">Quantity:</label>
                <input type="number" id="quantity" name="quantity" class="form-control" value="' . htmlspecialchars($product['Quantity']) . '" required>
            </div>
            <div class="form-group">
                <label for="price">Price:</label>
                <input type="text" id="price" name="price" class="form-control" value="' . htmlspecialchars($product['Price']) . '" required>
            </div>
            <div class="form-group">
                <label for="status">Status:</label>
                <select id="status" name="status" class="form-control" required>
                    <option value="Available"' . ($product['Status'] == 'Available' ? ' selected' : '') . '>Available</option>
                    <option value="Out of Stock"' . ($product['Status'] == 'Out of Stock' ? ' selected' : '') . '>Out of Stock</option>
                </select>
            </div>
            <button type="submit" name="update" class="btn btn-primary">Update Product</button>
          </form>';

    exit; // Stop further execution after displaying the edit form
}
    }

    // Get categories for the dropdown
    $category_query = "SELECT CategoryID, CategoryName FROM Categories ORDER BY CategoryName";
    $category_result = $connection->query($category_query);

    // Determine the selected category
    $selected_category = isset($_POST['category']) ? $_POST['category'] : '';

    // Query to fetch products based on the selected category
    if ($selected_category) {
        $sql = "SELECT ProductID, ProductName, Category, Quantity, Price, Status FROM Products WHERE Category = '$selected_category' ORDER BY ProductName";
    } else {
        $sql = "SELECT ProductID, ProductName, Category, Quantity, Price, Status FROM Products ORDER BY ProductName";
    }

    $result = $connection->query($sql);
    ?>

    <!-- Dropdown form to filter by category -->
    <form method="POST" action="">
        <label for="category">Select Category:</label>
        <select name="category" id="category">
            <option value="">All Categories</option>
            <?php
            // Populate the dropdown with categories from the database
            if ($category_result->num_rows > 0) {
                while ($category = $category_result->fetch_assoc()) {
                    $selected = ($category['CategoryID'] == $selected_category) ? 'selected' : '';
                    echo "<option value='" . htmlspecialchars($category['CategoryID']) . "' $selected>" . htmlspecialchars($category['CategoryName']) . "</option>";
                }
            }
            ?>
        </select>
        <button type="submit" class="admin-filter">Filter</button>
    </form>

    <!-- Table to display products -->
    <table border='1' class='table table-striped mt-3'>
        <thead>
            <tr>
                <th>ID</th>
                <th>Product Name</th>
                <th>Category</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Status</th>
                <th>Action</th> <!-- New column for Edit button -->
            </tr>
        </thead>
        <tbody>
            <?php
            // Check if there are rows in the result
            if ($result->num_rows > 0) {
                while ($product = $result->fetch_assoc()) {
                    echo '
                        <tr>
                            <td>' . htmlspecialchars($product['ProductID']) . '</td>
                            <td>' . htmlspecialchars($product['ProductName']) . '</td>
                            <td>' . htmlspecialchars($product['Category']) . '</td>
                            <td>' . htmlspecialchars($product['Quantity']) . '</td>
                            <td>₱' . htmlspecialchars(number_format($product['Price'], 2)) . '</td>
                            <td>' . htmlspecialchars($product['Status']) . '</td>
                            <td><a href="admin.php?edit_product=' . $product['ProductID'] . '" class="btn btn-warning btn-sm">Edit</a></td> <!-- Edit button -->
                        </tr>';
                }
            } else {
                echo '
                        <tr>
                            <td colspan="7">No products found.</td> <!-- Adjusted colspan --> 
                        </tr>';
            }
            ?>
        </tbody>
    </table>
    </div>

<?php
// Close the database connection
$connection->close();
?>

<script src='script.js'></script>

<!-- Bootstrap/js -->
<script src='https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js' integrity='sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl' crossorigin='anonymous'></script>

</body></html>
