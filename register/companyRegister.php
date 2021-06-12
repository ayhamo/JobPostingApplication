<?php
include "../dbConnection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (!empty($_POST["name"])) {
        $query = "insert into company values ('{$_POST["cid"]}','{$_POST["name"]}','{$_POST["address"]}','{$_POST["phone"]}')";

        $result = mysqli_query($conn, $query);

        if ($result) {
            echo "<script>alert('You have created a new Company Account successfully');
            window.location.href = '../login.php';
                   </script>";

        } else {
            echo "<script>alert('An error occurred, CID you provided already taken.');
                   </script>";
//                echo '<br><center> Error ' . $query . "<br>" . mysqli_errno($conn) . '</center>';
        }

        mysqli_close($conn);

    }
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

        .textarea * {
            vertical-align: middle;
        }
    </style>
</head>
<body>
<div class="parent">
    <div class="main">
        <div style="text-align: center;"><span style="font-size: 144%;font-family: 'Rockwell Nova Light',serif ">New Registration <br>For Company</span>
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
                    header("Location: userRegister.php?type=user");
                } elseif ($_GET['type'] == "hrr") {
                    header("Location: hrrRegister.php?type=hrr");    //this is to change the page on click on the selector to change register type
                }

            }
            ?>
            <label>CID<span class="error"> *</span>: &emsp;&emsp;&hairsp;&hairsp;&hairsp;&hairsp;</label><input
                    type="number" name="cid"
                    required
                    oninvalid="this.setCustomValidity('Company ID Field is required')"
                    oninput="this.setCustomValidity('')">

            <br>

            <label>Name<span class="error"> *</span></label>: &ensp;&ensp;&hairsp;&hairsp;&hairsp;&hairsp;<input
                    type="text" name="name"
                    required
                    oninvalid="this.setCustomValidity('Company Name Field is required')"
                    oninput="this.setCustomValidity('')">
            <br>

            <label>Phone<span class="error"> *</span></label>: &ensp;&ensp;<input type="tel" name="phone"
                                                                                  required
                                                                                  oninvalid="this.setCustomValidity('Phone Number Field is required')"
                                                                                  oninput="this.setCustomValidity('')">
            <br>

            <label class="textarea">Address<span class="error"> *</span>: <textarea rows="2" name="address"> </textarea><br></label>
            <br>

            <div style="text-align: center;">
                <input id="button" type="submit" value="Create Company">
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
