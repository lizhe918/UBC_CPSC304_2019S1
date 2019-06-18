<?php
require_once "pdo_constructor.php";

$sum = 0;
$count = 0;

$username = $_COOKIE['zyxwmanager'];
$sql = "SELECT * FROM Manager WHERE username = '$username'";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);
$eid = $user['employID'];
$sql = "SELECT * FROM Employee WHERE employID = '$eid'";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$manager = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>
		<?php
		echo $username . "'s Management: Transactions";
		?>
	</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="./css/usermain.css">
	<link rel="stylesheet" type="text/css" href="./css/footer.css">
	<link rel="stylesheet" type="text/css" href="./css/profile.css">
	<link rel="stylesheet" type="text/css" href="./css/table.css">
	<link rel="stylesheet" type="text/css" href="./css/navbar.css">
	<link rel="stylesheet" type="text/css" href="./css/logout.css">
	<link rel="stylesheet" type="text/css" href="./css/input_button.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<body>
	<section class="navbar" style="z-index: 101;">
		<div class="items" id="mainbar">
			<a href="./index.php#home" id="brandlabel">ZYXW STORAGE</a>
			<a href="./index.php#about">ABOUT</a>
			<a href="./index.php#contact">CONTACT</a>
			<a href="./plans.php">PLANS</a>
			<a  href="./elogin.php">EMPLOYEE</a>
			<a href="./logout.php" id="logout">LOG OUT</a>
			<a href="javascript:void(0);" class="icon" onclick="mobileExpandMain()">
				<i class="fa fa-bars"></i>
			</a>
		</div>
	</section>
	<section class="row">
		<div class="column profile">
			<h1>Welcome!</h1>
			<div class="username">
				<h2>
					<?php
					echo($manager['fName'] . " " . $manager['lName']);
					?>
				</h2>
				<p>
					<?php
					echo($_COOKIE['zyxwmanager']);
					?>
				</p>
			</div>
			<div class="info">
				<p><img src="https://img.icons8.com/metro/420/phone.png">
					<?php
					echo($manager['phoneNum']);
					?>
				</p>
				<p><img src="https://cdn4.iconfinder.com/data/icons/maps-and-navigation-solid-icons-vol-1/72/19-512.png">
					<?php
					echo($manager['address']);
					?>
				</p>
				<p><img src="https://cdn3.iconfinder.com/data/icons/business-office-1-2/256/Identity_Document-512.png">
					<?php
					echo($manager['SINNum']);
					?>
				</p>
				<p><img src="https://cdn1.iconfinder.com/data/icons/education-set-01/512/email-open-512.png">
					<?php
					echo($manager['email']);
					?>
				</p>
				<a class="linkbutton" href="mupdate.php">Edit Profile</a>
			</div>
		</div>
		<div class="column function">
			<div class="navbar" style="position: relative;">
				<div class="items" id="funcbar">
				<a href="magrmt.php">Agreements</a>
				<a href="mviewr.php">Reservations</a>
				<a href="mviewp.php">Transactions</a>
				<a href="mviewi.php">View Items</a>
				<a href="mcheck.php">Storerooms</a>
				<a href="mviewe.php">Workers</a>
					<a href="javascript:void(0);" class="icon" onclick="mobileExpandFunc()">
						<i class="fa fa-bars"></i>
					</a>
				</div>
			</div>
			<div class="tableblock" style="background-color: white;">
				<h2>Transactions</h2>
				<div class="thetable" style="width: 90%;">
					<table class="entities" style="width:100%">
						<tr>
							<th>Payment Number</th>
							<th>Value (CAD)</th>
							<th>Method</th>
							<th>Card Number</th>
						</tr>
						<?php
						$branch = $user['branchID'];
						$sql = "SELECT payment FROM Agreement INNER JOIN ItemInfo ON
								Agreement.agrmtNum = ItemInfo.agrmtNum
								WHERE branch = '$branch'
								UNION
								SELECT payment FROM Reservation
								WHERE branch = '$branch'" ;
						$payNums = $pdo->prepare($sql);
						$payNums->execute();
						while ($payNum = $payNums->fetch(PDO::FETCH_ASSOC)) {
							$count++;
							$num = $payNum['payment'];
							$sql = "SELECT * FROM Payment INNER JOIN Card
							ON Payment.cardNum =Card.cardNum
							WHERE payNum ='$num'";
							$stmt = $pdo->prepare($sql);
							$stmt->execute();
							$payment = $stmt->fetch(PDO::FETCH_ASSOC);
							  echo "<tr><td>";
								echo($payment['payNum']);
								echo ("</td><td>");
								echo('$' . $payment['amount']);
								$sum += $payment['amount'];
								echo ("</td><td>");
								echo($payment['method']);
                				echo ("</td><td>");
								echo($payment['cardNum']);
								echo ("</td></tr>");
							}
						?>
					</table>
					<?php
						echo "<p style='text-align: left; color: #002145;'>There are " . $count . " transactions.</p>";
						echo "<p style='text-align: left; color: #002145;'>Total value: $" . $sum . ".</p>";
					?>
				</div>
			</div>
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
