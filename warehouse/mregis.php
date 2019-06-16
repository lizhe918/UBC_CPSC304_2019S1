<?php
    require_once "pdo_constructor.php";

    $firstName = "";
    $lastName = "";
    $branchID = "";
    $username = "";
    $innerPin = "";
    $cmfir = "";
    $SIN = "";
    $phoneN = "";
    $email = "";
    $address ="";
    $message = false;
    if (isset($_POST) & !empty($_POST)) {
        $firstName = $_POST['fName'];
        $lastName = $_POST['lName'];
        $branchID = $_POST['branchID'];
        $username = $_POST['username'];
        $innerPin =  $_POST['innerPin'];
        $cmfir = $_POST['confirm'];
        $SIN = $_POST['SIN'];
        $phoneN = $_POST['phoneNumber'];
        $email = $_POST['emailaddress'];
        $address = $_POST['address'];

        if ($innerPin=="" || $username=="" || $cmfir == "" || $firstName== ""  || $SIN=="" || $phoneN == ""|| $address =="" || $email == "") {
            $message = "Please Complete All Required fields";
        }else if ($innerPin != $cmfir){
            $message = "Two passwords do not match";
        }else {
            // should insert
            $success = 1;

            //check values
            if ($lastName == ""){
                $lastName = "NULL";
            }
            if ($branchID == ""){
                $branchID = "NULL";
            }
            

            //check uniqueness
            $sql = "select * from Manager where username = '$username'";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            if ($stmt->rowCount() > 0){
                  $message = "Username Already Exist, Please Select an Unique Username";
                  $success = 0;
            }
            $sql = "select * from Employee where SINNum = '$SIN'";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            if ($stmt->rowCount() > 0){
                $message = "Social Insurance Number Already Exist";
                $success = 0;
            }
            $sql = "select * from Manager where branchID = '$branchID'";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            if ($stmt->rowCount() > 0){
                $currM = $stmt->fetch(PDO::FETCH_ASSOC);
                $MID = $currM['employID'];
                $message = "The Current Branch Manager For this Branch is Employee: '$MID', Please First Unassign the Current Manager.";
                $success = 0;
            }
            $sql = "select * from Employee where phoneNum = '$phoneN'";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            if ($stmt->rowCount() > 0){
                $message = "Phone Number Already Exist";
                $success = 0;
            }
            if ($email != "NULL"){
                $sql = "select * from Empolyee where email = '$email'";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                if ($stmt->rowCount() > 0){
                    $message = "Email Already Exist";
                    $success = 0;
                }
            }
            

            // insert
            if ($success == 1){
                //$sql = "INSERT INTO Employee('lName','fName','SINNum','phoneNuM','email','address') VALUES ('$lastName', '$firstName', '$SIN' , '$phoneN',  '$email','$address');";
                $sql = "INSERT INTO Employee VALUES ('0','$lastName', '$firstName', '$SIN' , '$phoneN',  '$email','$address');";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();

                $sql = "SELECT * FROM Employee WHERE SINNum = '$SIN'";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                $currEmployee = $stmt->fetch(PDO::FETCH_ASSOC);
                $eID = $currEmployee['employID'];

                $sql = "INSERT INTO Manager VALUES ('$eID','$username','$innerPin','$branchID')";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                header("Location:dlogin.php");
                exit;
            }
        }
    }
  ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manager Registration</title>
    <link rel="stylesheet" href="./css/form.css">
    <link rel="stylesheet" href="./css/navbar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        form {
            width: 60%;
            background-color: rgb(230, 230, 230);
            margin-top: 6em;
            margin-bottom: 8em;
        }

        @media screen and (max-width: 1080px) {
            form {
                width: 80%;
            }
        }
    </style>
</head>
<body>
    <div class="navbar">
    <div class="items" id="thebar">
      <a href="./index.php#home" id="brandlabel">ZYXW STORAGE</a>
        <a href="./index.php#about">ABOUT</a>
        <a href="./index.php#contact">CONTACT</a>
        <a href="./plans.php">PLANS</a>
        <a  href="./elogin.php">EMPLOYEE</a>
        <a  href="./clogin.php">MY ACCOUNT</a>
      <a href="javascript:void(0);" class="icon" onclick="mobileExpand()">
        <i class="fa fa-bars"></i>
      </a>
    </div>
    </div>
    <div class="form-container">
    <form method="post">
        <div class="form-content">
        <h2 style="color: #002145;">CPSC304 Group 1 Project</h2>
        <h3 style="color: #002145;">Create New ZYXW Storage Emoplyee Manager Account:</h3>
        <p>First Name*:<br>
            <input class="medium" type="text" name="fName" required>
        </p>
        <p>Last Name:<br>
            <input class="medium" type="text" name="lName">
        </p>
        <p>Branch ID:<br>
            <input class="short" type="text" name="branchID">
        </p>
        <p>Username*:<br>
            <input class = "short" type="text" name="username" required>
        </p>
        <p>User Password*:<br>
            <input class="short" type="password" name="innerPin" required>
        </p>
        <p>Confirm Password*:<br>
            <input type="password" name="confirm" required>
        </p>
        <p>Social Insurance Number*:<br>
            <input class="medium" type="text" name="SIN" required>
        </p>
        <p>Phone Number*:<br>
            <input class="short" type="text" name="phoneNumber" required>
        </p>
        <p>Email*:<br>
            <input class="medium" type="email" name="emailaddress">
        </p>
        <p>Address (street address, city, province, country, postal code)*:<br>
            <input class="long" type="text" name="address" required>
        </p>
        <?php
            if ($message != false) {
                    echo "<p style='color: red; font-weight: bold;'>$message</p>";
                }
        ?>
        <div>
            <input class="button confirm" type="submit" name="signUp" value="Register">
        </div>
        </div>
        <div style="padding: 2em; padding-top:0;">
        <h4 style="margin-top:0;">OR</h4>
        <a href="dviewe.php">Back to Employee</a>
        <p></p>
        </div>
        </form>
    </div>
    <script>
        function mobileExpand() {
            var x = document.getElementById("thebar");
            if (x.className === "items") {
                x.className += " responsive";
            } else {
                x.className = "items";
            }
        }
    </script>
    </body>
</html>
