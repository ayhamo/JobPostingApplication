<?php
$dbname = "jobpostings";
$conn = mysqli_connect("localhost", "root", "", $dbname);

if ($conn->connect_errno) {
    echo 'Failed to connect to mySQL' . $conn->connect_error;
    exit();
}else
//echo 'Connected to mySQL !! <br>';
?>