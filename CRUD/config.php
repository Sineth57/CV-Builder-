<?php

//Database connection
$db_name = "mysql:host=localhost;dbname=user_form";
$username = "root";
$password = "";

//Create php data object for database connection
$conn = new PDO($db_name, $username, $password);

//$conn = mysqli_connect('localhost', 'root', '', 'user_form');
?>