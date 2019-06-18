<?php
    require_once "pdo_constructor.php";
    $username = $_GET['username'];
    $startDate = $_GET['startDate'];
    $endDate = $_GET['endDate'];
    $space = $_GET['space'];
    $branchid = $_GET['branchid'];
    $roomnum = $_GET['roomnum'];

    $earlier = new DateTime($startDate);
    $later = new DateTime($endDate);
    $diffString = $later->diff($earlier)->format("%a");
    $diffNumDay = intval($diffString);
        $sql =  "SELECT MAX(rate) AS r FROM Room_Type R, ItemType I WHERE R.typeName=I.typeName AND roomNum = '$roomnum' AND branchID = '$branchid'";
        $stmt = $pdo->prepare($sql);
        $Rate = $stmt->fetch(PDO::FETCH_ASSOC);
        $Rate = $Rate["r"];
        $fee = $Rate*$diffNumDay*$space;
    $message = false;

    if (isset($_POST['cancel'])) {
        header("Location: index.php");
    } else if (isset($_POST) & !empty($_POST)) {
      $success = 1;
        $cardNum = $_POST['cardNum'];
        $month = $_POST['Month'];
        $year = $_POST['year'];
        $cvv = $_POST['cvv'];
        $firstname = $_POST['FName'];
        $lastname = $_POST['LName'];
        $ExpDate = $year."-".$month."-"."01";

        $type = "";
        if(substr($cardNum, 0,1) == "4"){
          $type = "VISA";
        }else if(substr($cardNum,0,1) == "5"){
          $type = "MSTR";
        }else if(substr($cardNum,0,1) == "3"){
          $type = "AMEX";
        }else{
          $message = "Unaccepted Payment Method";
          $success = 0;
        }

      if ($success == 1){
        $sql = "SELECT * FROM Card WHERE cardNum = '$cardNum'";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        if ($stmt->rowCount() == 0){
          $sql = "INSERT INTO Card VALUES ('$cardNum','$ExpDate','$type')";
          $stmt = $pdo->prepare($sql);
          $stmt->execute();
        }
        $sql = "INSERT INTO Payment VALUES ('0','$fee','$cardNum')";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $sql = "SELECT MAX(payNum) FROM Payment";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $paymentNum = $stmt->fetch(PDO::FETCH_ASSOC);
        $pN = $paymentNum["MAX(payNum)"];
        $sql = "INSERT INTO Reservation VALUES ('0','$username',STR_TO_DATE('$startDate','%Y-%m-%d'),STR_TO_DATE('$endDate','%Y-%m-%d'),'$space','$branchid','$roomnum','$pN')";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();


        $begin = new DateTime($startDate);
        $end = new DateTime($endDate);
        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($begin, $interval, $end);

        foreach ($period as $dt) {
          $currD = $dt->format('Y-m-d');
          $s = intval($space) ;

          $sql = "SELECT * From UsedSpace WHERE roomNum = '$roomnum'AND branchID='$branchid'AND date =STR_TO_DATE('$currD','%Y-%m-%d')";
          $stmt = $pdo->prepare($sql);
            $stmt->execute();
            if ($stmt->rowCount() > 0){
              $sql = "UPDATE UsedSpace SET space = space + $s WHERE roomNum = '$roomnum' AND branchID = '$branchid' AND date = STR_TO_DATE('$currD','%Y-%m-%d')";
              $stmt = $pdo->prepare($sql);
              $stmt->execute();
            }else {
              $sql = "INSERT INTO UsedSpace VALUES ('$roomnum','$branchid',STR_TO_DATE('$currD','%Y-%m-%d'),'$s')";
              $stmt = $pdo->prepare($sql);
              $stmt->execute();
            }
        }

        header("Location:payRedirect.php");
        exit;
      }
    }

  
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Payment</title>
    <link rel="stylesheet" href="./css/form.css">
    <link rel="stylesheet" href="./css/navbar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  </head>
  <body>
    <div class="navbar">
    <div class="items" id="thebar">
      <a href="./index.php#home" id="brandlabel">ZYXW STORAGE</a>
        <a href="./index.php#about">ABOUT</a>
        <a href="./index.php#contact">CONTACT</a>
        <a href="./plans.php">PLANS</a>
        <a  href="./elogin.php">EMPLOYEE</a>
        
      <a href="javascript:void(0);" class="icon" onclick="mobileExpand()">
        <i class="fa fa-bars"></i>
      </a>
    </div>
    </div>
    <div style="background-image:white;" class="form-container">
    <form style="background-color: white;" method="post">
      <div "background-color: white;" class="form-content">
        <h3 style="color: #002145;">Pay with Your Credit Card: </h3>
        <h3 style="color: #002145;">Amount Due: $<?php echo $fee; ?></h3>
        <img src = "images/card.png" height='25em' >
        <p>Card Number*:<br>
        <input class="medium" type="text" name="cardNum" required>
        </p>
        <p>MM*:<br>
          <input class='short' type="text" name="Month" required>
        </p>
        <p>YY*:<br>
          <input class='short' type="text" name="year" required>
        </p>
        <p>CVV/CVC*:<br>
          <input class='short' type="text" name="cvv" required>
        </p>
        <p>First Name*:<br>
          <input class='medium' type="text" name="FName" required>
        </p>
        <p>Last Name*:<br>
          <input class='medium' type="text" name="LName" required>
        </p>
        <?php
            if ($message != false) {
                    echo "<p style='color: red; font-weight: bold;'>$message</p>";
                }
        ?>
        <div>
          <input class="button confirm" type="submit" name="submit" value="Submit">
          <input class="button cancel" type="submit" name="cancel" value="Cancel">
        </div>
      </div>
      <div style="padding: 2em; padding-top:0;">
      </div>
    </form>
        </div>
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
