<?php

    require_once "pdo_constructor.php";
    $isset = isset($_COOKIE['zyxwuser']);
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Plans</title>
    <link rel="stylesheet" href="./css/table.css">
    <link rel="stylesheet" href="./css/navbar.css">
    <link rel="stylesheet" type="text/css" href="./css/logout.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  </head>
  <body>
    <section class="navbar">
    <div class="items" id="thebar">
      <a href="./index.php#home" id="brandlabel">ZYXW STORAGE</a>
        <a href="./index.php#about">ABOUT</a>
        <a href="./index.php#contact">CONTACT</a>
        <a href="./plans.php">PLANS</a>
        <a  href="./elogin.php">EMPLOYEE</a>
        <a  href="./clogin.php">MY ACCOUNT</a>
        <?php
        if ($isset) {
          echo '<a href="./logout.php" id="logout">LOG OUT</a>';
        } ?>
      <a href="javascript:void(0);" class="icon" onclick="mobileExpand()">
        <i class="fa fa-bars"></i>
      </a>
    </div>
    </section>
    <section class="tableblock" style="background-color:white;">
      <h1>Our Plans</h1>
      <div class="thetable">
        <table class="entities" style="width:100%">
          <tr>
            <th>Abbreviation</th>
            <th>Type</th>
              <th>Rate (CAD/Day/m<sup>3</sup>)</th>
          </tr>
      <?php
      $sql="SELECT * FROM ItemType";
      $stmt = $pdo->prepare($sql);
      $stmt->execute();
      while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
        echo "<tr><td>";
        echo($row['typeName']);
        echo ("</td><td>");
        echo($row['comment']);
        echo ("</td><td>");
        echo('$' . $row['rate']);
        echo ("</td></tr>");
      }
      ?>
        </table>
        <p style="text-align:left; color: red;">NOTE:<br> All charges are non-refundable. <br> $3 is required to make a reservation.</p>
      </div>
      
    </section>
    
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
