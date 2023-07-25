<?php
$servername = "localhost";
$username = "root";
$password = "Farh02postfa";
$dbname = "estimate_auto";

$db = mysqli_connect($servername, $username, $password, $dbname);
if (!$db) {
    die("Ошибка подключения к базе данных: " . mysqli_connect_error());
}
 ?>