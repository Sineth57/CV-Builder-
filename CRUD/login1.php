<?php

//Include configuration file
include 'config.php';

//Session start
session_start();

//Check whether the logging form is submitted
if (isset($_POST['submit'])) {

    //Filter and retrieve email and password
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    //Hash the password
    $pass = md5($_POST['pass']);  
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);

    //SQL query to check user credentials
    $select = $conn->prepare(
        'SELECT * FROM `users` WHERE email = ? AND password = ?'
    );
    $select->execute([$email, $pass]);
    $row = $select->fetch(PDO::FETCH_ASSOC);

    //Check usre credentials
    if ($select->rowCount() > 0) {

        //Check user type and redirect
        if ($row['user_type'] == 'admin') {
            $_SESSION['admin_id'] = $row['id'];
            header('location:admin_page.php');
        } elseif ($row['user_type'] == 'user') {
            $_SESSION['user_id'] = $row['id'];

            // Store value of cart_id
            $_SESSION['cart_id'] = $row['cart_id'];

            header('location:./site-home/index.php');
        } else {
            $message[] = 'No user found!';
        }
    } else {
        //Display error message for incorrect email or password
        $show_error = true;
        $error_message = 'Incorrect email or password!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login1.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <link rel="shortcut icon" type="x-icon" href="logo.png">
    <title>Login page</title>
</head>

<body>

    <!-- Display masseages -->
    <?php if (isset($message)) {
        foreach ($message as $message) {
            echo '
         <div class="message">
            <span>' .
                $message .
                '</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
         </div>
         ';
        }
    } ?>

    <!-- Left side image -->
    <section class="side">
        <img src="./img/img.svg" alt="">
    </section>

    <!-- Loggin form -->
    <section class="main">
        <div class="login-container">
            <p class="title">Welcome back</p>
            <div class="separator"></div>
            <p class="welcome-message">Please, provide login credentials to proceed and have access to all our services
            </p>

            <form action="" method="post" enctype="multipart/form-data" class="login-form">
                <div class="form-control">
                    <input type="email" required placeholder="Enter your email" class="box" name="email">
                    <i class="fas fa-user"></i>
                </div>
                <div class="form-control">
                    <input type="password" required placeholder="Enter your password" class="box" name="pass">
                    <i class="fas fa-lock"></i>
                </div>

                <button type="submit" value="login now" class="submit" name="submit">Login</button>
            </form>
            <!-- Link to register page -->
            <p class="register">Don't have an account?</p>
            <a href="register1.php">Create account</a>
        </div>
    </section>

</body>

<script>
    //Display alert with error massages
    alert("<?php echo $error_message; ?>");
</script>

</html>
