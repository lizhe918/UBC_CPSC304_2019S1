<?php
require_once "pdo_constructor.php";

$count = 0;

$username = $_COOKIE['zyxwmanager'];
$sql = "SELECT * FROM Manager WHERE username = '$username'";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);
$branchid = $user['branchID'];
$eid = $user['employID'];
$sql = "SELECT * FROM Employee WHERE employID = '$eid'";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$manager = $stmt->fetch(PDO::FETCH_ASSOC);


$startDate = "";
$endDate = "";
$rsvSpace = "";
$payment = "NULL";
$message = false;
$hasQuery = false;
if (isset($_POST) & !empty($_POST)) {
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
    $rsvSpace = $_POST['rsvSpace'];

    if ($startDate=="" || $endDate == "" || $rsvSpace== "" ) {
        $message = "Please Complete All Required fields";
    }else{

        $sqlSelectedDates = "SELECT S.branchid AS branchID, S.roomnum AS roomNum, S.maxSpace, (S.maxSpace - used) AS Available
        FROM Storeroom S, 
        (SELECT branchid, roomnum, max(space) AS used
        FROM usedspace
        WHERE date BETWEEN '$startDate' AND '$endDate'
        GROUP BY branchid, roomnum) r
        WHERE S.branchID = R.branchID AND S.roomNum = R.roomNum AND (S.maxSpace - used) >= $rsvSpace";


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

        $sqlSelectedTypes = "SELECT branchID, roomNum, maxSpace FROM Storeroom S
        WHERE NOT EXISTS
        (SELECT T.typeName FROM (" . $types . ") T
        WHERE T.typeName NOT IN
        (SELECT R.typeName FROM Room_Type R
        WHERE R.branchID = S.branchID AND R.roomNum = S.roomNum))";


        $sqlEmptyRooms = "SELECT DISTINCT SR.branchid, SR.roomnum, SR.maxSpace, SR.maxSpace AS Available
        FROM storeroom SR
        WHERE SR.maxSpace >= $rsvSpace AND NOT EXISTS (
        SELECT 1 FROM usedspace US
        WHERE SR.branchid = US.branchid
        AND SR.roomnum = US.roomnum
    )";

    $sqlDatesEmpty = $sqlSelectedDates . " UNION " . $sqlEmptyRooms;

    $sqlAllCond = "SELECT A.branchid, A.roomnum, A.maxspace, A.available 
    FROM (" . $sqlDatesEmpty . ") A INNER JOIN (" . $sqlSelectedTypes . ") Z 
    WHERE A.branchid = Z.branchid AND A.roomnum = Z.roomnum";

    $sqlFinal = "SELECT BR.branchID, BR.address AS address, SR.roomnum AS roomNum, SR.maxspace AS maxSpace, C.available AS available 
    FROM (" . $sqlAllCond . ") C INNER JOIN branch BR, storeroom SR 
    WHERE BR.branchid = SR.branchid AND SR.branchid = C.branchid AND SR.roomnum = C.roomnum AND BR.branchid = '$branchid'
    ORDER BY SR.roomNum";


    $stmt = $pdo->prepare($sqlFinal);
    $stmt->execute();
    $hasQuery = true;
}  
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>
        <?php
        echo $username . "'s Management: Reservations";
        ?>
    </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="./css/usermain.css">
    <link rel="stylesheet" type="text/css" href="./css/footer.css">
    <link rel="stylesheet" type="text/css" href="./css/profile.css">
    <link rel="stylesheet" type="text/css" href="./css/form.css">
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
            <div class="form-container" style="padding-top: 0;">
                <form method="post" style="background-color: white; width: 100%;">
                    <div class="form-content" >
                        <h3 style="color: #002145;">Select Time and Room Type:</h3>
                        <p>From Date*:<br>
                            <input class="short" type="date"  name="startDate" value=<?php echo $startDate; ?>>
                        </p>
                        <p>To Date*:<br>
                            <input class="short" id="theDate" type="date"  name="endDate" value=<?php echo $endDate; ?>>
                        </p>
                        <p>Require Space (m<sup>3</sup>)*:<br>
                            <input class="short" type="text" name="rsvSpace" value=<?php echo $rsvSpace; ?>>
                        </p>
                        <p>Select Item Type:<br>
                            <input type="checkbox" name="RGLR" value="Regular" <?php echo (isset($_POST["RGLR"])) ? 'checked="checked"' : ''?> />Regular<br>
                            <input type="checkbox" name="FRZN" value="Frozen" <?php echo (isset($_POST["FRZN"])) ? 'checked="checked"' : ''?> />Frozen<br>
                            <input type="checkbox" name="FLAM" value="Flammable" <?php echo (isset($_POST["FLAM"])) ? 'checked="checked"' : ''?> />Flammable<br>
                            <input type="checkbox" name="FRGL" value="Fragile" <?php echo (isset($_POST["FRGL"])) ? 'checked="checked"' : ''?> />Fragile<br>
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
            <?php 
            if ($hasQuery) {
                ?>
                <div class="tableblock" style="background-color: white;">
                    <h2>Available Rooms</h2>
                    <div class="thetable" style="width: 100%;">
                        <table class="entities" style="width:100%;">
                          <tr>
                            <th>Room Number</th> 
                            <th>Available Space (m<sup>3</sup>)</th>
                            <th>Max Space (m<sup>3</sup>)</th>
                            <th>Item Type(s)</th>
                        </tr>
                        <?php
                        if ($hasQuery) {
                            if (!$stmt->rowCount() > 0) {
                                echo "<p style='color: red;'>Your search returned no results. Please try another combination.</p>";
                            }
                            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $bid = $row['branchID'];
                                $rid = $row['roomNum'];
                                $sql = "select r.typeName as typeName from room_type r where r.branchid = '$bid' and r.roomnum = '$rid'";
                                $rtypes = $pdo->prepare($sql);
                                $rtypes->execute();
                                echo "<tr><td>";
                                echo($row['roomNum']);
                                echo ("</td><td>");
                                echo($row['available']);
                                echo ("</td><td>");
                                echo($row['maxSpace']);
                                echo ("</td><td>");
                                while ($rtype = $rtypes->fetch(PDO::FETCH_ASSOC)) {
                                    echo ($rtype['typeName'] . " ");
                                }
                                echo ("</td></tr>");
                            }
                        }?>           
                    </table>
                </div>        
            </div>
        <?php }?>
    </div>
</section>

<section class="footer-container">
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
