<?php
session_start();
include 'db.php';

// Initialize an error message variable
$errorMessage = '';

// Check if there's an error message stored in session
if (isset($_SESSION['errorMessage'])) {
    $errorMessage = $_SESSION['errorMessage'];
    unset($_SESSION['errorMessage']); // Clear the error message from the session
}

$redirectTo = isset($_SESSION['redirectTo']) ? $_SESSION['redirectTo'] : 'signin.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the submitted email and password from the login form
    $email = $_POST['username'];
    $password = $_POST['password'];

    // Prepare SQL query to check if user exists based on email
    $sql = "SELECT * FROM usersheet WHERE username = :username";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // Store the username and role in the session
        $_SESSION['username'] = $user['username']; // Store the username
        $_SESSION['user'] = $user['username']; // Store the username for user-specific pages
        $_SESSION['role'] = $user['role']; // Store the user's role (admin or user)

        // Redirect user based on their role
        if ($user['role'] === 'admin') {
            // Redirect admin to the admin page
            header("Location: index.php");
            exit;
        } else {
            // Redirect regular user to user page
            header("Location: index.php");
            exit;
        }
    } else {
        // Invalid credentials, show error message and redirect back
        $_SESSION['errorMessage'] = "Invalid username or password."; // Store error message in session
        header("Location: $redirectTo"); // Redirect to the previous page
        exit;
    }
} else {
    // Store the current page (referrer) in session for redirect after login
    $_SESSION['redirectTo'] = $_SERVER['HTTP_REFERER'] ?? 'index.php';
}
?>
