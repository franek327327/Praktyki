<?php
session_start();
require_once "polaczenieZBaza.php";

$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);

$sql = 'SELECT * FROM plan';
$wynik = mysqli_query($polaczenie, $sql);
$plan = mysqli_fetch_all($wynik, MYSQLI_ASSOC);
print_r($plan);

mysqli_free_result($wynik);
$polaczenie->close();
?>