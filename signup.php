<?php

$showAlert = false;
$showError = false;

if ($_SERVER["REQUEST_METHOD"] == "POST")
{

    include 'partials/_dbconnect.php';

    $username = $_POST['username'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    // $exist = false;
    // SQL query to check for unique usernames
    $existSql = "SELECT * FROM `users` WHERE username='$username'";
    $existResult = mysqli_query($conn, $existSql);
    $numExistRow = mysqli_num_rows($existResult);
    if ($numExistRow > 0)
    {
        // $exist = true;
        $showError = "Username already exist";
    }
    else
    {
        // $exist = false;
        if ($password == $cpassword)
        {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            // Default signup page role value is set to 1
            $role = 1;

            $sql = "INSERT INTO `users` (`role`, `username`, `password`) VALUES ('$role', '$username', '$hash');";
            $result = mysqli_query($conn, $sql);
            if ($result)
            {
                $showAlert = true;
            }
        }
        else
        {
            $showError = "Password did not match";
        }
    }

}

?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <title>Signup</title>
</head>

<body>

    <?php require 'partials/_nav.php' ?>

    <?php
if ($showAlert)
{
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> Your account is created now you can <a href="/ellipsonic/login.php"
                class="alert-link">login</a>.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>';
}
else if ($showError)
{
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error! </strong>' . $showError . '
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>';
}
?>

    <div class="container my-4 col-6 bg-secondary bg-opacity-10 rounded-3 py-4 px-4 center ">

        <div class="my-4">
            <h4>Signup to our website</h4>
        </div>

        <form action="/ellipsonic/signup.php" method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" aria-describedby="emailHelp"
                    required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="cpassword">Confirm Password</label>
                <input type="password" class="form-control" id="cpassword" name="cpassword" required>
                <small id="emailHelp" class="form-text text-muted">Type the same password.</small>
            </div>

            <button type="submit" class="btn btn-primary">Signup</button>
        </form>

    </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
    </script>

    <!-- Option 2: jQuery, Popper.js, and Bootstrap JS
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
    -->
</body>

</html>