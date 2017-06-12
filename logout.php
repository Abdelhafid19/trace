<?php
unset($_SESSION["login"]);
session_destroy();
header("location:login.php");
?>