<?php
include "dbConnection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if ($_POST['logtype'] == 'e'){     //change query depending on selector answer
        $query = "insert into end_user values ('{$_POST["username"]}','{$_POST["password"]}','{$_POST["fname"]}','{$_POST["lname"]}','{$_POST["servicestat"]}')";
    } elseif ($_POST['logtype'] == 'h'){

    }elseif ($_POST['logtype'] == 'c'){

    }

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
<html>
<head>
    <title>Login</title>
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
            margin-top: 150px;
            font-size: 120%;
            font-weight: bold;
        }

        .input {
            font-family: Oswald-Medium, serif;
            font-size: 19px;
            color: #43383e;
            height: 50px;
            border-radius: 31px;
            padding: 0 20px 0 30px;
            outline: 0
        }

        .login {
            font-family: serif;
            font-size: 16px;
            color: #ffffff;
            min-width: 160px;
            height: 55px;
            background-color: #333333;
            border-radius: 31px;
        }
    </style>
</head>
<body>
<div class="parent">
    <div class="main">
        <div style="text-align: center;"><span
                    style="font-size: 160%;font-family: 'Rockwell Nova Light',serif ">Login</span>
            <br><br>

            <form id="form" class="form" method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                <input class="input" type="text" name="username"
                       placeholder="Username / CID"
                       required
                       oninvalid="this.setCustomValidity('Username Field is required')"
                       oninput="this.setCustomValidity('')">
                <br><br>

                <input class="input" type="Password" name="password"
                       placeholder="Password / Company Phone"
                       required
                       oninvalid="this.setCustomValidity('Password Field is required')"
                       oninput="this.setCustomValidity('')">
                <br><br>

                <select style="height: 35px;;font-size: 22px" name="logtype" required              <!-- this selector is to specify the account type to differencing company-->
                        oninvalid="this.setCustomValidity('Select which account type you wish to login')"<!-- from enduser-hrr-end user, and to make query for us easier-->
                        oninput="this.setCustomValidity('')">>
                    <option value="" selected disabled hidden>
                        Select One
                    </option>
                    <option value="e">End-User Account</option>
                    <option value="h">HRR Account</option>
                    <option value="c">Company Account</option>
                </select>

                <br><br>

                <input class="login" id="button" type="submit" value="LOGIN">

            </form>

            <div style="padding-top: 80px;font-family: Oswald-Regular,serif; font-size: 16px;
                     color: #999999;line-height: 1.4;">Don’t have an account?
            </div>

            <a style="font-family: Calibri Light,serif;  font-size: 16px;  color: #333333;line-height: 1.2;"
               href="register/userRegister.php">
                SIGN UP NOW
            </a>

        </div>
    </div>
</body>
</html>
