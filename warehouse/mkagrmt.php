<?php
require_once "pdo_constructor.php";

if (isset($_POST['submit'])) {
    $confNum = $_POST['reservation'];
    $sql = "SELECT * FROM Reservation WHERE confNum = '$confNum'";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $reservation = $stmt->fetch(PDO::FETCH_ASSOC);
    $reserver = $reservation['reserver'];
    $startDay = date("Y-m-d");
    $endDay = $reservation['endDay'];
    $rsvSpace = $reservation['rsvSpace'];
    $branch = $reservation['branch'];
    $roomNum = $reservation['roomNum'];
    $payment = $reservation['payment'];

    $sql = "INSERT INTO Agreement VALUES (0, '$startDay', '$endDay', '$payment', NULL, '$confNum')";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $sql = "SELECT agrmtNum FROM Agreement WHERE payment = '$payment'";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $Num = $stmt->fetch(PDO::FETCH_ASSOC);
    $agrmtNum = $Num['agrmtNum'];
    echo $agrmtNum;

    $sql = "INSERT INTO ItemInfo VALUES('$agrmtNum', '$reserver', '$branch', '$roomNum')";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $url = "maddi.php?agrmtNum=" . urlencode($agrmtNum) .
    "&branch=" . urlencode($branch) .
    "&roomNum=" . urlencode($roomNum) .
    "&rsvSpace=" . urlencode($rsvSpace);

    header("Location:" . $url);
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Reservation</title>
    <link rel="stylesheet" href="./css/form.css">
    <link rel="stylesheet" href="./css/table.css">
    <link rel="stylesheet" href="./css/navbar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        form {
            width: 60%;
            background-color: rgb(230, 230, 230);
            margin-top: 0em;
            margin-bottom: 8em;
        }

        .thetable {
            width: 60%;
        }

        @media screen and (max-width: 1080px) {
            form {
                width: 80%;
            }

            .thetable{
                width: 80%;
            }
        }
    </style>
    <script src="modernizr.js"></script>
</head>
<body>
    <div class="navbar">
        <div class="items" id="thebar">
          <a href="./index.php#home" id="brandlabel">ZYXW STORAGE</a>
          <a href="./index.php#about">ABOUT</a>
          <a href="./index.php#contact">CONTACT</a>
          <a href="./plans.php">PLANS</a>
          <a  href="./elogin.php">EMPLOYEE</a>
          <a  href="./clogin.php">MY ACCOUNT</a>
          <a href="javascript:void(0);" class="icon" onclick="mobileExpand()">
            <i class="fa fa-bars"></i>
        </a>
    </div>
</div>

<div class="form-container">
    <form method="post" style="background-color: white;">
        <div class="form-content" >
            <h2 style="color: #002145;">CPSC304 Group 1 Project</h2>
            <h3 style="color: #002145;">Retrive the reservation:</h3>
            <p>Confirmation Number*:<br>
                <input class="short" type="text" name="reservation" required>
            </p>
            <div>
                <input class="button confirm" type="submit" name="submit" value="Retrive">
            </div>
        </div>
    </form>
</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="http://cdn.jsdelivr.net/webshim/1.12.4/extras/modernizr-custom.js"></script>
<script src="http://cdn.jsdelivr.net/webshim/1.12.4/polyfiller.js"></script>
<script>
    webshims.setOptions('waitReady', false);
    webshims.setOptions('forms-ext', {type: 'date'});
    webshims.setOptions('forms-ext', {type: 'time'});
    webshims.polyfill('forms forms-ext');
</script>
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
