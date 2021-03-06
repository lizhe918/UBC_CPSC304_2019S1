<?php 
require_once "pdo_constructor.php";
$isset = isset($_COOKIE['zyxwuser']) && isset($_COOKIE['zyxwpswd']);
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
      <a href="./elogin.php">EMPLOYEE</a>
      <a href="./clogin.php">MY ACCOUNT</a>
      <?php
      if ($isset) {
        echo '<a href="./logout.php" id="logout">LOG OUT</a>';
      } ?>
      <a href="javascript:void(0);" class="icon" onclick="mobileExpand()">
        <i class="fa fa-bars"></i>
      </a>
    </div>
  </section>

  <section class="welcome" id="home">
    <div class="background"></div>
    <div class="greeting">
      <span class="title">ZYXW Storage</span>
      <p></p>
      <span class="subtitle">UBC CPSC304 Group 1 Project</span>
      <p></p>
      <a class="linkbutton" href="./plans.php">View Plans</a>
      <a class="linkbutton" href="./clogin.php">Go to My Storage</a>
    </div>
  </section>

  <section class="article" id="about">
    <h1>Project Introduction</h1>
    <div class="paragraph">
      <p>
        The domain that we’re modelling is inventory tracking. Our database will focus on the data stored about the items being stored in a storage facility.
        We will be modelling about the members of the storage facility. The organization that a database provides will keep a record of a customer’s personal information, the items a customer is currently storing, the dates they are storing their items, the price they paid to store the items, and their payment method, while minimizing redundancies. The online web application will allow a customer to get estimated quotes and real-time storage availability without having to come into the facility in person. Employees would also not need to manually check for availability. Additionally, a customer can request to see a list of all the items they are currently storing, further helping in organization.
        <p><br></p>
        There can be multiple branches of the same company. The database provides functionality for storage facility employees and customers. Employees will be granted access to the database. They will have the ability to add and edit customer information, and process storage transactions (storing or retrieving items) with different rate tiers, at their respective branches. However, they will have access to the customers’ personal information and their storage transactions across all branches. The database keeps track of the amount of space a storage facility has, as well as where customer items are being stored. For customers, they are able to store and retrieve items at the storage facility, as well as being able to go online to check and reserve storage space at a chosen storage facility (and receiving an estimated quote).
        <p><br></p>
        The project will be done using the MySQL database system, with PHP to connect and manipulate the database. We will be creating a web application, using HTML, CSS and Javascript, to allow customers to make online reservations for storage space and to get an estimated quote.
      </p>
    </div>
  </section>

  <section class="tableblock" style="background-color: white;" id="contact">
    <h1>Group Members</h1>
    <div class="thetable">
      <table class="entities" style="width:100%">
        <tr>
          <th>Name</th>
          <th>Email Address</th>
        </tr>
        <tr>
          <td>Zhe Li</td>
          <td>lizhe1313@outlook.com</td>
        </tr>
        <tr>
          <td>Yi Xuan Qi</td>
          <td>yixuan99316@gmail.com</td>
        </tr>
        <tr>
          <td>Yuxin Tian</td>
          <td>tian19yuxin@163.com</td>
        </tr>
        <tr>
          <td>Justin Wong</td>
          <td>justinc.s.wong@gmail.com</td>
        </tr>
      </table>
    </div>
  </section>

  <section class=map data-position=119>
    <iframe width=100% height=400 frameborder=0 style=border:0 src="https://www.google.com/maps/embed/v1/place?key=AIzaSyC95r60uYUnB7WMJJu308Sz9PM1vo2NR1k&q=ICICS" allowfullscreen>
    </iframe>
  </section>

  <section class="footer-container">
    <div class="footer">
      <a href="https://github.com/lizhe918/UBC_CPSC304_2019S1">
        <img src="https://image.flaticon.com/icons/svg/25/25231.svg">
      </a>
      <a href="https://www.ubc.ca/">
        <img src="https://bcchdigital.ca/wp-content/uploads/2018/11/ubc-emblem-black.png">
      </a>
      <a href="https://www.cs.ubc.ca/">
        <img src="https://avatars0.githubusercontent.com/u/22601447?s=200&v=4">
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
