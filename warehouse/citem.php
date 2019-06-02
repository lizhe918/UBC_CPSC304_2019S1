<?php
 require_once "pdo_constructor.php";
 $username = $_COOKIE['zyxwuser'];
 $sql = "SELECT * FROM Customer WHERE username = '$username'";
 $stmt = $pdo->prepare($sql);
 $stmt->execute();
 $user = $stmt->fetch(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>CSS Template</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="./css/usermain.css">
	<link rel="stylesheet" type="text/css" href="./css/footer.css">
	<link rel="stylesheet" type="text/css" href="./css/profile.css">
	<link rel="stylesheet" type="text/css" href="./css/table.css">
	<link rel="stylesheet" type="text/css" href="./css/navbar.css">
	<link rel="stylesheet" type="text/css" href="./css/input_button.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<body>
	<section class="navbar">
		<div class="items" id="mainbar">
			<a href="./index.html#home" id="brandlabel">ZYXW STORAGE</a>
			<a href="./index.html#about">ABOUT</a>
			<a href="./index.html#contact">CONTACT</a>
			<a href="./plans.php">PLANS</a>
			<a  href="./elogin.html">EMPLOYEE</a>
			<a  href="./clogin.php">MY ACCOUNT</a>
			<a href="javascript:void(0);" class="icon" onclick="mobileExpandMain()">
				<i class="fa fa-bars"></i>
			</a>
		</div>
	</section>
	<div class="row">
		<div class="column profile">
			<h1>Welcome!</h1>
			<div class="username">
				<h2>
          <?php
            echo($user['fName'] . " " . $user['lName']);
          ?>
        </h2>
				<p>
          <?php
            echo($_COOKIE['zyxwuser']);
          ?>
        </p>
			</div>
			<div class="info">
				<p><img src="https://img.icons8.com/metro/420/phone.png">

          <?php
            echo($user['phoneNum']);
          ?>


				</p>
				<p><img src="https://cdn4.iconfinder.com/data/icons/maps-and-navigation-solid-icons-vol-1/72/19-512.png">
          <?php
            echo($user['address']);
          ?>

      </p>
				<p><img src="https://cdn3.iconfinder.com/data/icons/business-office-1-2/256/Identity_Document-512.png">
          <?php
            echo($user['IDNum']);
          ?>
				</p>
				<p><img src="https://cdn1.iconfinder.com/data/icons/education-set-01/512/email-open-512.png">
          <?php
            echo($user['email']);
          ?>
				</p>
				<a class="linkbutton" href="">Edit Profile</a>
			</div>
		</div>
		<div class="column function">
			<div class="navbar" style="position: relative;">
				<div class="items" id="funcbar">
					<a href="">Saved Items</a>
					<a href="">Reservations</a>
					<a href="">Payment Method</a>
					<a href="">Make Reservation</a>
					<a href="javascript:void(0);" class="icon" onclick="mobileExpandFunc()">
						<i class="fa fa-bars"></i>
					</a>
				</div>
			</div>
			<div class="tableblock" style="background-color: white;">
				<p><br></p>
				<div class="thetable">
					<table class="entities" style="width:100%">
						<tr>
							<th>ItemNumber</th>
							<th>AgreementNumber</th>
              <th>RoomNumber</th>
              <th>BranchNumber</th>
              <th>Size</th>

						</tr>


            <?php

            $sql = "SELECT * FROM ItemInfo WHERE owner = '$username'";
            $agreements = $pdo->prepare($sql);
            $agreements->execute();
           while ($agreement = $agreements->fetch(PDO::FETCH_ASSOC)) {
          $agrmtNum = $agreement['agrmtNum'];
  $sql = "SELECT * FROM Item WHERE agrmtNum = '$agrmtNum'";
  $items = $pdo->prepare($sql);
  $items->execute();
  while ($item = $items->fetch(PDO::FETCH_ASSOC)) {
   echo "<tr><td>";
            echo($item['itemNum']);
            echo ("</td><td>");
            echo($item['agrmtNum']);
            echo ("</td></td>");
   echo($agreement['roomNum']);
            echo ("</td></td>");
   echo($agreement['branch']);
            echo ("</td></td>");
   echo($item['size']);
            echo ("</td></tr>");
  }
 }

            ?>
              </table>
            </div>
          </section>

	<div class="footer-container" >
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
	</div>
	<script>
		function mobileExpandMain() {
			var x = document.getElementById("mainbar");
			if (x.className === "items") {
				x.className += " responsive";
			} else {
				x.className = "items";
			}
		}

		function mobileExpandFunc() {
			var x = document.getElementById("funcbar");
			if (x.className === "items") {
				x.className += " responsive";
			} else {
				x.className = "items";
			}
		}
	</script>
</body>
</html>
