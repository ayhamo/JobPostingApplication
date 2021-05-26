<?php
include "../dbConnection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["euname"])) {  //and if to see if it's null for endusername or not.
        $query = "insert into hrr values ('{$_POST["username"]}','{$_POST["password"]}','{$_POST["email"]}','{$_POST["fname"]}','{$_POST["lname"]}',null)";
    } else
        $query = "insert into hrr values ('{$_POST["username"]}','{$_POST["password"]}','{$_POST["email"]}','{$_POST["fname"]}','{$_POST["lname"]}','{$_POST["euname"]}')";

    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "<script>alert('You have created a new Account successfully');
        window.location.href = '../login.php';
                   </script>";

    } else {
        echo "<script>alert('An error occurred, HRR Username already taken OR your End-User name is incorrect');
                   </script>";
//                echo '<br><center> Error ' . $query . "<br>" . mysqli_errno($conn) . '</center>';
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
        <div style="text-align: center;"><span style="font-size: 144%;font-family: 'Rockwell Nova Light',serif ">New Registration <br>For HRR</span>
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
                if ($_GET['type'] == "user") {
                    header("Location: userRegister.php?type=user");    //this is to change the page on click on the selector to change register type
                } elseif ($_GET['type'] == "company") {
                    header("Location: companyRegister.php?type=company");
                }

            }
            ?>
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

            <label>Email<span class="error"> *</span></label>:&emsp;&emsp;&ensp;&ensp;<input type="email" name="email"
                                                                                             required
                                                                                             oninvalid="this.setCustomValidity('Email Field is required')"
                                                                                             oninput="this.setCustomValidity('')">
            <br>

            <label>Username<span class="error"> *</span></label>: &hairsp;&ensp;<input type="text" name="username"
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

            <label>End-User name</label>: <input type="text" name="euname" size="16">

            <br><br>

            <div style="text-align: center;">
                <input id="button" type="submit" value="Create Account">
                <input style="width: 100px;margin-left: 15px" id="button" type="reset" onclick="clear()" value="Clear">
            </div>
            <script>
                function clear() {
                    document.getElementById("form").reset();
                }</script>
        </form>

        <div style="margin-top: 15px;text-align: center;"><a
                    style="font-family: Calibri Light,serif;  font-size: 19px;  color: #333333"
                    href="../login.php">RETURN TO LOGIN</a></div>
    </div>
</div>

</body>
</html>
