<?php
    if (isset($_POST['button2'])) {
        header("Location: index.html");
    }

    $name = "";
    $pswd = "";
    $message = false;

    if (isset($_POST['who']) and isset($_POST['password'])) {
        $name = $_POST['who'];
        $pswd =  $_POST['password'];


        $salt = 'XyZzy12*_';
        $stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1';
        $md5 = hash('md5', $salt . $pswd);

        if ($name == "" || $pswd == "") {
            $message = "User name and password are required";
        } else if ($md5 === $stored_hash) {
            header("Location: RPS/game.php?name=".urlencode($_POST['who']));
        } else {
            $message = "Incorrect password";
        }
    }

?>





<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {
  margin: 0;
  font-family: Arial, Helvetica, sans-serif;
}

ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
  overflow: auto;
  background-color: #ddd;
  position: relative;
  top: 0;
  opacity: 1;
  width: 100%;
  display:block;
}

li {
  float: left;
}

li a {
  display: block;
  background-color: #ddd;
  color: #002145;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  transition-duration: 0.4s;
  width: auto;
  font-weight: bold;
}

li a:hover:not(.active) {
  background-color: white;
  text-decoration: underline;
}

li a.active {
  color: white;
  background-color: #002145;
}

input[type=text], input[type=password] {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  box-sizing: border-box;
}

form {
  width: 360px;
  position: relative;
  /*top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);*/
  margin-left:auto;
  margin-right: auto;
  margin-top: 10em;
  
}

.button {
  background-color: #002145;
  border: #002145;
  color: white;
  padding: 1em;
  margin-bottom: 1em;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  width: 100px;
  transition-duration: 0.4s;
}

.button:hover {
  background-color: #0055B7;
  color: white;
}

#cancel:hover {
  background-color: red;
  color: white;
}



</style>
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