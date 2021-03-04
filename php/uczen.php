<?php
session_start();

if(!isset($_SESSION['zalogowany']) || (isset($_SESSION['funkcja']) && $_SESSION['funkcja'] != 0))
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
    <ul class="blink-text-menu tab">
        <li class="tab-el">
            <a href="#profil">Profil</a>
        </li>
        <li class="tab-el">
            <a href="#plan">Plan</a>
        </li>
        <li class="tab-el">
            <a href="#Klasy">Klasy</a>
        </li>
		<li class="tab-el">
            <a href="procesWylogowania.php">Wyloguj</a>
        </li>

    </ul>
    </div>
<div class="tab-contents">
    <div class="tab-content" id="profil">
        <a class="close">✖</a>
        <img src="../img/avatar.png">
        <h1 class="profilText">
        <?php
            echo $_SESSION['imie']." ".$_SESSION['nazwisko'];
        ?>
        </h1>
    <p>
        <?php
        if(isset($_SESSION['idKlasy']))
         {
         echo 'Klasa: '.$_SESSION['idKlasy'];
        }else
        {
            echo '<p> Przejdź do zakładki Klasy aby dołączyć do klasy </p>';
        } 
        ?>
                
     </p>
    </div>

    <div class="tab-content" id="plan">
        <a class="close">✖</a>
        <table class="plan">
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

    <div class="tab-content" id="Klasy">
        <a class="close">✖</a>
        <p> 
        <?php 
            if(isset($_SESSION['klasa']))
             {
             echo $_SESSION['klasa'];
             }else
             {
             echo '<a href="#">Dołącz do klasy</a>';
             }
        ?>
        Dołączanie do klasy tutaj.
        <!-- PHP od wyświetlenia osób z klasy --> 
        </p>
    </div>
</div>
    <div id="stopka">
        PLAN LEKCJI &copy; Praktyka gr2
    </div>
    

</body>

</html>


