<?php

//Include configuration file
include 'config.php';

//Start the session
session_start();

//Get user id from the session
$user_id = $_SESSION['user_id'];

//Check whether the user is not set, if not redirects to login page
if (!isset($user_id)) {
    header('location: login1.php');
    exit();
}

//Query to retrieve unread notifications for the user
$select_notifications = $conn->prepare('SELECT * FROM notifications WHERE user_id = ? AND is_read = 0');
$select_notifications->execute([$user_id]);
$notifications = $select_notifications->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>User Profile Page</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <link rel="shortcut icon" type="x-icon" href="logo.png">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/notifications.css">

   

   
</head>

<body style="background-image: url('B1.jpg'); width:100%">

    <h1 class="title"> <span>user</span> profile page </h1>

    <!-- Container for displaying notifications -->
    <div id="notifications-container" class="notifications-container">
    <h3>Notifications</h3>
    <ul class="notifications-list">
        <!-- Loop for notifications and display each with a time and date -->
        <?php foreach ($notifications as $notification) : ?>
            <li><?= $notification['message'] ?> - <?= $notification['timestamp'] ?></li>
            <hr>
        <?php endforeach; ?>
    </ul>
</div>

            <!-- Navigation button -->
    <div class="fab-container">
        <div class="fab fab-icon-holder">
            <i class="fa fa-bars"></i>
        </div>

        <ul class="fab-options">
            <a href="./site-home/#home">
                <li>
                    <div class="fab-icon-holder">
                        <i class="fas fa-home"></i>
                    </div>
                    <span class="fab-label">Home</span>
                </li>
            </a>

            <a href="./site-home/#service">
                <li>
                    <div class="fab-icon-holder">
                        <i class="fas fa-book" aria-hidden="true"></i>
                    </div>
                    <span class="fab-label">Service</span>
                </li>
            </a>

            <a href="./site-home/#contact">
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

    <!-- <div class="notification-icon" onclick="toggleNotifications()">
    <i class="fas fa-bell"></i>
    </div> -->

    <div class="notification-icon" onclick="toggleNotifications()">
    <i class="fas fa-bell"></i>
    <div class="notification-dot" id="notification-dot"></div>
    </div>
   
            <!-- Container for user profile -->
    <section class="profile-container">
        <?php
        //Fetch user details from users table in database
        $select_profile = $conn->prepare('SELECT * FROM `users` WHERE id = ?');
        $select_profile->execute([$user_id]);
        $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
        ?>
        <!-- Display user profile details -->
        <div class="profile">
            <img src="uploaded_img/<?= $fetch_profile['image'] ?>" alt="">
            <h3>User ID: <?= $fetch_profile['id'] ?></h3>
            <h3>Name: <?= $fetch_profile['name'] ?></h3>

            <!-- Buttons for navigation through pages -->
            <div class="flex-btn">
                <a href="site-home/index.php" class="option-btn">Go to Home</a>
                <a href="php admin crud/database2.php" class="option-btn">My Listings</a>
            </div>
            <br>
            <a href="user_profile_update.php" class="btn">Update Profile</a>
            <a href="logout.php" class="delete-btn">Logout</a>
            <a href="php admin crud/cart.php" class="option-btn">My Cart</a>
            <br>
        </div>
    </section>


<script>
    function toggleNotifications() {
        var notificationsContainer = document.getElementById('notifications-container');
        notificationsContainer.style.display = (notificationsContainer.style.display === 'block') ? 'none' : 'block';

        // Hide the red dot when notifications are opened
        var notificationDot = document.getElementById('notification-dot');
        notificationDot.style.display = 'none';
    }

    // Function to show the red dot (called when a new notification arrives)
    function showNotificationDot() {
        var notificationDot = document.getElementById('notification-dot');
        notificationDot.style.display = 'block';
    }
</script>


</body>

</html>
