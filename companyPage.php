<?php
session_start();
include "dbConnection.php";

//if ($_SESSION['cid'] == null) {
//    echo "<script>alert('An error occurred, Please Try to re-Login');
//    window.location.href = 'login.php';
//                   </script>";
//    exit(1);
//}

print_r($_SESSION);
$cid = $_SESSION['cid'];



$query = "select * from company c where c.cid = '$cid'";

$result = mysqli_query($conn, $query);

$info = mysqli_fetch_array($result);
$name = $info['name'];
$address = $info['address'];
$phone = $info['phone'];

$string = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST['type'] == 'hrrname'){
        $query = "select distinct h.fname, h.lname from hrr h, job_posting j, company c where h.username = j.hrr_username and c.cid = j.comp_cid and c.name like '$name'";
    }elseif ($_POST['type'] == 'compposting'){

    }

    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) != 0) {
        while ($info = mysqli_fetch_array($result)) {
            $string .= "<li>" . $info['fname'] . ', ' . $info['lname'] . "</li><br>";
//            $string .= "<li><a href='" . 'listAllDetails.php?fname=' . $info['fname'] . '&' . 'lname=' . $info['lname'] . "'>" . $info['lname'] . ', ' . $info['fname'] . "</a></li><br>";
        }
    } else
        $string = "No results found";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Company Control Page</title>
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
    </style>
</head>
<body>
<div class="parent">
    <div class="main">
        <div style="text-align: center;"><span
                    style="font-weight: bold;font-size: 160%;font-family: 'Rockwell Nova Light',serif ">Welcome To <?php echo $name ?> Company</span>
            <br><br>
            <div style="display: flex;justify-content: space-evenly;flex-direction: row">
                <span><?php echo 'CID : ' . $cid ?> </span>
                <span><?php echo 'Phone : ' . $phone ?> </span>
            </div>
        </div>
    </div>

    <div style="margin-top: 40px;margin-left: 30px">
        <button class="logout" type="button" onclick="<?php session_destroy(); ?>location.href='login.php'"> LOGOUT
        </button>
    </div>
</div>

<div style="font-weight: bold;font-family: 'Rockwell Nova Light',serif;font-size: 25px;text-align: center;margin-top: 30px">
    Company Control Panel
</div>
<div style="font-size: 20px;text-align: center;margin-top: 8px;margin-left: 210px">-------------------- End-User Who
    Applied to a postings Panel -------------------
</div>

<div class="parent" style="margin-top: 10px">
    <form name="type"class="form" method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <button value="hrrname">HRR Name That <br>Posted Jobs</button>
        <button value="compposting">Company's <br>Job Postings</button>
        <button>Applications <br>to each posting</button>
        <span class="vertical"></span>
        <button>unemployed<br>end-users</button>
        <button>Users who worked at the same<br> company for the longest period</button>
        <button>number of applications<br>for each users</button>
        <button>Display user with <br>maximum experience</button>
        <span class="vertical"></span>
        <button>Display internship<br>postings</button>
    </form>

    <?php echo $string ?>

</div>

</body>
</html>
