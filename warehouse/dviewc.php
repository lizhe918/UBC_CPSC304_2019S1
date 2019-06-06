<?php
require_once "pdo_constructor.php";

$count = 0;
$sum = 0;

$username = $_COOKIE['zyxwdirector'];
$sql = "SELECT * FROM Director WHERE username = '$username'";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);
$eid = $user['employID'];
$sql = "SELECT * FROM Employee WHERE employID = '$eid'";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$director = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>
		<?php
		echo $username . "'s Management: Customers";
		?>
	</title>
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
	<section class="navbar" style="z-index: 101;">
		<div class="items" id="mainbar">
			<a href="./index.html#home" id="brandlabel">ZYXW STORAGE</a>
			<a href="./index.html#about">ABOUT</a>
			<a href="./index.html#contact">CONTACT</a>
			<a href="./plans.php">PLANS</a>
			<a  href="./logout.php">LOG OUT</a>
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
					echo($director['fName'] . " " . $director['lName']);
					?>
				</h2>
				<p>
					<?php
					echo($_COOKIE['zyxwdirector']);
					?>
				</p>
			</div>
			<div class="info">
				<p><img src="https://img.icons8.com/metro/420/phone.png">
					<?php
					echo($director['phoneNum']);
					?>
				</p>
				<p><img src="https://cdn4.iconfinder.com/data/icons/maps-and-navigation-solid-icons-vol-1/72/19-512.png">
					<?php
					echo($director['address']);
					?>
				</p>
				<p><img src="https://cdn3.iconfinder.com/data/icons/business-office-1-2/256/Identity_Document-512.png">
					<?php
					echo($director['SINNum']);
					?>
				</p>
				<p><img src="https://cdn1.iconfinder.com/data/icons/education-set-01/512/email-open-512.png">
					<?php
					echo($director['email']);
					?>
				</p>
				<a class="linkbutton" href="dupdate.php">Edit Profile</a>
			</div>
		</div>
		<div class="column function">
			<div class="navbar" style="position: relative;">
				<div class="items" id="funcbar">
				<a href="dviewe.php">Employees</a>
				<a href="dviewb.php">Branches</a>
				<a href="dviews.php">Storerooms</a>
				<a href="dviewc.php">Customers</a>
				<a href="dviewt.php">Transactions</a>
					<a href="javascript:void(0);" class="icon" onclick="mobileExpandFunc()">
						<i class="fa fa-bars"></i>
					</a>
				</div>
			</div>
			<div class="tableblock" style="background-color: white;">
				<h2>Customers</h2>
				<div class="thetable" style="width: 90%;">
					<table class="entities" style="width:100%">
						<tr>
							<th>Username</th>
							<th>Name</th>
							<th>ID Number</th>
							<th>Phone#</th>
							<th>Email</th>
							<th>Value(CAD)</th>
						</tr>
						<?php
						$sql = "SELECT * FROM Customer";
						$customers = $pdo->prepare($sql);
						$customers->execute();
						while ($customer = $customers->fetch(PDO::FETCH_ASSOC)) {
							$cuser = $customer['username'];
							$sql = "SELECT SUM(amount) FROM ItemInfo I, Agreement A, Payment P
									WHERE 
									I.agrmtNum = A.agrmtNum AND A.payment = P.payNum AND I.owner = '$cuser'";
							$amount = $pdo->prepare($sql);
							$amount->execute();
							$value = $amount->fetch(PDO::FETCH_ASSOC);
							$sum += $value['SUM(amount)'];
							$count++;
						?>
						<tr>
							<td><?php echo $customer['username']; ?></td>
							<td><?php echo $customer['fName'] . " " . $customer['lName']; ?></td>
							<td><?php echo $customer['IDNum']; ?></td>
							<td><?php echo $customer['phoneNum']; ?></td>
							<td><?php echo $customer['email']; ?></td>
							<td><?php echo $value['SUM(amount)']; ?></td>
						<?php }?>
					</table>
					<?php echo "<p style='text-align: left; color: #002145;'>There are " . $count . " customers.</p>"; 
						  $avg = $sum / $count;
						  echo "<p style='text-align: left; color: #002145;'>Average revenue: $" . $avg . ".</p>"?>
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

		function ConfirmDelete() {
  			return confirm("Are you sure you want to delete?");
		}
	</script>
</body>
</html>
