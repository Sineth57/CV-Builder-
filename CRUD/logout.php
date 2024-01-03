<?php

//Include configuration file
include 'config.php';

//Start the session
session_start();

//Clear session data
session_unset();

//Remove all the session data
session_destroy();


//Redirect user to login page
header('location:login1.php');

?>