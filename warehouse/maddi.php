<?php
require_once "pdo_constructor.php";

$msg = false;

$agrmtNum = $_GET['agrmtNum'];
$branch = $_GET['branch'];
$roomNum = $_GET['roomNum'];


if (isset($_POST['submit'])) {
    if (!isset($_POST['type'])) {
        $msg = "Please select at least one type!";
    } else{
        $size = $_POST['size'];
        $sql = "INSERT INTO Item VALUES('0', '$agrmtNum', '$size')";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $sql = "SELECT MAX(itemNum) AS itemNum FROM Item";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $Num = $stmt->fetch(PDO::FETCH_ASSOC);
        $itemNum = $Num['itemNum'];

        $selectedTypes = $_POST['type'];
        foreach ($selectedTypes as $value) {
            $sql = "INSERT INTO ItemClass VALUES('$itemNum', '$value')";
        }

        $url = "maddi.php?agrmtNum=" . urlencode($agrmtNum) .
        "&branch=" . urlencode($branch) .
        "&roomNum=" . urlencode($roomNum);

        header("Location:" . $url);
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

<div class="form-container">
    <form method="post" style="background-color: white;">
        <div class="form-content" >
            <h2 style="color: #002145;">CPSC304 Group 1 Project</h2>
            <h3 style="color: #002145;">Add an item:</h3>
            <?php if ($msg != false) {
                echo "<p style='color: red;'>$msg</p>";
            }?>
            <p>Size (m<sup>3</sup>)*:<br>
                <input class="short" type="number" name="size" required>
            </p>
            <p>Type(s):<br><br>
                <?php
                $sqlAllTypes = "SELECT * FROM Room_Type WHERE branchID = '$branch' AND roomNum = '$roomNum'";
                $allTypes = $pdo->prepare($sqlAllTypes);
                $allTypes->execute();
                while ($oneType = $allTypes->fetch(PDO::FETCH_ASSOC)) {
                    $abbrev = $oneType['typeName'];
                    ?>
                    <input
                        type="checkbox"
                        name= 'type[]'
                        value='<?php echo "$abbrev"; ?>'
                        <?php echo (isset($_POST["$abbrev"])) ? 'checked="checked"' : ''?>
                    /><?php echo "$abbrev"; ?>
                    <?php
                }
                ?>
            </p>
            <div>
                <input class="button confirm" type="submit" name="submit" value="Add Item">
            </div>
        </div>
        <div style="padding: 2em; padding-top:0;">
            <h4 style="margin-top:0;">OR</h4>
            <p></p>
            <a href="./magrmt.php">Finish</a>
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
