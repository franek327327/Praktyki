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
    <title>Nauczyciel</title>
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

    
<div id="menu">
    <ul class="blink-text-menu tab">
        <li class="tab-el">
            <a href="#profil">Profil</a>
        </li>
        <li class="tab-el">
            <a href="uczniowie.php">Uczniowie</a>
        </li>
        <li class="tab-el">
            <a href="#klasy">Klasy</a>
        </li>
        <li class="tab-el">
            <a href="#plan">Kalendarium</a>
        </li>
        <li class="tab-el">
            <a href="#lekcje">Lekcje</a>
        </li>
		<li class="tab-el">
            <a href="procesWylogowania.php">Wyloguj</a>
        </li>
    </ul>
</div>

    
<div class="tab-contents">
<a class="close">✖</a>

    <div class="tab-content" id="profil">
   <div id="login">
        <img src="../img/avatar.png">
         <h2 class="profilText">
             <?php
             echo $_SESSION['imie']." ".$_SESSION['nazwisko'];
            ?>
        </h2>
        </div>
        <p> 
        <?php
        echo $_SESSION['email'];
        echo "<br><br>";
        echo $_SESSION['login'];
        ?>
        </p>
        <br><br>
                <p><a href="#">Edytuj profil</a></p>
    </div>
        
    <div class="tab-content" id="plan">
       
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

       
        <div class="tab-content" id="lekcje">
               
                <div>
                <!-- tutaj php od wyświetlania LISTY lekcji -->
                </div>
        </div>
</div>          

    <div id="stopka">
        PLAN LEKCJI &copy; Praktyka gr2
    </div>
    
</body>

</html>


