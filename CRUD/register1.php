<?php

//Include configuration file
include 'config.php';

//Check whether the registration form is submitted
if (isset($_POST['submit'])) {
    //Filter and retriveve input data from form
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $pass = md5($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);
    $cpass = md5($_POST['cpass']);
    $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

    //Retrivve images from the form
    $image = $_FILES['image']['name'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_size = $_FILES['image']['size'];
    $image_folder = 'uploaded_img/' . $image;

    //Check whether user is already registered
    $select = $conn->prepare('SELECT * FROM `users` WHERE email = ?');
    $select->execute([$email]);

    if ($select->rowCount() > 0) {
        $message[] = 'User already exists!';
    } else {
        //Check whether the password is matched
        if ($pass != $cpass) {
            $message[] = 'Confirm password not matched!';
        } elseif ($image_size > 2000000) {
            $message[] = 'Image size is too large!';
        } else {
            $insert = $conn->prepare('INSERT INTO `users`(name, email, password, image) VALUES(?,?,?,?)');
            $insert->execute([$name, $email, $cpass, $image]);

            //Check whether the data adding is successfull
            if ($insert) {
                // Move uploaded image to folder
                move_uploaded_file($image_tmp_name, $image_folder);
                $message[] = 'Registered successfully!';
                header('location:login1.php');
            } else {
                $message[] = 'Could not register the user.';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="register1.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <link rel="shortcut icon" type="x-icon" href="logo.png">
    <title>Register page</title>
</head>

<body>

    <!-- Display messages to user -->
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

    <!-- Left image -->
    <section class="side">
        <img src="./img/img.svg" alt="">
    </section>

        <!-- registraiton form -->
    <section class="main">
        <div class="login-container">
            <p class="title">Register Now</p>
            <div class="separator"></div>
            <p class="welcome-message">Please, fill in the information asked below to proceed and have access to all
                our services</p>

            <form action="" method="post" enctype="multipart/form-data" class="login-form">
                <div class="form-control">
                    <input type="text" required placeholder="Enter your username" class="box" name="name">
                    <i class="fas fa-user"></i>
                </div>
                <div class="form-control">
                    <input type="email" required placeholder="Enter your email" class="box" name="email">
                    <i class="fas fa-user"></i>
                </div>
                <div class="form-control">
                    <input type="password" required placeholder="Enter your password" class="box" name="pass">
                    <i class="fas fa-lock"></i>
                </div>
                <div class="form-control">
                    <input type="password" required placeholder="Confirm your password" class="box" name="cpass">
                    <i class="fas fa-lock"></i>
                </div>
                <div class="form-control">
                    <input type="file" name="image" required class="box" accept="image/jpg, image/png, image/jpeg">
                    <i class="fas fa-user"></i>
                </div>
                <button type="submit" value="" class="submit" name="submit">Submit</button>
            </form>
            <!-- Link to logging page if user has already registered -->
            <p class="register">Already have an account?</p>
            <a href="login1.php">Login to your account</a>
        </div>
    </section>

</body>

</html>
