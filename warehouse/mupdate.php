<?php
    require_once "pdo_constructor.php";
    $username = $_COOKIE['zyxwmanager'];
    $sql = "SELECT * FROM Manager WHERE username = '$username'";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $manager = $stmt->fetch(PDO::FETCH_ASSOC);

    $employID = $manager['employID'];
    $sql = "SELECT * FROM Employee WHERE employID = '$employID'";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $employee = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $firstName = "";
    $lastName = "";
    $SIN = "";
    $phoneN = "";
    $email = "";
    $address ="";


    $message = false;
    
    if (isset($_POST) & !empty($_POST)) {

        if (isset($_POST['fName']) and isset($_POST['lName']) and isset($_POST['SIN']) and isset($_POST['phoneNumber']) and isset($_POST['phoneNumber']) and isset($_POST['address']) and isset($_POST['emailaddress'])) {
            $firstName = $_POST['fName'];
            $lastName = $_POST['lName'];
            $SIN = $_POST['SIN'];
            $phoneN = $_POST['phoneNumber'];
            $email = $_POST['emailaddress'];
            $address = $_POST['address'];
        }

        if ($firstName=="" || $lastName=="" || $email=="" || $SIN == "" || $phoneN == ""|| $address =="") {
            $message = "Please Complete All Required fields";
        }else {
            // should insert
            $success = 1;
           
            //check uniqueness
            $sql = "SELECT * FROM Employee WHERE SINNum = '$SIN'";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            if ($stmt->rowCount() > 0){
                if (($stmt->rowCount() ==1) && ($SIN == $employee['SINNum'])){
 
                }else{
                    $message = "Social Insurance Number Already Exist";
                    $success = 0;
                }
            }

            $sql = "SELECT * FROM Employee WHERE phoneNum = '$phoneN'";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            if ($stmt->rowCount() > 0){
                if (($stmt->rowCount() ==1) && ($phoneN == $employee['phoneNum'])){
                    
                }else{
                $message = "Phone Number Already Exist";
                $success = 0;
                }
            }

            $sql = "SELECT * FROM Employee WHERE email = '$email'";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            if ($stmt->rowCount() > 0){
                if (($stmt->rowCount() ==1) && ($email == $employee['email'])){
                    
                }else{
                $message = "Email Already Exist";
                $success = 0;
                }
            }

            // update
            if ($success == 1){
            $sql = "UPDATE Employee SET lName ='$lastName' WHERE employID ='$employID'";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            
            $sql = "UPDATE Employee SET fName='$firstName' WHERE employID ='$employID'";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();

            $sql = "UPDATE Employee SET SINNum ='$SIN' WHERE   employID ='$employID'";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();

            $sql = "UPDATE Employee SET  phoneNum ='$phoneN' WHERE  employID ='$employID'";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();

            $sql = "UPDATE Employee SET  email ='$email' WHERE  employID ='$employID'";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();

            $sql = "UPDATE Employee SET  address ='$address' WHERE  employID ='$employID'";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();

            }
        }
    }
  ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manager Update</title>
    <link rel="stylesheet" href="./css/form.css">
    <link rel="stylesheet" href="./css/navbar.css">
    <link rel="stylesheet" type="text/css" href="./css/logout.css">
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
		<a href="./logout.php" id="logout">LOG OUT</a>
      <a href="javascript:void(0);" class="icon" onclick="mobileExpand()">
        <i class="fa fa-bars"></i>
      </a>
    </div>
    </div>
    <div class="form-container">
    <form method="post">
        <div class="form-content">
        <h2 style="color: #002145;">CPSC304 Group 1 Project</h2>
        <h3 style="color: #002145;">Update your ZYXW Storage Manager Account:</h3>
        <p>First Name*:<br>
            <input class="medium" type="text" name="fName" value = <?php echo $employee['fName']; ?>>
        </p>
        <p>Last Name*:<br>
            <input class="medium" type="text" name="lName" value = <?php echo $employee['lName']; ?>>
        </p>
        <p>Social Insurance Number*:<br>
            <input class="short" type="text" name="SIN" value=<?php echo $employee['SINNum'];?>
        </p>
        <p>Phone Number*:<br>
            <input class="short" type="text" name="phoneNumber" value = <?php echo $employee['phoneNum']; ?>>
        </p>
        <p>Email*:<br>
            <input class="medium" type="email" name="emailaddress" value = <?php echo $employee['email']; ?>>
        </p>
        <p>Address (street address, city, province, country, postal code)*:<br>
            <input class="long" type="text" name="address" 
                    value = "<?php echo $employee['address'] ?>">
        </p>

        <?php
            if ($message != false) {
                    echo "<p style='color: red; font-weight: bold;'>$message</p>";
                }
        ?>
        <div>
            <input class="button confirm" type="submit" name="signUp" value="Submit">
        </div>
        </div>
        <div style="padding: 2em; padding-top:0;">
        <h4 style="margin-top:0;">OR</h4>
        <a href="magrmt.php">Back</a>
        <p></p>
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
