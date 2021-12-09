<?php

session_start();
if(!isset($_SESSION["user"]) AND !isset($_SESSION["admin"])) header("Location: ../login.php");

?>