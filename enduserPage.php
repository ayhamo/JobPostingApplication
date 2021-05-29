<?php
session_start();
include "dbConnection.php";

//prevent any unauthorized login and in case of fail, it returns to logout page
if (!isset($_SESSION['username'])) {
    echo "<script>alert('An error occurred, Please Try to re-Login');
    window.location.href = 'logoutLanding.php';
                   </script>";
    exit(1);
}
//we used sessoins to make our login system and logout which is very easy and handy to use, but ofc not as secure
$username = $_SESSION['username'];


//get user info
$query = "select * from end_user e where e.username = '$username'";

$result = mysqli_query($conn, $query);

$info = mysqli_fetch_array($result);
$fname = $info['fname'];
$lname = $info['lname'];

$stat = $info['military_service_stat'];
if ($stat == "C") {
    $stat = "Completed";
} elseif ($stat == "E") {
    $stat = "Exempt";
} else
    $stat = "Delayed";


$string = "Welcome (≧∇≦)ﾉ";
$intern = "";
$internquery = "d";

//all buttons functionality using if
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST['buttontype'] == 'alljob') {
        $query = "select * from job_posting";
        $internquery = "select j.jid from job_posting J natural join internshipJobPosting J1";
        $string = "Job Postings<br><br>";
        $intern = "<hr style='border-top: 3px dotted #3d3d3d;'>Internship Postings<br><br>";
    } elseif ($_POST['buttontype'] == 'openjob') {
        $query = "select * from job_posting where numOpenings > 0";
        $internquery = "select j.jid from job_posting J natural join internshipJobPosting J1 where numOpenings > 0";
        $string = "Open Job Postings<br><br>";
        $intern = "<hr style='border-top: 3px dotted #3d3d3d;'>Open Internship Postings<br><br>";
    } elseif ($_POST['buttontype'] == 'highjob') {
        $query = "select c.name,j.salary from job_posting as j join company c on j.comp_cid = c.cid where j.salary = (select max(salary) from job_posting)";
        $string = "Companies that offer <br>Highest paying jobs<br><br>";
    } elseif ($_POST['buttontype'] == 'highmanjob') {
        $query = "select description, salary, c.name from job_posting, company c where salary = ( select max(j.salary)
				from job_posting j, manager_job_posting m where j.is_manOrIntern=1 and j.jid=m.jid and m.deptSize<50) and comp_cid=c.cid";
        $string = "Companies that offers highest manager<br>Job with department size bigger than 50<br><br>";
    } elseif ($_POST['buttontype'] == 'searchpt') {
        $string = "Part time Jobs during <br>Summer located at {$_POST['text']}<br>&nbsp";
        $query = "select J.description, J.salary,C.address from job_posting J, company C where J.contract_type='PT' and J.comp_cid=C.cid and C.address like '%{$_POST['text']}%'";
    } elseif ($_POST['buttontype'] == 'serachcomp') {
        $string = "Open internship jobs for {$_POST['text']}<br>That allows minimum 20 days<br>&nbsp";
        $query = "select j.jid,j.description,j.phone,j1.minnumDays from job_posting J natural join internshipJobPosting J1 join company C on J.comp_cid = C.cid 
                  where C.name = '{$_POST['text']}'  and J1.minnumdays>20";
    }

    $result = mysqli_query($conn, $query);

    $internresult = mysqli_query($conn, $internquery);
    if ($internresult) {
        if (mysqli_num_rows($internresult) != 0) {
            while ($row = mysqli_fetch_array($internresult)) {
                $array[] = $row['jid'];
            }
        } else
            $array[] = array();
    }

    //building all data from sql
    if (mysqli_num_rows($result) != 0) {
        while ($info = mysqli_fetch_array($result)) {
            if ($_POST['buttontype'] == 'alljob') {
                if (in_array($info['jid'], $array)) {
                    $intern .= "<li style='list-style: none;'>JID: " . $info['jid'] . ' , ' . $info['description'] . ', Open For ' . $info['numOpenings']
                        . ' People, Call ' . $info['phone'] . "</li>";
                } else {
                    $string .= "<li style='list-style: none;'>JID: " . $info['jid'] . ' , ' . $info['description'] . ' , ' . $info['salary'] . '$, Open For ' . $info['numOpenings']
                        . ' People, Call ' . $info['phone'] . "</li>";
                }
            } elseif ($_POST['buttontype'] == 'openjob') {
                if (in_array($info['jid'], $array)) {
                    $intern .= "<li style='list-style: none;'>JID: " . $info['jid'] . ' , ' . $info['description'] . ', Open For ' . $info['numOpenings']
                        . ' People, Call ' . $info['phone'] . "</li>";
                } else {
                    $string .= "<li style='list-style: none;'>JID: " . $info['jid'] . ' , ' . $info['description'] . ' , ' . $info['salary'] . '$, Open For ' . $info['numOpenings']
                        . ' People, Call ' . $info['phone'] . "</li>";
                }
            } elseif ($_POST['buttontype'] == 'highjob') {
                $string .= "<li style='list-style: none;'>" . $info['name'] . " Offers the highest job with salary " . $info['salary'] . " $</li>";
            } elseif ($_POST['buttontype'] == 'highmanjob') {
                $string .= "<li style='list-style: none;'>" . $info['name'] . " Offers the highest manager job with salary " . $info['salary'] . "$, as a " . $info['description'] . "</li>";
            } elseif ($_POST['buttontype'] == 'searchpt') {
                $string .= "<li style='list-style: none;'>" . $info['description'] . ' , ' . $info['salary'] . '$ For Company located at ' . $info['address'] . "</li>";
            } elseif ($_POST['buttontype'] == 'serachcomp') {
                $string .= "<li style='list-style: none;'>JID: " . $info['jid'] . ' , ' . $info['description'] . ', At least ' . $info['minnumDays'] . ' Days, Call ' . $info['phone'] . "</li>";
            }
        }
    } else
        $string .= "<br>No results found";
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>User Control Page</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /*        have no idea why, but if placed in style file it does not work, had to move it to here*/
        .searchbar {
            height: 30px;
            border-radius: 31px;
            padding-left: 10px;
            outline: none;
        }

        .search {
            font-family: serif;
            font-size: 16px;
            color: #ffffff;
            min-width: 100px;
            height: 30px;
            background-color: #333333;
            border-radius: 31px;
            margin-top: 5px;
        }
    </style>
