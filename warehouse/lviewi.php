<?php
require_once "pdo_constructor.php";

$count = 0;

$username = $_COOKIE['zyxwworker'];
$sql = "SELECT * FROM Labourer WHERE employID = '$username'";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);
$eid = $user['employID'];
$sql = "SELECT * FROM Employee WHERE employID = '$eid'";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$worker = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>
		<?php
		echo $username . "'s Workspace";
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
		<div class="items" id="mainbar" >
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
					echo($worker['fName'] . " " . $worker['lName']);
					?>
				</h2>
				<p>
					<?php
					echo($_COOKIE['zyxwworker']);
					?>
				</p>
			</div>
			<div class="info">
				<p><img src="https://img.icons8.com/metro/420/phone.png">
					<?php
					echo($worker['phoneNum']);
					?>
				</p>
				<p><img src="https://cdn4.iconfinder.com/data/icons/maps-and-navigation-solid-icons-vol-1/72/19-512.png">
					<?php
					echo($worker['address']);
					?>
				</p>
				<p><img src="https://cdn3.iconfinder.com/data/icons/business-office-1-2/256/Identity_Document-512.png">
					<?php
					echo($worker['SINNum']);
					?>
				</p>
				<p><img src="https://cdn1.iconfinder.com/data/icons/education-set-01/512/email-open-512.png">
					<?php
					echo($worker['email']);
					?>
				</p>
				<a class="linkbutton" href="lupdate.php">Edit Profile</a>
			</div>
		</div>
		<div class="column function">
			<div class="navbar" style="position: relative;">
				<div class="items" id="funcbar">
					<a href="lviewm.php">My Branch</a>
					<a href="lviewi.php">View Items</a>
					<a href="javascript:void(0);" class="icon" onclick="mobileExpandFunc()">
						<i class="fa fa-bars"></i>
					</a>
				</div>
			</div>
			<div class="tableblock" style="background-color: white;">
				<h2>Items</h2>
				<div class="thetable" style="width: 90%;">
					<table class="entities" style="width:100%">
						<tr>
							<th>Item Number</th>
							<th>Owner</th>
							<th>Room Number</th>
							<th>Type</th>
							<th>Size (m<sup>3</sup>)</th>
						</tr>
						<?php
						$branch = $user['branchID'];
						$sql = "SELECT * FROM ItemInfo INNER JOIN Item ON
						Item.agrmtNum = ItemInfo.agrmtNum
						WHERE branch = '$branch'" ;
						$stmt = $pdo->prepare($sql);
						$stmt->execute();
						while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
								$count++;
								echo "<tr><td>";
								echo($row['itemNum']);
								echo ("</td><td>");
								echo ($row['owner']);
								echo ("</td><td>");
								echo($row['roomNum']);
								echo ("</td><td>");
								$iNum = $row['itemNum'];
								$sql = "SELECT * FROM ItemClass WHERE itemNum = '$iNum'";
								$iClasses = $pdo->prepare($sql);
								$iClasses->execute();
								while ($iClass = $iClasses->fetch(PDO::FETCH_ASSOC)) {
									echo ($iClass['typeName']."<br>");
								}
								echo ("</td><td>");
								echo ($row['size']);
								echo ("</td></tr>");
							}
						?>
					</table>
					<?php echo "<p style='text-align: left; color: #002145;'>There are " . $count . " items.</p>"; ?>
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
