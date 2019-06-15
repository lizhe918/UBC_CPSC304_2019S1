<?php
    require_once "pdo_constructor.php";
    $username = $_COOKIE['zyxwuser'];
    $cusername = $username;
    $startDate = "";
    $endDate = "";
    $rsvSpace = "";
    // $branch = "";
    // $roomNum = "";
    $payment = "NULL";
    $message = false;
    if (isset($_POST) & !empty($_POST)) {
        $cusername = $_POST['cusername'];
        $startDate = $_POST['startDate'];
        $endDate = $_POST['endDate'];
        $rsvSpace = $_POST['rsvSpace'];
        // $branch =  $_POST['branch'];
        // $roomNum = $_POST['roomNum'];

        if ($cusername=="" || $startDate=="" || $endDate == "" || $rsvSpace== "" ) {
            $message = "Please Complete All Required fields";
        }else{
            $types = "SELECT * FROM ItemType WHERE false OR ";
            if (isset($_POST['RGLR'])) {
                $types = $types . "typeName = 'RGLR' OR ";
            }
            if (isset($_POST['FLAM'])) {
                $types = $types . "typeName = 'FLAM' OR ";
            }
            if (isset($_POST['FRZN'])) {
                $types = $types . "typeName = 'FRZN' OR ";
            }
            if (isset($_POST['FRGL'])) {
                $types = $types . "typeName = 'FRGL' OR ";
            }
            $types = $types . 'false';
            
            $sql = "SELECT * FROM Storeroom S
            WHERE NOT EXISTS
            ((SELECT T.typeName FROM (" . $types . ") T)
             EXCEPT
             (SELECT R.typeName FROM Room_Type R
              WHERE R.branchID = S.branchID AND R.roomNum = S.roomNum))";
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            //$a = $stmt->fetch(PDO::FETCH_ASSOC);
            
        }
    }
  ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Reservation</title>
    <link rel="stylesheet" href="./css/form.css">
    <link rel="stylesheet" href="./css/navbar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        form {
            width: 60%;
            background-color: rgb(230, 230, 230);
            margin-top: 6em;
            margin-bottom: 8em;
        }

        @media screen and (max-width: 1080px) {
            form {
                width: 80%;
            }
        }
    </style>
    <script src="modernizr.js"></script>
</head>
<body>
    <div class="navbar">
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
    </div>
    <div class="form-container">
    <form method="post">
        <div class="form-content">
        <h2 style="color: #002145;">CPSC304 Group 1 Project</h2>
        <h3 style="color: #002145;">Create New ZYXW Storage Reservation:</h3>
        <p>Username*:<br>
            <input class="short" type="text" name="cusername" value = <?php echo $cusername; ?>>
        </p>
        <p>From Date*:<br>
            <input class="short" type="date"  name="startDate" value=<?php echo $startDate; ?>>
        </p>
        <p>To Date*:<br>
            <input class="short" id="theDate" type="date"  name="endDate" value=<?php echo $endDate; ?>>
        </p>
        <p>Reserve Space*:  <span style="font-size:0.5em"> If you are concerning about how much space you need, please feel free to contact any of our branches.</span><br> 
            <input class="short" type="text" name="rsvSpace" value=<?php echo $rsvSpace; ?>>
        </p>
        <p>Select Item Type*:<br>
        <input type="checkbox" name="RGLR" value="Regular">Regular<br>
        <input type="checkbox" name="FRZN" value="Frozen">Frozen<br>
        <input type="checkbox" name="FLAM" value="Flammable">Flammable<br>
        </p>
        <?php
            if ($message != false) {
                    echo "<p style='color: red; font-weight: bold;'>$message</p>";
                }
        ?>
        <div>
            <input class="button confirm" type="submit" name="submit" value="Submit">
        </div>
        </div>
        <div style="padding: 2em; padding-top:0;">
        <h4 style="margin-top:0;">OR</h4>
        <a href="crsrv.php">Back to Reservations</a>
        <p></p>
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
