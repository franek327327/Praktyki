<?php
session_start();

if(!isset($_SESSION['zalogowany']))
{
	header('Location:../index.php');
	exit();
}

?>


<!DOCTYPE HTML>
<html lang="pl">

<head>
    <meta charset="utf-8" />
    <title>plan lekcji</title>
    <link rel="stylesheet" href="../css/style1.css">
    <script src="../js/app1.js" defer></script>
    <meta http-equiv="content-type" content="text/html; charset=ISO-8859-2">
    <link rel="preconnect" href="https://fonts.gstatic.com/%22%3E">
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=PT+Sans&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@200;700&display=swap" rel="stylesheet">
</head>

<body>


    <h1>Platforma Szkolna - Nauczyciel</h1>

    

    <ul class="blink-text-menu">
        <li><a href="#" id="showProfil">Profil</a></li>
        <li><a href="#">Uczniowie</a></li>
        <li><a href="#">Klasy</a></li>
        <li><a href="#">Kalendarium</a></li>
        <li><a href="#">Słownik</a></li>
		<li><a href="procesWylogowania.php">Wyloguj</a></li>

    </ul>
    <div id="profil">
        <a id="closeProfil">x</a>
        <img src="../img/avatar.png">
        <h1 class="profilText">
            <?php
            echo $_SESSION['imie']." ".$_SESSION['nazwisko'];
            ?>
        </h1>
    </div>


    <div id="stopka">
        PLAN LEKCJI &copy; Praktyka gr2
    </div>
    </div>
</body>

</html>


