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

    if (isset($_POST['who']) and isset($_POST['password']) and isset($_POST['fName']) and isset($_POST['lName']) and isset($_POST['IDType']) and isset($_POST['IDNumber']) and isset($_POST['phoneNumber']) and isset($_POST['phoneNumber']) and isset($_POST['address']) and isset($_POST['emailaddress'])) {
        $name = $_POST['who'];
        $pswd =  $_POST['password'];
        $cmfir = $_POST['confirm'];
        $firstName = $_POST['fName'];
        $lastName = $_POST['lName'];
        $idType = $_POST['IDType'];
        $idNum = $_POST['lDNumber'];
        $phoneN = $_POST['phoneNumber'];
        $address = $_POST['address'];
        $email = $_POST['emailaddress'];
    }
    if ($name == "" || $pswd == ""|| $cmfir =="" || $firstName="" || $lastName =="" || $idType=="" || $idNum == "" || $phoneN == ""|| $address ==""|| $email == "") {
        $message = "Please Complete All Required fields";
    }else if ($pswd != $cmfir){
        $message = "Those passwords didn't match. Try Again";
    }else {
        //check values
        if ($lastName == ""){
            $lastName = "NULL";
        }
        if ($email == ""){
            $email = "NULL";
        }
        if($idType == "StudentID"){
            $idNum = STUD . '$idNum';
        }else if ($idType == "Passport"){
            $idNum = PSPT . '$idNum';
        }else if ($idType == "Dlicence"){
            $idNum = DLCE . '$idNum';
        }
        
        //check uniqueness

        
        // insert
        $sql = "insert into Customer values ('$name', '$pswd', '$idNum', '$lastName', '$firstName', '$phoneN', '$address', '$email');";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }
  ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Customer Sign</title>
    <link rel="stylesheet" href="./css/form.css">
    <link rel="stylesheet" href="./css/navbar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <div class="navbar">
    <div class="items" id="thebar">
      <a href="./index.html#home" id="brandlabel">ZYXW STORAGE</a>
        <a href="./index.html#about">ABOUT</a>
        <a href="./index.html#contact">CONTACT</a>
        <a href="./plans.php">PLANS</a>
        <a  href="./elogin.php">EMPLOYEE</a> 
        <a  href="./clogin.php">MY ACCOUNT</a> 
      <a href="javascript:void(0);" class="icon" onclick="mobileExpand()">
        <i class="fa fa-bars"></i>
      </a>
    </div>
    </div>
    <div class="form-container">
    <form method="post" style="width: 23em; background-color: white;">
        <div class="form-content">
        <h2 style="color: #002145;">CPSC304 Group 1 Project</h2>
        <h3 style="color: #002145;">Create your ZYXW Storage Account:</h3>
        <p>Username*:<br>
            <input class="long" type="text" name="who" required>
        </p>
        <p>Password*:<br>
            <input type="password" name="password" style="width: 100%" required>
        </p>
        <p>Comfirm your Password*:<br>
            <input class="long" type="text" name="confirm" required>
        </p>
        <p>First Name*:<br>
            <input class="long" type="text" name="fName" required>
        </p>
        <p>Last Name:<br>
            <input class="long" type="text" name="lName">
        </p>
        <p>Please Select One of the Following Identification*: <br>
            <select class="long" style="height:4em" name="IDType" required>
                <option value="StudentID">Student ID</input>
                <option value="Passport">Passport</input>
                <option value="Dlicence">Driver License</input>
            </select>
        </p>
        <p>ID Number (ie. Passport ID)*:<br>
            <input class="long" type="text" name="IDNumber" required>
        </p>
        <p>Phone Number*:<br>
            <input class="long" type="number" name="phoneNumber" required>
        </p>
        <p>Address (street address, city, province, country, postal code)*:<br>
            <input class="long" type="text" name="address" required>
        </p>
        <p>Email:<br>
            <input class="long" type="email" name="emailaddress">
        </p>
        <?php
            if ($message != false) {
                    echo "<p style='color: red; font-weight: bold;'>$message</p>";
                }
        ?>
        <div>
            <input class="button confirm" type="submit" name="signUp" value="Sign Up">
            <input class="button cancel" type="submit" name="cancel" value="Cancel">
        </div>
        </div>
        <div style="padding: 2em; padding-top:0;">
        <h4 style="margin-top:0;">OR</h4>
        <a href="">Log in with existing account?</a>
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
