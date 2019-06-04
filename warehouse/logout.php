<?php
    if (isset($_COOKIE['zyxwuser']) and isset($_COOKIE['zyxwpswd'])) {
        setcookie("zyxwuser", "", time() - 3600);
        setcookie("zyxwpswd", "", time() - 3600);
    } else if (isset($_COOKIE['zyxwmanager']) and isset($_COOKIE['zyxwmpswd'])) {
        setcookie("zyxwmanager", "", time() - 3600);
        setcookie("zyxwmpswd", "", time() - 3600);
    }
    header("Location: index.html");
?>
