<?php
    $pdo=new PDO('mysql:host=mysql.practices.isaaczheli.com;dbname=zyxwstorage','lizhe1313','yxsy0102');

    if (isset($_POST['button2'])) {
        header("Location: index.html");
    }

    $name = "";
    $pswd = "";
    $message = false;

    if (isset($_POST['who']) and isset($_POST['password'])) {
        $name = $_POST['who'];
        $pswd =  $_POST['password'];

        if ($name == "" || $pswd == "") {
            $message = "User name and password are required";
        } else {
          $sql = "SELECT password FROM Customer WHERE username = '$name'";
          $stmt = $pdo->prepare($sql);
          $stmt->execute();
          $storedpswd = $stmt->fetch();
          if ($storedpswd['password'] == $pswd) {
            header("Location: RPS/game.php?name=".urlencode($_POST['who']));
          } else {
            $message = "Incorrect password";
          }
        }
      }
?>





<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="./css/login.css">
</head>
<body>
<ul>
  <li><a class="active" href="index.html">ZYXW Storage</a></li>
  <li><a href="index.html#Intro">About</a></li>
  <li><a href="index.html#contact">Contact</a></li>
  <li><a href="">Plans</a></li>
</ul>
<div style="height:100%; width:100%">
<form method="post">
  <h2 style="color: #002145;">CPSC304 Group 1 Project</h2>
  <h3 style="color: #002145;">Login to your storage:</h3>
  <p>User Name: <input type="text" name="who"></p>
  <p>Password: <input type="password" name="password"></p>
  <?php
      if ($message != false) {
        echo "<p style='color: red; font-weight: bold;'>$message</p>";
      }
  ?>
  <div>
  <input class="button" type="submit" name="button1" value="Log In">
  <input id = "cancel" class="button" type="submit" name="button2" value="Cancel">
  </div>
  <h4>OR</h4>
  <a href="">Forget your account?</a>
  <p></p>
    Not a member yet? <a href="">Sign Up!</a>
</form>
</div>
</body>
</html>
