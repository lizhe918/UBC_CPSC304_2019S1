<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ZYXW Storage</title>
    <link rel="stylesheet" href="./css/navbar.css">
    <link rel="stylesheet" href="./css/welcome.css">
    <link rel="stylesheet" href="./css/input_button.css">
    <link rel="stylesheet" href="./css/paragraph.css">
    <link rel="stylesheet" href="./css/table.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  </head>
  <body>
    <section class="navbar">
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
    </section>

    <section class="welcome" id="home">
      <div class="background" style="background-image: url('https://images.pexels.com/photos/544965/pexels-photo-544965.jpeg?cs=srgb&dl=adult-artisan-blueprint-544965.jpg&fm=jpg');"></div>
      <div class="greeting">
        <span class="title">Welcome</span>
        <p></p>
        <span class="subtitle">Greetings to all our employees</span>
        <p></p>
        <a class="linkbutton" href="./dlogin.php">Company Director</a>
        <a class="linkbutton" href="./mlogin.php">Branch Manager</a>
        <a class="linkbutton" href="./llogin.php">Storage Worker</a>
      </div>
    </section>

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
