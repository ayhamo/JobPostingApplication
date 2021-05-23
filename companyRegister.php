<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register</title>
    <style>
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
            background-color: #eeeeee;
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
            if(isset($_GET['type'])){
                if($_GET['type']=="user"){
                    header("Location: userRegister.php");
                }elseif($_GET['type']=="hrr"){
                    header("Location: hrrRegister.php");
                }

            }
            ?>
            <label>CID<span class="error"> *</span>: &emsp;&emsp;&hairsp;&hairsp;&hairsp;&hairsp;</label><input type="text" name="cid"
                                                                          required
                                                                          oninvalid="this.setCustomValidity('Company ID Field is required')"
                                                                          oninput="this.setCustomValidity('')">

            <br>

            <label>Name<span class="error"> *</span></label>: &ensp;&ensp;&hairsp;&hairsp;&hairsp;&hairsp;<input type="text" name="name"
                                                                                       required
                                                                                       oninvalid="this.setCustomValidity('Company Name Field is required')"
                                                                                       oninput="this.setCustomValidity('')">
            <br>

            <label>Phone<span class="error"> *</span></label>: &ensp;&ensp;<input type="text" name="phone"
                                                                                required
                                                                                oninvalid="this.setCustomValidity('Phone Number Field is required')"
                                                                                oninput="this.setCustomValidity('')">
            <br>

            <label class="textarea">Address<span class="error"> *</span>: <textarea rows="2" name="address"> </textarea><br></label>
            <br>

            <div style="text-align: center;">
                <input id="button" type="submit" value="Create Contact">
                <input style="width: 100px;margin-left: 15px" id="button" type="reset" onclick="clear()" value="Clear">
            </div>
            <script>
                function clear() {
                    document.getElementById("form").reset();
                }</script>
        </form>
    </div>
</div>

</body>
</html>
