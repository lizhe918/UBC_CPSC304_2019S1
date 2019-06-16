<?php
    if (isset($_COOKIE['zyxwuser']) and isset($_COOKIE['zyxwpswd'])) {
        setcookie("zyxwuser", "", time() - 3600);
        setcookie("zyxwpswd", "", time() - 3600);
    } 

    if (isset($_COOKIE['zyxwmanager']) and isset($_COOKIE['zyxwmpswd'])) {
        setcookie("zyxwmanager", "", time() - 3600);
        setcookie("zyxwmpswd", "", time() - 3600);
    }
    
    if (isset($_COOKIE['zyxwdirector']) and isset($_COOKIE['zyxwdpswd'])) {
        setcookie("zyxwdirector", "", time() - 3600);
        setcookie("zyxwdpswd", "", time() - 3600);
    }
    
    if (isset($_COOKIE['zyxwworker']) and isset($_COOKIE['zyxwwpswd'])) {
        setcookie("zyxwworker", "", time() - 3600);
        setcookie("zyxwwpswd", "", time() - 3600);
    }
    
    header("Location: index.php");
?>
