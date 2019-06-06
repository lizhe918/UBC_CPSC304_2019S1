<?php
require_once "pdo_constructor.php";
?>




<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ZYXW Storage</title>
    <link rel="stylesheet" href="./css/navbar.css">
    <link rel="stylesheet" href="./css/welcome.css">
    <link rel="stylesheet" href="./css/input_button.css">
    <link rel="stylesheet" href="./css/paragraph.css">
    <link rel="stylesheet" href="./css/table.css">
    <link rel="stylesheet" href="./css/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  </head>
  <body>
    <section class="navbar">
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
    </section>

    <section class="welcome" id="home">
      <div class="background" style="background-image: url('https://images.pexels.com/photos/544965/pexels-photo-544965.jpeg?cs=srgb&dl=adult-artisan-blueprint-544965.jpg&fm=jpg');"></div>
      <div class="greeting">
        <span class="title">Welcome</span>
        <p></p>
        <span class="subtitle">Greetings to all our employees</span>
        <p></p>
        <a class="linkbutton" href="./dlogin.php">Company Director</a>
        <a class="linkbutton" href="./mlogin.php">Branch Manager</a>
        <a class="linkbutton" href="./llogin.php">Storage Worker</a>
      </div>
    </section>

    <section class="tableblock" style="background-color: #002145;">
      <h1 style="color: white;">Our Directors</h1>
      <div class="thetable">
        <table class="entities" style="width:100%">
          <tr>
            <th>Name</th> 
            <th>Phone#</th>
            <th>Email</th>
          </tr>
          <?php
          $sql = "SELECT E.fName, E.lName, E.phoneNum, E.email FROM Director D INNER JOIN Employee E
                  ON D.employID = E.employID";
          $stmt = $pdo->prepare($sql);
          $stmt->execute();
          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
          ?>
          <tr>
            <td><?php echo $row["fName"]." ".$row["lName"];?></td>
            <td> <?php echo $row["phoneNum"];?></td>
            <td> <?php echo $row["email"];?></td>
          </tr><?php
          }
          ?>
        </table>
      </div>        
    </section>

    <section class="tableblock" style="background-color: white;">
      <h1>Our Managers</h1>
      <div class="thetable">
        <table class="entities" style="width:100%">
          <tr>
            <th>Branch Address</th>
            <th>Person</th> 
            <th>Phone#</th>
            <th>Email</th>
          </tr>
          <?php
          $sql = "SELECT B.address, E.fName, E.lName, E.phoneNum, E.email FROM Manager M INNER JOIN Employee E
                  ON M.employID = E.employID 
                  INNER JOIN Branch B
                  ON M.branchID = B.branchID";
          $stmt = $pdo->prepare($sql);
          $stmt->execute();
          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
          ?>
          <tr>
            <td><?php echo $row["address"];?></td>
            <td><?php echo $row["fName"]." ".$row["lName"];?></td>
            <td> <?php echo $row["phoneNum"];?></td>
            <td> <?php echo $row["email"];?></td>
          </tr><?php
          }
          ?>
        </table>
      </div>        
    </section>

    <section class="footer-container" >
        <div class="footer">
          <a  href="https://github.com/lizhe918/UBC_CPSC304_2019S1">
            <img src = "https://image.flaticon.com/icons/svg/25/25231.svg" >
          </a>
          <a  href="https://www.ubc.ca/">
            <img src = "https://bcchdigital.ca/wp-content/uploads/2018/11/ubc-emblem-black.png" >
          </a>
          <a  href="https://www.cs.ubc.ca/">
            <img src = "https://avatars0.githubusercontent.com/u/22601447?s=200&v=4" >
          </a>
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
