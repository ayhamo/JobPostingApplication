<?php
session_start();
include "dbConnection.php";

//prevent any unauthorized login and in case of fail, it returns to logout page
if(!isset($_SESSION['username'])){
    echo "<script>alert('An error occurred, Please Try to re-Login');
    window.location.href = 'logoutLanding.php';
                   </script>";
    exit(1);
}
//we used sessoins to make our login system and logout which is very easy and handy to use, but ofc not as secure
$username = $_SESSION['username'];


//get user info
$query = "select * from hrr e where e.username = '$username'";

$result = mysqli_query($conn, $query);

$info = mysqli_fetch_array($result);
$fname = $info['fname'];
$lname = $info['lname'];

$string = "Welcome (≧∇≦)ﾉ";

//all buttons functionality using if
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST['buttontype'] == 'partsummerjob') {
//        $_SESSION['cid'] = $username;
//        header("Location: companyPage.php");
    }

    $result = mysqli_query($conn, $query);

    //building all data from sql
    if (mysqli_num_rows($result) != 0) {
        while ($info = mysqli_fetch_array($result)) {
            if ($_POST['buttontype'] == 'hrrname') {
            }
        }
    } else
        $string .= "<br>No results found";
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>HRR Control Page</title>
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
            margin-left: 80px;
            font-size: 120%;
        }

        .logout {
            font-family: serif;
            font-size: 16px;
            color: #ffffff;
            min-width: 160px;
            height: 55px;
            background-color: #333333;
            border-radius: 31px;
        }

        .vertical {
            padding-bottom: 15px;
            margin-left: 7px;
            margin-right: 7px;
            border-left: solid #000000;
        }

        .resultBox {
            margin-top: 25px;
            font-size: 30px;
            display: flex;
            flex-direction: column;
            text-align: center;
        }

        li {
            line-height: 40px
        }
    </style>
</head>
<body>
<div class="parent">
    <div class="main">
        <div style="text-align: center;"><span
                    style="font-weight: bold;font-size: 160%;font-family: 'Rockwell Nova Light',serif ">Welcome <?php echo $fname . ' ' . $lname ?></span>

            <br><br>
            <div style="display: flex;justify-content: space-evenly;flex-direction: row">
                <span>username: <?php echo $username ?> </span>
            </div>
        </div>
    </div>

    <div style="margin-top: 40px;margin-left: 30px">
        <button class="logout" type="button" onclick="location.href='logoutLanding.php'"> LOGOUT
        </button>
    </div>
</div>

<div style="font-weight: bold;font-family: 'Rockwell Nova Light',serif;font-size: 25px;text-align: center;margin-top: 30px;margin-right: 20px">
    HRR Control Panel
</div>
<div class="parent" style="margin-top: 10px">
    <form class="form" method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <button name="buttontype" value="alljob">List all job<br> Postings</button>
        <button name="buttontype" value="openjob">List open <br>Job postings</button>
        <span class="vertical"></span>
        <button name="buttontype" value="unemuser">Company that offers<br>highest paying jobs</button>
        <button name="buttontype" value="partsummerjob">Search for part time jobs<br>during the summer in a place</button>

    </form>
</div>

<label class="resultBox">
    <?php echo $string ?>
</label>

</body>
</html>