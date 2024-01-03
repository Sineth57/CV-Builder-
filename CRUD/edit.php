<?php

//Include configuration file
include 'config.php';

//Initialize variables to store user data and messages
$id = '';
$name = '';
$email = '';
$user_type = '';

$error = '';
$success = '';

//Check whether the request method is get
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  //Check whether the id is not set
    if (!isset($_GET['id'])) {
        header('location:crud100/index.php');
        exit();
    }

    //Retrieve id
    $id = $_GET['id'];

    //SQL Query to fetch data
    $sql = "select * from users where id=$id";
    $result = $conn->query($sql);
    $row = $result->fetch(PDO::FETCH_ASSOC);
    while (!$row) {
        header('location: crud100/index.php');
        exit();
    }

    //Assign user data to variables for use in the HTML form
    $name = $row['name'];
    $email = $row['email'];
    $user_type = $row['user_type'];
} else {
   //If the request method is not GET retrieve data from the POST parameters
    
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $user_type = $_POST['user_type'];

    //SQL query to update uesr
    $sql = "update users set name='$name', email='$email', user_type='$user_type' where id='$id'";
    //Execute update query
    $result = $conn->query($sql);
    header('location:userdb.php');
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Database</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap links -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <link rel="shortcut icon" type="x-icon" href="logo.png">
</head>

<body style="background-image: url('pexels-pixabay-207247.jpg');">
    
    <div class="col-lg-6 m-auto">

        <!-- Form to update user data -->
        <form method="post">

            <br><br>
            <div class="card">

                <div class="card-header bg-warning">
                    <h1 class="text-white text-center"> Update User </h1>
                </div><br>

                <!-- Hidden input field for id -->
                <input type="hidden" name="id" value="<?php echo $id; ?>" class="form-control"> <br>

                <label> NAME: </label>
                <input type="text" name="name" value="<?php echo $name; ?>" class="form-control"> <br>

                <label> EMAIL: </label>
                <input type="text" name="email" value="<?php echo $email; ?>" class="form-control"> <br>

                <label> USER TYPE: </label>
                <input type="text" name="user_type" value="<?php echo $user_type; ?>" class="form-control"> <br>



                <button class="btn btn-success" type="submit" name="submit"> Submit </button><br>
                <a class="btn btn-info" type="submit" name="cancel" href="userdb.php"> Cancel </a><br>

            </div>
        </form>
    </div>
</body>

</html>