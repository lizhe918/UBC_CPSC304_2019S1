<?php

    require_once "pdo_constructor.php";

    if (isset($_POST['cancel'])) {
        header("Location: elogin.php");
    }

    $name = "";
    $pswd = "";
    $message = false;

    if (!isset($_COOKIE['zyxwmanager']) and !isset($_COOKIE['zyxwmpswd'])) {
      if (isset($_POST['who']) and isset($_POST['password'])) {
        $name = $_POST['who'];
        $pswd =  $_POST['password'];

        if ($name == "" || $pswd == "") {
            $message = "Username and password are required";
        } else {
          $sql = "SELECT password FROM Manager WHERE username = '$name'";
          $stmt = $pdo->prepare($sql);
          $stmt->execute();
          $storedpswd = $stmt->fetch();
          if ($storedpswd['password'] == $pswd) {
            setcookie("zyxwmanager", $name, time() + 3600);
            setcookie("zyxwmpswd", $pswd, time() + 3600);
            header("Location: magrmt.php");
          } else {
            $message = "Incorrect username or password";
          }
        }
      }
    } else {
      $name = $_COOKIE['zyxwmanager'];
      $pswd = $_COOKIE['zyxwmpswd'];
      $sql = "SELECT password FROM Manager WHERE username = '$name'";
      $stmt = $pdo->prepare($sql);
      $stmt->execute();
      $storedpswd = $stmt->fetch();
      if ($storedpswd['password'] == $pswd) {
        header("Location: magrmt.php");
      } else {
        $message = "Incorrect username or password";
      }
    }
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manager Login</title>
    <link rel="stylesheet" href="./css/form.css">
    <link rel="stylesheet" href="./css/navbar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  </head>
  <body>
    <div class="navbar">
    <div class="items" id="thebar">
      <a href="./index.php#home" id="brandlabel">ZYXW STORAGE</a>
        <a href="./index.php#about">ABOUT</a>
        <a href="./index.php#contact">CONTACT</a>
        <a href="./plans.php">PLANS</a>
        <a  href="./elogin.php">EMPLOYEE</a>
        
      <a href="javascript:void(0);" class="icon" onclick="mobileExpand()">
        <i class="fa fa-bars"></i>
      </a>
    </div>
    </div>
    <div class="form-container">
    <form method="post" style="width: 25em; background-color: white;">
      <div class="form-content">
        <h2 style="color: #002145;">CPSC304 Group 1 Project</h2>
        <h3 style="color: #002145;">Login to your management:</h3>
        <p>Username:<br>
          <input class="long" type="text" name="who">
        </p>
        <p>Password:<br>
          <input type="password" name="password"  style="width: 100%">
        </p>
        <?php
          if ($message != false) {
            echo "<p style='color: red; font-weight: bold;'>$message</p>";
          }
        ?>
        <div>
          <input class="button confirm" type="submit" name="confirm" value="Sign In">
          <input class="button cancel" type="submit" name="cancel" value="Cancel">
        </div>
      </div>
      <div style="padding: 2em; padding-top:0;">
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
