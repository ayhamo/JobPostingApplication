<?php
include "../dbConnection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $query = "insert into end_user values ('{$_POST["username"]}','{$_POST["password"]}','{$_POST["fname"]}','{$_POST["lname"]}','{$_POST["servicestat"]}')";

    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "<script>alert('You have created a new Account successfully');
                   </script>";

    } else {
        echo "<script>alert('An error occurred, Username already taken.') </script>";
//                echo '<br><center> Error ' . mysqli_errno($conn) . '</center>';
    }

    mysqli_close($conn);

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register</title>
    <style>
        body {
            background-color: #e5e5e5;
        }

        .error {
            color: #FF0000;
        }

        .parent {
            font-family: sans-serif;
            display: flex;
            justify-content: center;
        }

        .main {
            margin-top: 70px;
            font-size: 120%;
            font-weight: bold;
        }

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
        <div style="text-align: center;"><span style="font-size: 144%;font-family: 'Rockwell Nova Light',serif ">New Registration <br>For End-User</span>
            <br><br>
            <form action="userRegister.php" method="get">
                <select name="type" style="font-size: 18px" onchange="this.form.submit()">
                    <option value="none" selected disabled hidden>
                        Select One
                    </option>
                    <option value="user">End-User</option>
                    <option value="hrr">HRR</option>
                    <option value="company">Company</option>
                </select>
            </form>
        </div>
        <br>

        <form id="form" class="form" method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
            <?php
            if (isset($_GET['type'])) {
                if ($_GET['type'] == "hrr") {
                    header("Location: hrrRegister.php?type=hrr");
                } elseif ($_GET['type'] == "company") {
                    header("Location: companyRegister.php?type=company");   //this is to change the page on click on the selector to change register type
                }

            } ?>
            <label>First Name<span class="error"> *</span>:&ensp;</label><input type="text" name="fname"
                                                                                required
                                                                                oninvalid="this.setCustomValidity('First Name Field is required')"
                                                                                oninput="this.setCustomValidity('')">

            <br>

            <label>Last Name<span class="error"> *</span></label>:&hairsp;&ensp;<input type="text" name="lname"
                                                                                       required
                                                                                       oninvalid="this.setCustomValidity('Last Name Field is required')"
                                                                                       oninput="this.setCustomValidity('')">
            <br>

            <label>Username<span class="error"> *</span></label>: &ensp;&hairsp;<input type="text" name="username"
                                                                                       required
                                                                                       oninvalid="this.setCustomValidity('Username Field is required')"
                                                                                       oninput="this.setCustomValidity('')">
            <br>

            <label>Password<span class="error"> *</span></label>: &hairsp;&hairsp;&ensp;<input type="password"
                                                                                               name="password"
                                                                                               required
                                                                                               oninvalid="this.setCustomValidity('Password Field is required')"
                                                                                               oninput="this.setCustomValidity('')">
            <br>

            <label>Military Service Stat</label>:
            <select style="font-size: 15px" name="servicestat" required
                    oninvalid="this.setCustomValidity('Service stat Field is required')"
                    oninput="this.setCustomValidity('')">>
                <option value="" selected disabled hidden>
                    Select One
                </option>
                <option value="c">Completed</option>
                <option value="d">Delayed</option>
                <option value="e">Exempt</option>
            </select>

            <br><br>

            <div style="text-align: center;">
                <input id="button" type="submit" value="Create Account">
                <input style="width: 100px;margin-left: 15px" id="button" type="reset" onclick="clear()" value="Clear">
            </div>
            <script>
                function clear() {
                    document.getElementById("form").reset();  //java script to reset a form
                }</script>
        </form>

        <div style="text-align: center;"><a
                    style="margin-top: 10px;font-family: Calibri Light,serif;  font-size: 19px;  color: #333333"
                    href="../login.php">RETURN TO LOGIN</a></div>
    </div>
</div>

</body>
</html>
