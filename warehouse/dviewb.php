<?php
require_once "pdo_constructor.php";

$sum = 0;
$countb = 0;
$msg = false;

if (isset($_POST['delete'])) {
	$employeetofired =  $_POST['delete'];
	$sql = "DELETE FROM Branch WHERE branchID = '$employeetofired'";
	$stmt = $pdo->prepare($sql);
	try {
		$stmt->execute();
		$msg = "Branch numbered $employeetofired has been dismissed!";
	} catch (PDOException $e) {
		$msg = "Failed to dismiss the branch numbered $employeetofired";
	}

}

$username = $_COOKIE['zyxwdirector'];
$sql = "SELECT * FROM Director WHERE username = '$username'";
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
		echo $username . "'s Management: Branches";
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
					echo($manager['fName'] . " " . $manager['lName']);
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
					<a href="dviewe.php ">Employees</a >
					<a href="dviewb.php">Branches</a >
					<a href="dviews.php">Storerooms</a >
					<a href="dviewc.php">Customers</a >
					<a href="dviewt.php">Transactions</a >
					<a href="javascript:void(0);" class="icon" onclick="mobileExpandFunc()">
						<i class="fa fa-bars"></i>
					</a>
				</div>
			</div>
			<div class="tableblock" style="background-color: white;">
				<h2>Branches</h2>
				<?php
				if ($msg != false) {
					echo "<p style='color: red;''>";
					echo "$msg";
					echo "</p>";
				}
				?>

				<div class="thetable" style="width: 90%;">
					<table class="entities" style="width:100%">
						<tr>
							<th>Branch ID</th>
							<th>Address</th>
							<th>Phone#</th>
							<th>Manager ID</th>
							<th>Labourer Number</th>
							<th>Revenue(CAD)</th>
							<th>Operation</th>
						</tr>
						<?php

						$sql = "SELECT * FROM Branch" ;
						$lbranchs = $pdo->prepare($sql);
						$lbranchs->execute();

						while ($lbranch= $lbranchs->fetch(PDO::FETCH_ASSOC)) {
							$countb++;
							$lmanager= $lbranch['branchID'];
							$sql = "SELECT employID FROM Manager
							WHERE branchID ='$lmanager'";
							$stmt = $pdo->prepare($sql);
							$stmt->execute();
							$row = $stmt->fetch(PDO::FETCH_ASSOC);

							$count = "SELECT COUNT(*) FROM Labourer
							WHERE branchID ='$lmanager'";
							$stmts = $pdo->prepare($count);
							$stmts->execute();
							$counts = $stmts->fetch(PDO::FETCH_ASSOC);

							$sql = "SELECT SUM(amount) FROM ItemInfo I, Agreement A, Payment P
									WHERE 
									I.agrmtNum = A.agrmtNum AND 
									A.payment = P.payNum AND
									I.branch = '$lmanager'";
							$stmt = $pdo->prepare($sql);
							$stmt->execute();
							$arevenue = $stmt->fetch(PDO::FETCH_ASSOC);

							$sql = "SELECT SUM(amount) FROM Reservation R, Payment P
									WHERE 
									R.payment = P.payNum AND
									R.branch = '$lmanager'";
							$stmt = $pdo->prepare($sql);
							$stmt->execute();
							$rrevenue = $stmt->fetch(PDO::FETCH_ASSOC);

							$income = $arevenue['SUM(amount)'] + $rrevenue['SUM(amount)'];
							$sum += $income;

							echo "<tr><td>";
							echo($lbranch['branchID']);
							echo ("</td><td>");
							echo($lbranch['address']);
							echo ("</td><td>");
							echo($lbranch['phoneNum']);
							echo ("</td><td>");
							echo($row['employID']);
							echo ("</td><td>");
							echo($counts['COUNT(*)']);
							echo ("</td><td>");
							echo($income);
							echo ("</td><td>");
							echo ("<form method='POST'>");
							echo "<button type='submit' name='delete' value=".$lbranch['branchID']." onclick='return ConfirmDelete()'> DELETE </button>";
							echo ("</form>");
							echo ("</td></tr>");
						}
						?>
					</table>
					<?php echo "<p style='text-align: left; color: #002145;'>There are " . $countb . " branches.</p>"; 
							$avg = $sum / $countb;
							echo "<p style='text-align: left; color: #002145;'>Average revenue: $" . $avg . " per branch.</p>"; ?>
							<br>
					<a class="linkbutton" href="bregis.php">New Branch</a>
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