<?php
require_once "pdo_constructor.php";

$username = "";
if (isset($_COOKIE['zyxwuser'])) {
    $username = $_COOKIE['zyxwuser'];
}
$cusername = $username;
$startDate = "";
$endDate = "";
$rsvSpace = "";
$payment = "NULL";
$message = false;
$hasQuery = false;
if (isset($_POST) & !empty($_POST)) {
    $cusername = $_POST['cusername'];
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
    $rsvSpace = $_POST['rsvSpace'];

    if ($cusername=="" || $startDate=="" || $endDate == "" || $rsvSpace== "" ) {
        $message = "Please Complete All Required fields";
    }else{

        $sqlSelectedDates = "SELECT S.branchID AS branchID, S.roomNum AS roomNum, S.maxSpace, (S.maxSpace - used) AS available
        FROM Storeroom S,
        (SELECT branchID, roomNum, max(space) AS used
        FROM UsedSpace
        WHERE date BETWEEN '$startDate' AND '$endDate'
        GROUP BY branchID, roomNum) R
        WHERE S.branchID = R.branchID AND S.roomNum = R.roomNum AND (S.maxSpace - used) >= $rsvSpace";


        $types = "SELECT * FROM ItemType WHERE false OR ";
        if (isset($_POST['type'])) {
            $selectedTypes = $_POST['type'];
            foreach ($selectedTypes as $value) {
                $types = $types . "typeName = '" . $value . "' OR ";
            }
        }
        // if (isset($_POST['RGLR'])) {
        //     $types = $types . "typeName = 'RGLR' OR ";
        // }
        // if (isset($_POST['FLAM'])) {
        //     $types = $types . "typeName = 'FLAM' OR ";
        // }
        // if (isset($_POST['FRZN'])) {
        //     $types = $types . "typeName = 'FRZN' OR ";
        // }
        // if (isset($_POST['FRGL'])) {
        //     $types = $types . "typeName = 'FRGL' OR ";
        // }
        $types = $types . 'false';

        $sqlSelectedTypes = "SELECT branchID, roomNum, maxSpace FROM Storeroom S
        WHERE NOT EXISTS
        (SELECT T.typeName FROM (" . $types . ") T
        WHERE T.typeName NOT IN
        (SELECT R.typeName FROM Room_Type R
        WHERE R.branchID = S.branchID AND R.roomNum = S.roomNum))";


        $sqlEmptyRooms = "SELECT DISTINCT SR.branchid, SR.roomnum, SR.maxSpace, SR.maxSpace AS available
        FROM Storeroom SR
        WHERE SR.maxSpace >= $rsvSpace AND NOT EXISTS (
        SELECT 1 FROM UsedSpace US
        WHERE SR.branchID = US.branchID
        AND SR.roomNum = US.roomNum
    )";

    $sqlDatesEmpty = $sqlSelectedDates . " UNION " . $sqlEmptyRooms;

    $sqlAllCond = "SELECT A.branchID, A.roomNum, A.maxSpace, A.available
    FROM (" . $sqlDatesEmpty . ") A INNER JOIN (" . $sqlSelectedTypes . ") Z
    WHERE A.branchID = Z.branchID AND A.roomNum = Z.roomNum";

    $sqlFinal = "SELECT BR.branchID, BR.address AS address, SR.roomnum AS roomNum, SR.maxspace AS maxSpace, C.available AS available
    FROM (" . $sqlAllCond . ") C INNER JOIN Branch BR, Storeroom SR
    WHERE BR.branchID = SR.branchID AND SR.branchID = C.branchID AND SR.roomNum = C.roomNum";


    $stmt = $pdo->prepare($sqlFinal);
    $stmt->execute();
    $hasQuery = true;
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
<?php
if ($hasQuery) {
?>
<div class="tableblock" style="background-color: white; padding-top: 8em;">
    <h2>Available Rooms</h2>
  <div class="thetable" style="padding-bottom: 0;">
    <table class="entities" style="width:100%;">
      <tr>
        <th>Branch Address</th>
        <th>Room Number</th>
        <th>Item Type(s)</th>
        <th>Operation</th>
    </tr>
    <?php
    if ($hasQuery) {
        if (!$stmt->rowCount() > 0) {
            echo "<p style='color: red;'>Your search returned no results. Please try another combination.</p>";
        }
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $bid = $row['branchID'];
            $rid = $row['roomNum'];
            $sql = "SELECT R.typeName AS typeName FROM Room_Type R WHERE R.branchID = '$bid' and R.roomNum = '$rid'";
            $rtypes = $pdo->prepare($sql);
            $rtypes->execute();
            echo "<tr><td>";
            echo($row['address']);
            echo ("</td><td>");
            echo($row['roomNum']);
            echo ("</td><td>");
            while ($rtype = $rtypes->fetch(PDO::FETCH_ASSOC)) {
                echo ($rtype['typeName'] . " ");
            }
            echo ("</td><td>");
            $url = "pay.php?branchid=" . urlencode($bid) .
            "&roomnum=" . urlencode($rid) .
            "&startDate=" . urlencode($startDate) .
            "&endDate=" . urlencode($endDate) .
            "&username=" . urlencode($cusername) .
            "&space=" . urlencode($rsvSpace);
            echo '<a href="' . $url . '">SELECT</a>';
            echo "</td></tr>";
        }
    }?>
</table>
</div>
</div>
<?php }?>
<div class="form-container">
    <form method="post" style="background-color: white;">
        <div class="form-content" >
            <h2 style="color: #002145;">CPSC304 Group 1 Project</h2>
            <h3 style="color: #002145;">Find storeroom to reserve:</h3>
            <p>Username*:<br>
                <input class="short" type="text" name="cusername" value = <?php echo $cusername; ?>>
            </p>
            <p>From Date*:<br>
                <input class="short" type="date"  name="startDate" value=<?php echo $startDate; ?>>
            </p>
            <p>To Date*:<br>
                <input class="short" id="theDate" type="date"  name="endDate" value=<?php echo $endDate; ?>>
            </p>
            <p>Reserve Space (m<sup>3</sup>)*:<br>
                <input class="short" type="text" name="rsvSpace" value=<?php echo $rsvSpace; ?>>
            </p>
            <p>Select Item Type:<br><br>
                <?php
                $sqlAllTypes = "SELECT * FROM ItemType ORDER BY rate";
                $allTypes = $pdo->prepare($sqlAllTypes);
                $allTypes->execute();
                while ($oneType = $allTypes->fetch(PDO::FETCH_ASSOC)) {
                    $abbrev = $oneType['typeName'];
                    ?>
                    <input
                        type="checkbox"
                        name="type[]"
                        value='<?php echo $abbrev; ?>'
                        <?php echo (isset($_POST["RGLR"])) ? 'checked="checked"' : ''?>
                    /><?php echo "$abbrev"; ?>
                    <?php
                }
                ?>
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
