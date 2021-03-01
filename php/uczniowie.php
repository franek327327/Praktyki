<?php
session_start();

if(!isset($_SESSION['zalogowany']) || (isset($_SESSION['funkcja']) && $_SESSION['funkcja'] != 1))
{
	header('Location:../index.php');
	exit();
} 

?> 

<!DOCTYPE HTML>
<html lang="pl">

<head>
    <meta charset="utf-8" />
    <title>Nauczyciel - Uczniowie</title>
    <link rel="stylesheet" href="../css/style1.css">
    <script src="../js/app1.js" defer></script>
    <meta http-equiv="content-type" content="text/html; charset=ISO-8859-2">
    <link rel="preconnect" href="https://fonts.gstatic.com/%22%3E">
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=PT+Sans&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@200;700&display=swap" rel="stylesheet">
</head>

<body>


    <h1>Platforma Szkolna - Nauczyciel - uczniowie</h1>
    

</body>
</html>   


