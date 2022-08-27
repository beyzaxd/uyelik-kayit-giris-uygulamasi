<?php

$host="localhost";
$kullanici="root";
$parola="";
$vt="uyelik";

$baglanti= mysqli_connect($host, $kullanici, $parola, $vt); //veri tabanına bağlandığım sorgu
mysqli_set_charset($baglanti, "UTF8");


?>