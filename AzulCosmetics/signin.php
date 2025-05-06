<?php
session_start();
include 'db.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Sign In</title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=2.0, minimum-scale=0.5">
        <link rel="stylesheet" href="forms.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Kaushan+Script&family=Unna:ital,wght@1,700&display=swap" rel="stylesheet">
    </head>

    <body>
        <div class="main-container">
            <div class="banner">
                <img src="images/cover.png" alt="cover">
            </div>

            <div class="signin-container">
                <h2 style="text-align: center; color: rgba(255, 53, 53, 0.74);">Sign in</h2>
                
                <form action="signinform.php" method="POST">

                    <div class="user-pass">
                        <input type="text" placeholder="Username" id="username" name="username"> <br>
                        <input type="password"  required placeholder="Password" id="password" name="password">
                    </div>

                    <div style="display: flex; align-items: center; justify-content: space-between; margin: 7px auto 20px auto;">
                        <div class="remember">
                            <input type="checkbox"><p>Remember me</p>
                        </div>
                        
                        <div class="forgot">
                            <p>Forgot Password</p>
                        </div>
                    </div>

                    <button type="submit" class="sign-in-but">Sign In</button>
                    
                    <a href="regform.html" style="text-decoration: none; font-size: 12px; text-align: center; font-weight: 200; color: rgb(0, 0, 0);"> 
                        <p>Don't have an account?</p>
                    </a>
                </form>
            </div>
        </div>
    </body>
</html>