<?php

$server = "localhost";
$username = "root";
$password = "";
$db = "ellipsonic";

$conn = mysqli_connect($server, $username, $password, $db);

if($conn){
    // echo "Success";
}else{
    die("Error" . mysqli_connect_error());
}

?>
