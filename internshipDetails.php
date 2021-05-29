<?php
include "dbConnection.php";
session_start();
//check companyPage please for explanation on this, and also if anyone tries to open the page with correct jid but not logged in.
if (!isset($_SESSION['cid'])) {
    echo "<script>alert('An error occurred, Please Try to re-Login');
    window.location.href = 'logoutLanding.php';
                   </script>";
    exit(1);
}

$cid = $_SESSION['cid'];

$query = "select * from company c where c.cid = '$cid'";

$result = mysqli_query($conn, $query);

$info = mysqli_fetch_array($result);
$name = $info['name'];
$address = $info['address'];
$phone = $info['phone'];

//very simple get method to get all data for internships and echoing them in html down.
$jid = $_GET['jid'];
$query = "SELECT * FROM job_posting WHERE jid=$jid";
$result = mysqli_query($conn, $query);
$info = mysqli_fetch_array($result);
$desc = $info['description'];
$numop = $info['numOpenings'];
$hrrname = $info['hrr_username'];
$opendate = $info['openingdate'];
$dur = $info['duration'];
$ctype = $info['contract_type'];
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Contact Details</title>
    <style>
        body {
            background-color: #e5e5e5;
        }

        .parent {
            font-family: sans-serif;
            display: flex;
            justify-content: center;
            background: transparent
            height: 100%;
            width: 100%;

        }

        .main {
            margin-top: 25px;
            font-size: 120%;
        }

    </style>
</head>
<body>
<div class="parent">
    <div class="main">
        <div style="text-align: center;"><span
                    style="font-weight: bold;font-size: 160%;font-family: 'Rockwell Nova Light',serif "><?php echo $name ?> Company <br>Internship Job Info</span>
            <br><br>
            <div style="display: flex;justify-content: space-evenly;flex-direction: row">
                <span><?php echo 'CID : ' . $cid ?> </span>
                <span><?php echo 'Phone : ' . $phone ?> </span>
            </div>
        </div>
    </div>
</div>
<br>
<div class="main" style="display:flex;justify-content:center;margin-right: 30px;font-size: 23px">
    <span style="font-size: 150%;font-weight: bold;"><?php ?></span><br>
    <ul>
        <li>JID: <span style="margin-left: 150px"><?php echo $jid ?></span></li>
        <br>
        <li>Description: <span style="margin-left: 80px"><?php echo $desc ?></span></li>
        <br>
        <li>Number Openings: <span style="margin-left: 20px"><?php echo $numop ?></span></li>
        <br>
        <li>HRR username: <span style="margin-left: 50px"><?php echo $hrrname ?></span></li>
        <br>
        <li>Opening Date: <span style="margin-left: 60px"><?php echo $opendate ?></span></li>
        <br>
        <li>Duration: <span style="margin-left: 145px"><?php echo $dur ?></span></li>
        <br>
        <li>Contract Type: <span style="margin-left: 97px"><?php echo $ctype ?></span></li>
    </ul>
</div>

<div style="margin-top: 9px;text-align: center;"><a
            style="font-family: Calibri Light,serif;  font-size: 25px;  color: #333333"
            href="companyPage.php">RETURN CONTROL PAGE</a></div>

</body>
</html>