<?php  session_start();
session_destroy(); header('Location: ../index.php');
//Destroy the current session and reroute to the index page to make a new connection ?>
