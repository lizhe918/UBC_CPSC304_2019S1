<?php

    require_once "pdo_constructor.php";


    if (isset($_POST['cancel'])) {
        header("Location: index.html");
    }

    if (isset($_POST) & !empty($_POST)) {
        header("Location:payRedirect.php");
        exit;
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
      <a href="./index.html#home" id="brandlabel">ZYXW STORAGE</a>
        <a href="./index.html#about">ABOUT</a>
        <a href="./index.html#contact">CONTACT</a>
        <a href="./plans.php">PLANS</a>
        <a  href="./elogin.php">EMPLOYEE</a>
        
      <a href="javascript:void(0);" class="icon" onclick="mobileExpand()">
        <i class="fa fa-bars"></i>
      </a>
    </div>
    </div>
    <div class="form-container">
    <form method="post" "background-color: white;">
      <div class="form-content">
        <h3 style="color: #002145;">Pay with Your Credit Card: </h3>
        <img src = "images/card.png" height='25em' >
        <p>Card Number*:<br>
        <input class="medium" type="text" name="cardNum">
        </p>
        <p>MM*:<br>
          <input class='short' type="text" name="Month">
        </p>
        <p>YY*:<br>
          <input class='short' type="text" name="year">
        </p>
        <p>CVV/CVC*:<br>
          <input class='short' type="text" name="cvv">
        </p>
        <p>First Name*:<br>
          <input class='medium' type="text" name="FName">
        </p>
        <p>Last Name*:<br>
          <input class='medium' type="text" name="LName">
        </p>

        <div>
          <input class="button confirm" type="submit" name="submit" value="Submit">
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
