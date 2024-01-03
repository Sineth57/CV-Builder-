<?php

//Include configuration file
include 'config.php';

//Check whether the id is set
if (isset($_GET['id'])) {
    //Retrive the id parameter
    $id = $_GET['id'];

    //SQL query to delete user
    $sql = "DELETE from `users` where id=$id";

    //Execute query
    $conn->query($sql);
}
//Redirect userdb page after deleting
header('location:userdb.php');

exit();
?>
