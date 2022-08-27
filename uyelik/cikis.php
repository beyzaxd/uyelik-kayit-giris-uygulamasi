<?php

session_start();

$_SESSION=array();//session'ın içini boşalttım
session_destroy();
header("location:login.php");



?>