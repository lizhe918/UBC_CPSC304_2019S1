<?php
    require_once "pdo_constructor.php";
    $username = $_COOKIE['zyxwuser'];
    $sql = "SELECT * FROM Customer WHERE username = '$username'";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $userOrigIDType = "";
    if(substr($user['IDNum'],0,4) == "STUD"){
        $userOrigIDType = "StudentID";
    }else if (substr($user['IDNum'],0,4) == "PSPT"){
        $userOrigIDType = "Passport";
    }else if (substr($user['IDNum'],0,4) == "DLCE"){
        $userOrigIDType = 'Dlicence';
    }
    
    $firstName = "";
    $lastName = "";
    $idType = "";
    $idNum = "";
    $phoneN = "";
    $address ="";
    $email = "";
    $message = false;
    
    if (isset($_POST) & !empty($_POST)) {

        if (isset($_POST['fName']) and isset($_POST['lName']) and isset($_POST['IDType']) and isset($_POST['IDNumber']) and isset($_POST['phoneNumber']) and isset($_POST['phoneNumber']) and isset($_POST['address']) and isset($_POST['emailaddress'])) {
            $firstName = $_POST['fName'];
            $lastName = $_POST['lName'];
            $idType = $_POST['IDType'];
            $idNum = $_POST['IDNumber'];
            $phoneN = $_POST['phoneNumber'];
            $address = $_POST['address'];
            $email = $_POST['emailaddress'];
        }

        if ($firstName==""  || $idType=="" || $idNum == "" || $phoneN == ""|| $address =="") {
            $message = "Please Complete All Required fields";
        }else {
            // should insert
            $success = 1;

            //check values

            if ($lastName == ""){
                $lastName = "NULL";
            }
            if ($email == ""){
                $email = "NULL";
            }
            if($idType == "StudentID"){
                $idNum = 'STUD' . $idNum;
            }else if ($idType == "Passport"){
                $idNum = 'PSPT' . $idNum;
            }else if ($idType == "Dlicence"){
                $idNum = 'DLCE' . $idNum;
            }

            //check uniqueness
            $sql = "SELECT * FROM Customer WHERE phoneNum = '$phoneN'";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            if ($stmt->rowCount() > 0){
                if (($stmt->rowCount() ==1) && ($phoneN == $user['phoneNum'])){
 
                }else{
                    $message = "Phone Number Already Exist";
                    $success = 0;
                }
            }
            if ($email != "NULL"){
                $sql = "SELECT * FROM Customer WHERE email = '$email'";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                if ($stmt->rowCount() > 0){
                    if (($stmt->rowCount() ==1) && ($email == $user['email'])){
                        
                    }else{
                    $message = "Email Already Exist";
                    $success = 0;
                    }
                }
            }

            // update
            if ($success == 1){
            $username = $user['username'];
            $sql = "UPDATE Customer SET lName ='$lastName' WHERE username ='$username'";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            
            $sql = "UPDATE Customer SET fName='$firstName' WHERE username ='$username'";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();

            $sql = "UPDATE Customer SET phoneNum ='$phoneN' WHERE  username ='$username'";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();

            $sql = "UPDATE Customer SET  address ='$address' WHERE  username ='$username'";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();

           
            $sql = "UPDATE Customer SET  IDNum ='$idNum' WHERE  username ='$username'";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            
            $sql = "UPDATE Customer SET  email ='$email' WHERE  username ='$username'";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            header("Location:citem.php");
            exit;
            }
        }
    }
  ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Customer Sign</title>
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
        <h3 style="color: #002145;">Update your ZYXW Storage Account:</h3>
        <p>First Name:<br>
            <input class="medium" type="text" name="fName" value = <?php echo $user['fName']; ?>>
        </p>
        <p>Last Name:<br>
            <input class="medium" type="text" name="lName" value = <?php echo $user['lName']; ?>>
        </p>
        <p>Phone Number:<br>
            <input class="short" type="text" name="phoneNumber" value = <?php echo $user['phoneNum']; ?>>
        </p>
        <p>Please Select One of the Following Identification: <br>
            <select class="short" style="height:4em" name="IDType">
                <option value="StudentID" selected = <?php if($userOrigIDType == 'StudentID') echo "selected" ?>>Student ID</option>
                <option value="Passport" selected = <?php if($userOrigIDType == 'Passort') echo "selected" ?>>Passport</option>
                <option value="Dlicence" selected = <?php if($userOrigIDType == 'Dlicence') echo "selected" ?>>Driver License</option>
            </select>
        </p>

        <p>ID Number (ie. Passport ID):<br>
            <input class="medium" type="text" name="IDNumber" value = <?php echo substr($user['IDNum'],4) ?>>
        </p>
        <p>Email:<br>
            <input class="medium" type="email" name="emailaddress" value = <?php echo $user['email']; ?>>
        </p>
        <p>Address (street address, city, province, country, postal code)*:<br>
            <input class="long" type="text" name="address" 
                    value = "<?php echo $user['address'] ?>">
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
        <a href="citem.php">back to profile page</a>
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
