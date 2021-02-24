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
</head>

<body>


    <h1>Platforma Szkolna - Uczeń</h1>
   <div id="Menu">
    <ul class="blink-text-menu">
        <li><a href="#profil">Profil</a></li>
        <li><a href="#Plan">Plan</a></li>
        <li><a href="#Klasa">Klasy</a></li>
		<li><a href="procesWylogowania.php">Wyloguj</a></li>

    </ul>
    </div>

    <div id="profil">
        <a id="closeProfil">&#10006;</a>
        <img src="../img/avatar.png">
        <h1 class="profilText">
        <?php
            echo $_SESSION['imie']." ".$_SESSION['nazwisko'];
        ?>
        </h1>
    </div>

    <div id="plan">
        <a id="closePlan">&#10016;</a>
        <table>
            <thead>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            </tbody>
        </table>
    </div>

    <div id="Klasy">
        <a id="closeKlasy">&#10006;</a>
        <p> Dane o Klasie tu będą</p>
    </div>
    <div id="stopka">
        PLAN LEKCJI &copy; Praktyka gr2
    </div>
    </div>
</body>

</html>


