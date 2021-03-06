<?php
    require_once "pdo_constructor.php";


    $name = "";
    $pswd = "";
    $cmfir = "";
    $firstName = "";
    $lastName = "";
    $idType = "";
    $idNum = "";
    $phoneN = "";
    $address ="";
    $email = "";
    $message = false;
    if (isset($_POST) & !empty($_POST)) {

        if (isset($_POST['who']) and isset($_POST['password']) and isset($_POST['fName']) and isset($_POST['lName']) and isset($_POST['IDType']) and isset($_POST['IDNumber']) and isset($_POST['phoneNumber']) and isset($_POST['phoneNumber']) and    isset($_POST['address']) and isset($_POST['emailaddress'])) {
            $name = $_POST['who'];
            $pswd =  $_POST['password'];
            $cmfir = $_POST['confirm'];
            $firstName = $_POST['fName'];
            $lastName = $_POST['lName'];
            $idType = $_POST['IDType'];
            $idNum = $_POST['IDNumber'];
            $phoneN = $_POST['phoneNumber'];
            $address = $_POST['address'];
            $email = $_POST['emailaddress'];
        }

        if ($name == "" || $pswd == ""|| $cmfir =="" || $firstName==""  || $idType=="" || $idNum     == "" || $phoneN == ""|| $address =="") {
            $message = "Please Complete All Required fields";
        }else if ($pswd != $cmfir){
            $message = "Two passwords do not match";
        }else {
            // should insert
            $success = 1;

            //check values

            if ($lastName == ""){
                $lastName = "NULL";
            }
            if ($email == ""){
                $email = "NULL";
            }
            if($idType == "StudentID"){
                $idNum = 'STUD' . $idNum;
            }else if ($idType == "Passport"){
                $idNum = 'PSPT' . $idNum;
            }else if ($idType == "Dlicence"){
                $idNum = 'DLCE' . $idNum;
            }

            //check uniqueness
            $sql = "select * from Customer where username = '$name'";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            if ($stmt->rowCount() > 0){
                  $message = "Username Already Exist";
                  $success = 0;
            }

            $sql = "select * from Customer where phoneNum = '$phoneN'";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            if ($stmt->rowCount() > 0){
                $message = "Phone Number Already Exist";
                $success = 0;
            }
            if ($email != "NULL"){
                $sql = "select * from Customer where email = '$email'";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                if ($stmt->rowCount() > 0){
                    $message = "Email Already Exist";
                    $success = 0;
                }
            }

            // insert
            if ($success == 1){
            $sql = "insert into Customer values ('$name', '$pswd', '$idNum', '$lastName', '$firstName', '$phoneN', '$address', '$email');";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            header("Location:clogin.php");
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
    <title>Customer Sign Up</title>
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
        <h3 style="color: #002145;">Create your ZYXW Storage Account:</h3>
        <p>Username*:<br>
            <input class="short" type="text" name="who" required>
        </p>
        <p>Password*:<br>
            <input type="password" name="password" required>
        </p>
        <p>Comfirm your Password*:<br>
            <input class="short" type="password" name="confirm" required>
        </p>
        <p>First Name*:<br>
            <input class="medium" type="text" name="fName" required>
        </p>
        <p>Last Name:<br>
            <input class="medium" type="text" name="lName">
        </p>
        <p>Phone Number*:<br>
            <input class="short" type="text" name="phoneNumber" required>
        </p>
        <p>Please Select One of the Following Identification*: <br>
            <select class="short" style="height:4em" name="IDType" required>
                <option value="StudentID">Student ID</input>
                <option value="Passport">Passport</input>
                <option value="Dlicence">Driver License</input>
            </select>
        </p>
        <p>ID Number (ie. Passport ID)*:<br>
            <input class="medium" type="text" name="IDNumber" required>
        </p>
        <p>Email:<br>
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
            <input class="button confirm" type="submit" name="signUp" value="Sign Up">
        </div>
        </div>
        <div style="padding: 2em; padding-top:0;">
        <h4 style="margin-top:0;">OR</h4>
        <a href="clogin.php">Log in with existing account</a>
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
