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
$query = "select * from hrr e where e.username = '$username'";

$result = mysqli_query($conn, $query);

$info = mysqli_fetch_array($result);
$fname = $info['fname'];
$lname = $info['lname'];

$string = "";
$insert = false;
$insertdouble = false;

//all buttons functionality using if
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST['buttontype'] == "mypost") {
        $query = "SELECT j.jid,j.description,j.numOpenings,j.openingdate,j.contract_type,c.name FROM job_posting j 
                  join company c on j.comp_cid = c.cid where hrr_username = '$username'";
        $string = "My Postings<br>";
    } elseif ($_POST['buttontype'] == "Create Posting" && $_POST['internnot'] == "intnot" && $_POST['jobtype'] == 0) {
        $query = "insert into job_posting values ({$_POST['jid']},'{$_POST['desc']}',{$_POST['salary']},{$_POST['phone']},{$_POST['open']},'$username','{$_POST['date']}'
                  ,{$_POST['duration']},{$_POST['cid']},{$_POST['jobtype']},'{$_POST['conttype']}')";
        $insert = true;
    } elseif ($_POST['buttontype'] == "Create Posting" && $_POST['jobtype'] == 1) {
        $query = "insert into job_posting values ({$_POST['jid']},'{$_POST['desc']}',{$_POST['salary']},{$_POST['phone']},{$_POST['open']},'$username','{$_POST['date']}'
                  ,{$_POST['duration']},{$_POST['cid']},{$_POST['jobtype']},'{$_POST['conttype']}'); insert into manager_job_posting values ({$_POST['jid']},'{$_POST['deptname']}',{$_POST['size']});";
        $insertdouble = true;
        $insert = true;
    } elseif ($_POST['buttontype'] == "Create Posting" && $_POST['internnot'] == "int") {
        $query = "insert into job_posting values ({$_POST['jid']},'{$_POST['desc']}',{$_POST['salary']},{$_POST['phone']},{$_POST['open']},'$username','{$_POST['date']}'
                  ,{$_POST['duration']},{$_POST['cid']},{$_POST['jobtype']},'{$_POST['conttype']}'); insert into internshipjobposting values ({$_POST['jid']},{$_POST['inmin']});";
        $insertdouble = true;
        $insert = true;
    }

    if ($insertdouble) {
        $result = mysqli_multi_query($conn, $query);
    } else
        $result = mysqli_query($conn, $query);

    if ($insert) {
        if ($result) {
            echo "<script>alert('Posting has been created successfully !');
                   </script>";
            header("Refresh:0");
        } else {
            echo "<script>alert('An error occurred, Either JID is taken or CID does not exist');
                   </script>";
            header("Refresh:0");
        }
    } else {

        //building all data from sql
        if (mysqli_num_rows($result) != 0) {
            while ($info = mysqli_fetch_array($result)) {
                if ($_POST['buttontype'] == "mypost") {
                    $string .= "<li style='list-style: none;'>JID " . $info['jid'] . ",  " . $info['description'] . " job for " . $info['name'] . " with openings for "
                        . $info['numOpenings'] . " persons<br>Opened on " . $info['openingdate'] . " and contract type: " . $info['contract_type'] . " </li><br>";
                }
            }
        } else
            $string .= "<br>No results found";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>HRR Control Page</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .form {
            background-color: #f6f6f6;
            padding: 1rem;
            border: 1px solid darkgray;
            border-radius: .25rem;
        }

        .form > input {
            margin-bottom: 8px;
            background: #fff;
            border: 1px solid #9c9c9c;
            border-radius: .20rem;
            height: 22px;

        }

        .form #button {
            background-color: white;
            border-radius: .25rem;
            height: 50px;
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

<div style="font-weight: bold;font-family: 'Rockwell Nova Light',serif;font-size: 25px;text-align: center;margin-top: 30px;margin-right: 5px">
    HRR Control Panel
</div>

<div class="parent" style="margin-top: 10px;flex-direction: column;align-items: center">
    <div style="display:flex;flex-direction: row">

        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <button name="buttontype" value="mypost">Display my<br> Postings</button>
            <span class="vertical"></span>
        </form>

        <button name="buttontype" value="newpost" onclick="showHide()">Create new <br>Posting</button>
    </div>

    <br><br>

    <form id="newForm" class="form" style="display: none" method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <div style="text-align: center;color: red">Please note that all fields are required<br><br></div>
        <label>JID: </label><input type="text" name="jid" style="margin-left: 57px"
                                   required
                                   oninvalid="this.setCustomValidity('JID Field is required')"
                                   oninput="this.setCustomValidity('')">

        <br>

        <label>Description: </label>&hairsp;&hairsp;<input type="text" name="desc"
                                                           required
                                                           oninvalid="this.setCustomValidity('Description Field is required')"
                                                           oninput="this.setCustomValidity('')">
        <br>

        <label>Salary: </label><input type="number" name="salary" style="margin-left: 37px"
                                      required
                                      oninvalid="this.setCustomValidity('Salary Field is required')"
                                      oninput="this.setCustomValidity('')">
        <br>

        <label>Phone: </label><input type="tel" style="margin-left: 36px"
                                     name="phone"
                                     required
                                     oninvalid="this.setCustomValidity('Phone Field is required')"
                                     oninput="this.setCustomValidity('')">
        <br>

        <label>Openings: </label><input type="number" name="open" style="margin-left: 14px"
                                        required
                                        oninvalid="this.setCustomValidity('Openings Field is required')"
                                        oninput="this.setCustomValidity('')">
        <br>

        <label>Open Date: </label><input type="date" name="date" style="margin-left: 5px;width: 165px"
                                         required
                                         oninvalid="this.setCustomValidity('Open Date Field is required')"
                                         oninput="this.setCustomValidity('')">
        <br>

        <label>Duration: </label><input type="number" name="duration" style="margin-left: 23px"
                                        required
                                        oninvalid="this.setCustomValidity('Duration Field is required')"
                                        oninput="this.setCustomValidity('')">
        <br>

        <label>CID: </label><input type="number" name="cid" style="margin-left: 55px"
                                   required
                                   oninvalid="this.setCustomValidity('CID Field is required')"
                                   oninput="this.setCustomValidity('')">
        <br>

        <fieldset onchange="disableman()" style="text-align: center;margin-bottom: 7px;padding-bottom: 4px">Job Type<br>
            <label>
                <input type="radio" name="jobtype" id="manager" value="1" required>
                Manager Job</label>

            <label>
                <input type="radio" name="jobtype" id="intern" value="0">
                Intern Job</label>
        </fieldset>

        <fieldset style="text-align: center;margin-bottom: 7px">Contract Type<br>
            <label>
                <input type="radio" name="conttype" id="ft" value="FT" required>
                Full Time</label>

            <label>
                <input type="radio" name="conttype" id="pt" value="PT">
                Part Time</label>
        </fieldset>

        <fieldset onchange="disablemindays()" style="text-align: center;margin-bottom: 7px">Internship Or Job<br>
            <label>
                <input type="radio" name="internnot" id="int" value="int" required>
                Internship</label>

            <label>
                <input type="radio" name="internnot" id="intnot" value="intnot">
                Non-Internship</label>
        </fieldset>


        <label>Dept Name: </label><input id="managerinput" type="text" name="deptname" style="width: 70px" disabled
                                         required>

        <label>Size: </label><input id="managerinput1" type="number" name="size" style="width: 40px" disabled
                                    required>

        <br>

        <label>Internship Min Days: </label><input id="inmin" type="number" name="inmin" style="width: 103px" disabled
                                                   required>
        <br>

        <div style="text-align: center;">
            <input id="button" name="buttontype" type="submit" value="Create Posting">
            <input style="width: 100px;margin-left: 15px" id="button" type="reset" onclick="clear()" value="Clear">
        </div>
        <script>
            function clear() {
                document.getElementById("newForm").reset();  //java script to reset a form
            }</script>
    </form>
</div>

<script>
    function showHide() {
        var x = document.getElementById("newForm");
        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
    }

    function disableman() {
        //get the value if checkbox is checked
        if (document.getElementById("manager").checked) {
            document.getElementById("pt").disabled = true;
            document.getElementById("pt").checked = false;

            document.getElementById("int").disabled = true;
            document.getElementById("int").checked = false;

            document.getElementById("managerinput").removeAttribute('disabled');
            document.getElementById("managerinput1").removeAttribute('disabled');
        } else if (document.getElementById("intern").checked) {
            document.getElementById("pt").disabled = false;
            document.getElementById("ft").checked = false;

            document.getElementById("int").disabled = false;
            document.getElementById("intnot").checked = false;

            document.getElementById("managerinput").setAttribute('disabled', 'true');
            document.getElementById("managerinput1").setAttribute('disabled', 'true');
        }
    }

    function disablemindays() {
        if (document.getElementById('int').checked) {
            document.getElementById("inmin").removeAttribute('disabled');
        } else {
            document.getElementById("inmin").setAttribute('disabled', 'true');
        }

    }
</script>

<label class="resultBox" style="margin-top: 10px;">
    <?php echo $string ?>
</label>

</body>
</html>