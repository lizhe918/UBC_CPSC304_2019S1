<?php
    if (isset($_COOKIE['zyxwuser']) and isset($_COOKIE['zyxwpswd'])) {
        setcookie("zyxwuser", "", time() - 3600);
        setcookie("zyxwpswd", "", time() - 3600);
    }
    header("Location: index.html");
?>