</head>
<body>
<div class="parent">
    <div class="main">
        <div style="text-align: center;"><span
                    style="font-weight: bold;font-size: 160%;font-family: 'Rockwell Nova Light',serif ">Welcome <?php echo $fname . ' ' . $lname ?></span>
            <br><br>
            <div style="display: flex;justify-content: space-evenly;flex-direction: column">
                <span>username: <?php echo $username ?> </span>
                <span><br>Military stat: <?php echo $stat ?></span>
            </div>
        </div>
    </div>

    <div style="margin-top: 80px;margin-left: 30px">
        <button class="logout" type="button" onclick="location.href='logoutLanding.php'"> LOGOUT
        </button>
    </div>
</div>

<div style="font-weight: bold;font-family: 'Rockwell Nova Light',serif;font-size: 25px;text-align: center;margin-top: 30px;margin-right: 20px">
    User Control Panel
</div>
<div class="parent" style="margin-top: 10px;flex-direction: column;align-items: center">
    <form style="flex-direction: row" method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <button name="buttontype" value="alljob">List all job<br> Postings</button>
        <button name="buttontype" value="openjob">List open<br>Job postings</button>
        <span class="vertical"></span>
        <button name="buttontype" value="highjob">Company that offers<br>highest paying jobs</button>
        <button name="buttontype" value="highmanjob">Highest paying manager job with <br>Department size bigger than 50
        </button>
    </form>

    <hr>
    <div style="flex-direction: row">
        <button onclick="showHide('Location','searchpt')">Search for part time jobs <br>during the summer in a location
        </button>
        <button onclick="showHide('Company Name','serachcomp')">List open internships for specific <br>company that
            allows more
            than 20 days
        </button>
    </div>
    <hr>
    <form id="searchForm" class="form" style="display: none" method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <input class="searchbar" name="text" id="child" type="search"
               required>
        <button class="search" id="child2" name="buttontype" type="submit">Submit</button>
    </form>
</div>

<script>
    function showHide(placeholder, value) {
        var x = document.getElementById("searchForm");
        document.getElementById("child").placeholder = placeholder;
        document.getElementById("child2").value = value;
        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
    }
</script>

<label class="resultBox" style="margin-top: 10px;">
    <?php echo $string ?>
    <div style="margin-top: 10px">
        <?php echo $intern ?>
    </div>
</label>

</body>
</html>