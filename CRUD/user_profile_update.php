<?php

//Include configuration file
include 'config.php';

//Start the session
session_start();

//Get user ID from the session
$user_id = $_SESSION['user_id'];

//Check whether the user id is set or not, if not redirects to login page
if (!isset($user_id)) {
    header('location:login.php');
}

//Check whether the form is submitted
if (isset($_POST['update'])) {

    //Filter and retrieve data
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);

    //SQL query to udate 
    $update_profile = $conn->prepare(
        'UPDATE `users` SET name = ?, email = ? WHERE id = ?'
    );
    $update_profile->execute([$name, $email, $user_id]);

    //Profile image update
    $old_image = $_POST['old_image'];
    $image = $_FILES['image']['name'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_size = $_FILES['image']['size'];
    $image_folder = 'uploaded_img/' . $image;

    if (!empty($image)) {
        if ($image_size > 2000000) {
            $message[] = 'image size is too large';
        } else {
            //Query to update the image
            $update_image = $conn->prepare(
                'UPDATE `users` SET image = ? WHERE id = ?'
            );
            $update_image->execute([$image, $user_id]);

            //Move updated image to the image folder
            if ($update_image) {
                move_uploaded_file($image_tmp_name, $image_folder);
                unlink('uploaded_img/' . $old_image);
                $message[] = 'image has been updated!';
            }
        }
    }

    //Update the password
    $old_pass = $_POST['old_pass'];
    $previous_pass = md5($_POST['previous_pass']);
    $previous_pass = filter_var($previous_pass, FILTER_SANITIZE_STRING);
    $new_pass = md5($_POST['new_pass']);
    $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
    $confirm_pass = md5($_POST['confirm_pass']);
    $confirm_pass = filter_var($confirm_pass, FILTER_SANITIZE_STRING);

    //Check old, new and confirm password
    if (!empty($previous_pass) || !empty($new_pass) || !empty($confirm_pass)) {
        //Check whether the old password it matched
        if ($previous_pass != $old_pass) {
            $message[] = 'old password not matched!';
        } elseif ($new_pass != $confirm_pass) {
            $message[] = 'confirm password not matched!';
        } else {
            //SQL query to update password
            $update_password = $conn->prepare(
                'UPDATE `users` SET password = ? WHERE id = ?'
            );
            $update_password->execute([$confirm_pass, $user_id]);
            $message[] = 'password has been updated!';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>user profile update</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <link rel="shortcut icon" type="x-icon" href="logo.png">

    <link rel="stylesheet" href="css/style.css">

</head>

<body style="background-image: url('B1.jpg');">

    <!-- Display messages -->
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

    <h1 class="title"> update <span>user</span> profile </h1>

    <!-- navigation button -->
    <div class="fab-container">
        <div class="fab fab-icon-holder">
            <i class="fa fa-bars"></i>
        </div>

        <ul class="fab-options">

            <a href="/site-home/#home">
                <li>

                    <div class="fab-icon-holder">
                        <i class="fas fa-home"></i>
                    </div>

                    <span class="fab-label">Home</span>

                </li>
            </a>

            <a href="/site-home/#service">
                <li>
                    <div class="fab-icon-holder">
                        <i class="fas fa-book" aria-hidden="true"></i>
                    </div>
                    <span class="fab-label">Service</span>
                </li>
            </a>

            <a href="/site-home/#contact">
                <li>
                    <div class="fab-icon-holder">
                        <i class="fas fa-comments"></i>
                    </div>
                    <span class="fab-label">Contacts</span>
                </li>
            </a>

            <a href="">
                <li>
                    <div class="fab-icon-holder">
                        <i class="fas fa-user-circle"></i>
                    </div>
                    <span class="fab-label">Profile</span>
                </li>
            </a>

        </ul>
    </div>

    <!-- Profile update -->
    <section class="update-profile-container">

        <?php
        //Fetch user data from the database
        $select_profile = $conn->prepare('SELECT * FROM `users` WHERE id = ?');
        $select_profile->execute([$user_id]);
        $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
        ?>

        <!-- Form for updating user profile -->
        <form action="" method="post" enctype="multipart/form-data">
            <img src="uploaded_img/<?= $fetch_profile['image'] ?>" alt="">
            <div class="flex">
                <div class="inputBox">
                    <span>Username : </span>
                    <input type="text" name="name" required class="box" placeholder="enter your name" value="<?= $fetch_profile[
                        'name'
                    ] ?>">
                    <span>Email : </span>
                    <input type="email" name="email" required class="box" placeholder="enter your email" value="<?= $fetch_profile[
                        'email'
                    ] ?>">
                    <span>Profile pic : </span>
                    <input type="hidden" name="old_image" value="<?= $fetch_profile[
                        'image'
                    ] ?>">
                    <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png">
                </div>
                <div class="inputBox">
                    <input type="hidden" name="old_pass" value="<?= $fetch_profile[
                        'password'
                    ] ?>">
                    <span>Old password :</span>
                    <input type="password" class="box" name="previous_pass" placeholder="enter previous password">
                    <span>new password :</span>
                    <input type="password" class="box" name="new_pass" placeholder="enter new password">
                    <span>confirm password :</span>
                    <input type="password" class="box" name="confirm_pass" placeholder="confirm new password">
                </div>
            </div>
            <!-- Buttons for submitting form and go back -->
            <div class="flex-btn">
                <input type="submit" value="update profile" name="update" class="btn">
                <a href="user_page.php" class="option-btn">go back</a>
            </div>
        </form>

    </section>

</body>

</html>