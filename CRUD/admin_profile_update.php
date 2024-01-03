<?php

//Include the configuration file
include 'config.php';

//Start the sessison
session_start();

//Get the Id of the admin from the session
$admin_id = $_SESSION['admin_id'];

//Check whether the admin id is set, if not redirects to the login page
if (!isset($admin_id)) {
    header('location:login1.php');
}

//Check whether the updating details form is submitted to submit the page
if (isset($_POST['update'])) {
    //Filter and retrieve input data
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);

    //SQL query to update data
    $update_profile = $conn->prepare(
        'UPDATE `users` SET name = ?, email = ? WHERE id = ?'
    );
    $update_profile->execute([$name, $email, $admin_id]);

    //Filter and retrive input images
    $old_image = $_POST['old_image'];
    $image = $_FILES['image']['name'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_size = $_FILES['image']['size'];
    $image_folder = 'uploaded_img/' . $image;

    //Check whether the new image is provided
    if (!empty($image)) {
        if ($image_size > 2000000) {
            $message[] = 'image size is too large';
        } else {
            //SQL query to update the image
            $update_image = $conn->prepare(
                'UPDATE `users` SET image = ? WHERE id = ?'
            );
            $update_image->execute([$image, $admin_id]);

            //Move uploaded image to thr folder
            if ($update_image) {
                move_uploaded_file($image_tmp_name, $image_folder);
                unlink('uploaded_img/' . $old_image);
                $message[] = 'image has been updated!';
            }
        }
    }


    //Filter and retrive data for password
    $old_pass = $_POST['old_pass'];
    $previous_pass = md5($_POST['previous_pass']);
    $previous_pass = filter_var($previous_pass, FILTER_SANITIZE_STRING);
    $new_pass = md5($_POST['new_pass']);
    $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
    $confirm_pass = md5($_POST['confirm_pass']);
    $confirm_pass = filter_var($confirm_pass, FILTER_SANITIZE_STRING);

    //Check all old, new, confirm passwords are provided
    if (!empty($previous_pass) || !empty($new_pass) || !empty($confirm_pass)) {

        //Chech whether the old password matched with stored password
        if ($previous_pass != $old_pass) {
            $message[] = 'old password not matched!';
        } elseif ($new_pass != $confirm_pass) {
            $message[] = 'confirm password not matched!';
        } else {
            //SQL query to update password
            $update_password = $conn->prepare(
                'UPDATE `users` SET password = ? WHERE id = ?'
            );
            $update_password->execute([$confirm_pass, $admin_id]);
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

    <title>admin profile update</title>
    <!-- Font awesome css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <link rel="shortcut icon" type="x-icon" href="logo.png">
    <!-- Include css file -->
    <link rel="stylesheet" href="css/style.css">

</head>
<!-- Start the body -->
<body style="background-image: url('B1.jpg');">

    <!-- Navigation option -->
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

    <!-- Check whether the message variable is set -->
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

    <h1 class="title"> update <span>admin</span> profile </h1>

    <!-- Profile updating window -->
    <section class="update-profile-container">

        <?php
        //Fetch admin details for the form
        $select_profile = $conn->prepare('SELECT * FROM `users` WHERE id = ?');
        $select_profile->execute([$admin_id]);
        $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
        ?>

    <!-- Form to update details -->
        <form action="" method="post" enctype="multipart/form-data">
            <img src="uploaded_img/<?= $fetch_profile['image'] ?>" alt="">
            <div class="flex">
                <div class="inputBox">
                    <span>username : </span>
                    <input type="text" name="name" required class="box" placeholder="enter your name" value="<?= $fetch_profile[
                        'name'
                    ] ?>">
                    <span>email : </span>
                    <input type="email" name="email" required class="box" placeholder="enter your email" value="<?= $fetch_profile[
                        'email'
                    ] ?>">
                    <span>profile pic : </span>
                    <input type="hidden" name="old_image" value="<?= $fetch_profile[
                        'image'
                    ] ?>">
                    <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png">
                </div>
                <div class="inputBox">
                    <input type="hidden" name="old_pass" value="<?= $fetch_profile[
                        'password'
                    ] ?>">
                    <span>old password :</span>
                    <input type="password" class="box" name="previous_pass" placeholder="enter previous password">
                    <span>new password :</span>
                    <input type="password" class="box" name="new_pass" placeholder="enter new password">
                    <span>confirm password :</span>
                    <input type="password" class="box" name="confirm_pass" placeholder="confirm new password">
                </div>
            </div>
            <div class="flex-btn">
                <input type="submit" value="update profile" name="update" class="btn">
                <a href="admin_page.php" class="option-btn">go back</a>
            </div>
        </form>

    </section>

</body>

</html>