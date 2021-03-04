<?php
session_start();

if(!isset($_SESSION['zalogowany']) || (isset($_SESSION['funkcja']) && $_SESSION['funkcja'] != 0))
{
	header('Location:../index.php');
	exit();
} 
// Zamiana id klasy na nazwę klasy
if(isset($_SESSION['idKlasy']))
{
    require_once "polaczenieZBaza.php";

    $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);

    $rezultatKlas = $polaczenie->query("SELECT id, klasa FROM klasy");


    if ($rezultatKlas->num_rows > 0) 
    {
        while($wierszKlas = $rezultatKlas->fetch_assoc()) 
        {
            
            if($_SESSION['idKlasy'] == $wierszKlas['id'])
            {
                $_SESSION['klasa'] = $wierszKlas['klasa'];
            }
        }
    }


    $polaczenie->close();
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
        if(isset($_SESSION['klasa']))
         {
         echo 'Klasa: '.$_SESSION['klasa'];
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

<!-- Dodawanie do istniejącej klasy -->

    <div class="tab-content" id="Klasy">
        <a class="close">✖</a>
        <p> 
       
        <?php 
        
        require_once "polaczenieZBaza.php";

        $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);

        if(isset($_SESSION['klasa']))
            {
            echo "Klasa: ".$_SESSION['klasa'];
            }
        else
            {
                
                echo '<form method="post" action="uczen.php">';
                echo '<select name="dodanieDoKlasy">';
                
                

                $rezultatKlas = $polaczenie->query("SELECT id, klasa FROM klasy");
                if ($rezultatKlas->num_rows > 0) 
                {
                    while($wierszKlas = $rezultatKlas->fetch_assoc()) 
                    {
                        
                        echo '<option value="' .$wierszKlas['id']. '">' . $wierszKlas["klasa"] ."</option>";        //Rozwijany
                    }
                }
                echo "</select>";
                echo '<input type="submit" name="dolaczanie" value="Dołącz do klasy!"></form>';       //Przycisk
            }



        if(isset($_POST['dolaczanie']))
        {

            if($polaczenie->query("UPDATE uzytkownicy SET IdKlasa=".$_POST['dodanieDoKlasy']." WHERE id=".$_SESSION['id']))
            {
                $_SESSION['idKlasy'] = $_POST['dodanieDoKlasy'];
                header("Refresh:0");
                        
            }else
            {
                echo $_POST['dodanieDoKlasy'];
            }

            unset($_POST);

        }
        
        $polaczenie->close();
        ?>
        
        
        <!-- PHP od wyświetlenia osób z klasy --> 
        </p>
    </div>
</div>
    <div id="stopka">
        PLAN LEKCJI &copy; Praktyka gr2
    </div>
    

</body>

</html>


