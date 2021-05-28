<?php
session_start();
include "dbConnection.php";
//prevent any unauthorized login and in case of fail, it returns to logout page
if (!isset($_SESSION['cid'])) {
    echo "<script>alert('An error occurred, Please Try to re-Login');
    window.location.href = 'logoutLanding.php';
                   </script>";
    exit(1);
}
//we used sessoins to make our login system and logout which is very easy and handy to use, but ofc not as secure
$cid = $_SESSION['cid'];


//get company info
$query = "select * from company c where c.cid = '$cid'";

$result = mysqli_query($conn, $query);

$info = mysqli_fetch_array($result);
$name = $info['name'];
$address = $info['address'];
$phone = $info['phone'];

$string = "Welcome (≧∇≦)ﾉ";

//all buttons functionality using if
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST['buttontype'] == 'hrrname') {
        $query = "select distinct h.fname, h.lname from hrr h, job_posting j, company c where h.username = j.hrr_username and c.cid = j.comp_cid and c.name like '$name'";
        $string = "HRR's names that posted A job <br>Posting for  " . $name . " Company<br><br>";
    } elseif ($_POST['buttontype'] == 'compposting') {
        $query = "select j.description,j.salary,j.contract_type,j.jid from job_posting j where j.comp_cid = $cid";

        $numberResult = mysqli_query($conn, "select count(*) from job_posting j where j.comp_cid = $cid");
        $string = $name . " Job Postings<br> There is " . $total = mysqli_fetch_array($numberResult)[0] . "  Job postings that the company has<br><br>";
    } elseif ($_POST['buttontype'] == 'numappliposting') {
        $query = "select j.jid,count(*) as count from application a join job_posting j on a.jid = j.jid where j.comp_cid = $cid group by j.jid";
        $string = "Number of Applications for each posting <br>&nbsp";
    } elseif ($_POST['buttontype'] == 'unemuser') {
        $query = "select e.username from end_user E where E.username not in (select distinct username from eu_employer) 
        and e.username in (select a.username from application a join job_posting j on a.jid = j.jid where j.comp_cid = $cid)";
        $string = "Unemployed End-Users usernames <br>who applied for a job in the company<br>&nbsp";
    } elseif ($_POST['buttontype'] == 'longuser') {
        $query = "select e.username from eu_employer as e  where e.beginDate = (select min(beginDate) from eu_employer) 
                  and e.username in (select a.username from application a join job_posting j on a.jid = j.jid where j.comp_cid = $cid)";
        $string = "End-Users usernames who applied for a job and<br> worked for the longest period in the same company<br>&nbsp";
    } elseif ($_POST['buttontype'] == 'numappliuser') {
        $query = "select a.username,count(*) as count from application a join job_posting j on a.jid = j.jid where j.comp_cid = $cid group by a.username";
        $string = "Number of applications for each End-User<br> Who applied for a job in this company<br>&nbsp";
    } elseif ($_POST['buttontype'] == 'maxuserexp') {
        $query = "SELECT e.username, sum(DATEDIFF(EndDate, beginDate)) AS Duration FROM Employment_History e where 
                  e.username in (select ap.username from application ap join job_posting j on ap.jid = j.jid where j.comp_cid = $cid) GROUP BY e.username
                  HAVING Duration = (SELECT max(Duration) FROM ( SELECT eh.username, sum(DATEDIFF(EndDate, beginDate)) AS Duration
                FROM Employment_History eh GROUP BY eh.username ) h)";
        $string = "Usernames of whom applied for a<br> job and has maximum experience<br>&nbsp";
    } elseif ($_POST['buttontype'] == 'internship') {
        $query = "select j.jid,j.description from (job_posting J natural join internshipJobPosting J1) 
                  join company C on J.comp_cid = C.cid where C.cid = $cid";
        $string = "All Internship Postings<br>&nbsp";
    }

    $result = mysqli_query($conn, $query);

    //building all data from sql
    if (mysqli_num_rows($result) != 0) {
        while ($info = mysqli_fetch_array($result)) {
            if ($_POST['buttontype'] == 'hrrname') {
                $string .= "<li style='list-style: none;'>" . $info['fname'] . ' , ' . $info['lname'] . "</li>";
            } elseif ($_POST['buttontype'] == 'compposting') {
                $string .= "<li style='list-style: none;'>JID: " . $info['jid'] . " , " . $info['description'] . ", " . $info['salary'] . "$, Contract: " . $info['contract_type'] . "</li>";
            } elseif ($_POST['buttontype'] == 'numappliposting') {
                $string .= "<li>JID: " . $info['jid'] . " has " . $info['count'] . " Applicatoin/s.</li>";
            } elseif ($_POST['buttontype'] == 'unemuser') {
                $string .= "<li style='list-style: none;'>" . $info['username'] . "</li>";
            } elseif ($_POST['buttontype'] == 'longuser') {
                $string .= "<li>" . $info['username'] . "</li>";
            } elseif ($_POST['buttontype'] == 'numappliuser') {
                $string .= "<li style='list-style: none;'>User '" . $info['username'] . "' has applied for " . $info['count'] . " Applicatoins offerd</li>";
            } elseif ($_POST['buttontype'] == 'maxuserexp') {
                $string .= "<li>" . $info['username'] . "</li>";
            } elseif ($_POST['buttontype'] == 'internship') {
                $string .= "<li style='list-style: none;'><a href='" . 'internshipDetails.php?jid=' . $info['jid'] . "'>" . "JID: " . $info['jid'] . ' , ' . $info['description'] . "</a></li>";
            }
        }
    } else
        $string .= "<br>No results found";
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
                    style="font-weight: bold;font-size: 160%;font-family: 'Rockwell Nova Light',serif ">Welcome To <?php echo $name ?> Company</span>
            <br><br>
            <div style="display: flex;justify-content: space-evenly;flex-direction: row">
                <span><?php echo 'CID : ' . $cid ?> </span>
                <span><?php echo 'Phone : ' . $phone ?> </span>
            </div>
        </div>
    </div>

    <div style="margin-top: 40px;margin-left: 30px">
        <button class="logout" type="button" onclick="location.href='logoutLanding.php'"> LOGOUT
        </button>
    </div>
</div>

<div style="font-weight: bold;font-family: 'Rockwell Nova Light',serif;font-size: 25px;text-align: center;margin-top: 30px;margin-right: 20px">
    Company Control Panel
</div>
<div style="font-size: 20px;text-align: center;margin-top: 8px;margin-left: 210px">-------------------- End-User Who
    Applied to a postings Panel -------------------
</div>

<div class="parent" style="margin-top: 10px">
    <form class="form" method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <button name="buttontype" value="hrrname">HRR Names <br>That Posted Jobs</button>
        <button name="buttontype" value="compposting">Company's <br>Job Postings</button>
        <button name="buttontype" value="numappliposting">Applications <br>to each posting</button>
        <span class="vertical"></span>
        <button name="buttontype" value="unemuser">List unemployed<br>end-users</button>
        <button name="buttontype" value="longuser">Users who worked at the same<br> company for the longest period
        </button>
        <button name="buttontype" value="numappliuser">number of applications<br>for each users</button>
        <button name="buttontype" value="maxuserexp">Display users with <br>maximum experience</button>
        <span class="vertical"></span>
        <button name="buttontype" value="internship">Display internship<br>postings</button>
    </form>
</div>

<label class="resultBox">
    <?php echo $string ?>
</label>

</body>
</html>
