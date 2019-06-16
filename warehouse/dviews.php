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
		echo $username . "'s Management: Storerooms";
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
				<h2>Storerooms by Type</h2>
				<div class="thetable" style="width: 90%; padding-bottom: 0;">
					<table class="entities" style="width:100%">
						<tr>
							<th>Storeroom Type</th>
							<th>Number</th>
							<th>Total Revenue (CAD)</th>
						</tr>
						<?php
						$sql = "SELECT T.typeName, COUNT(*), SUM(amount) FROM Reservation R, Room_Type T, Payment P 
						WHERE 
						(R.branch,R.roomNum) = (T.branchID, T.roomNum) AND 
						R.payment = P.payNum 
						GROUP BY T.typeName";
						$stmt = $pdo->prepare($sql);
						$stmt->execute();
						while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
							$type = $row['typeName'];
							$sql = "SELECT SUM(amount) FROM Room_Type T, Agreement A, ItemInfo I, Payment P
							WHERE 
							(T.branchID, T.roomNum) = (I.branch, I.roomNum) AND
							I.agrmtNum = A.agrmtNum AND
							A.payment = P.payNum AND
							T.typeName = '$type'";
							$amount = $pdo->prepare($sql);
							$amount->execute();
							$value = $amount->fetch(PDO::FETCH_ASSOC);
							$revenue = $row['SUM(amount)'] + $value['SUM(amount)'];
							?>
							<tr>
								<td><?php echo $type; ?></td>
								<td><?php echo $row['COUNT(*)']; ?></td>
								<td><?php echo $revenue; ?></td>
							<?php }?>
						</tr>
					</table>
					<p style='text-align: left; color: #002145;'>NOTE: A room may have multiple types.</p>
				</div>
			</div>
			<div class="tableblock" style="background-color: white;">
				<h2>All Storerooms</h2>
				<div class="thetable" style="width: 90%;">
					<table class="entities" style="width:100%">
						<tr>
							<th>Branch</th>
							<th>Room Number</th>
							<th>Max Space (m<sup>3</sup>)</th>
							<th>Types</th>
						</tr>
						<?php
						$sql = "SELECT * FROM Storeroom ORDER BY branchID";
						$stmt = $pdo->prepare($sql);
						$stmt->execute();
						while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
							$count++;
							$branch = $row['branchID'];
							$room = $row['roomNum'];
							$sql = "SELECT typeName FROM Room_Type T 
							WHERE 
							(T.branchID, T.roomNum) = ('$branch', '$room')";
							$types = $pdo->prepare($sql);
							$types->execute();
							?>
							<tr>
								<td><?php echo $row['branchID']; ?></td>
								<td><?php echo $row['roomNum']; ?></td>
								<td><?php echo $row['maxSpace']; ?></td>
								<td>
									<?php 
									while($type = $types->fetch(PDO::FETCH_ASSOC)) {
										echo $type['typeName'] . " ";
									}
									?></td>
								<?php }?>
							</tr>
						</table>
						<?php
						echo "<p style='text-align: left; color: #002145;'>There are " . $count . " storerooms.</p>";
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

			function ConfirmDelete() {
				return confirm("Are you sure you want to delete?");
			}
		</script>
	</body>
	</html>
