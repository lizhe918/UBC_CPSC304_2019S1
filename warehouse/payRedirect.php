

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Redirecting</title>
    <link rel="stylesheet" href="./css/form.css">
    <link rel="stylesheet" href="./css/navbar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  </head>
  <body>
      <div align="middle" style="position: absolute; top: 40%; left: 46%; z-index: 15; margin: -100px 0 0 -150px;">
        <img src = "images/loading.gif" height='300em' alt="loading">
        <p>Redirecting You To Home Page</p>
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

<?php

    header("Refresh: 1.5; URL=index.php");
    exit;
  
?>