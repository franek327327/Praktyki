<?php
session_start();
require_once "polaczenieZBaza.php";
if(!isset($_SESSION['zalogowany']) || (isset($_SESSION['funkcja']) && $_SESSION['funkcja'] != 1))
{
	header('Location:../index.php');
	exit();
} 



$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
    
    // Zapisywanie danych z edycji do bazy danych
    
    // Zaaktualizowanie danych z bazy danych w zmiennych sesyjnych
    if($rezultat = @$polaczenie->query("SELECT * FROM uzytkownicy WHERE id=".$_SESSION['id']))
        {
            $czyZnaleziono = $rezultat->num_rows;
            if($czyZnaleziono>0)
            {
                $wiersz = $rezultat->fetch_assoc();
                $_SESSION['login'] = $wiersz['login'];
                $_SESSION['idKlasy'] = $wiersz['IdKlasa'];
                $_SESSION['email'] = $wiersz['email'];
                $_SESSION['imie'] = $wiersz['imie'];
                $_SESSION['nazwisko'] = $wiersz['nazwisko'];
                $_SESSION['funkcja'] = $wiersz['funkcja'];
                $_SESSION['adres'] = $wiersz['adres'];
                
                $rezultat->close();
            }
        }
    
    if(isset($_SESSION['wiadomosc']))
    {

        ?>
        <script>alert(<?php echo '"'.$_SESSION['wiadomosc'].'"'?>)</script>
        <?php
        unset($_SESSION['wiadomosc']);
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.gstatic.com/%22%3E">
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=PT+Sans&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@200;700&display=swap" rel="stylesheet">
</head>

<body>
<!--
<div class ="alert">
<span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
</div>
-->
    <h1>Platforma Szkolna - Nauczyciel</h1>

    <!--
<div id="menu">
    <ul class="blink-text-menu">
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
            <a href="planNauczyciel.php">Kalendarium</a>
        </li>
        <li class="tab-el">
            <a href="#lekcje">Lekcje</a>
        </li>
		<li class="tab-el">
            <a href="procesWylogowania.php">Wyloguj</a>
        </li>
    </ul>
</div>
-->

<div id="meni">

<ul>

  <li class="tab-el"><a href="#profil">Profil</a></li>
  <li class="tab-el"><a href="uczniowie.php">Uczniowie</a></li>
  <li class="tab-el"><a href="#klasy">Klasy</a></li>
  <li class="tab-el"><a href="planNauczyciel.php">Plan</a></li>
  <li class="tab-el"><a href="#lekcje">Przedmioty</a></li>
  <li class="tab-el"><a href="procesWylogowania.php">Wyloguj</a></li>
</ul>
    </div>
    
<div class="tab-contents">
    <a class="close">✖</a>
    <div class="tab-content" id="profil">
        <div id="login">
        
            <img src="../img/avatar.png">
            <div class="wyswietlanieDanych"><h2 class="profilText">
            <?php
                echo $_SESSION['imie']." ".$_SESSION['nazwisko'];
            ?>
            </h2>
            <?php  
                echo "<b>Email:</b> " . $_SESSION['email'];
                echo "<br><br>";
                echo "<b>Login:</b> " . $_SESSION['login'];
                echo "<br><br>";
                echo "<b>Adres:</b> " . $_SESSION['adres'];
                echo "<br><br>";
            ?>
            <form method="post" action="nauczycielAkcje.php">
        <input type="submit" name="edycjaDanych" value="Edytuj dane"></form>
            
        </div>
        
        <p> 
       <?php 
            
        ?>
        
        
  
       </p>
    </div>
    <div class="edytowanieDanych" style="display:none">
        <p>
        <form method="post" action="nauczycielAkcje.php">  
            
        <!-- Edytowanie Danych użytkownika -->
        
        <div id="dane">
            <div class="tlo">
            <b> Imie:</b> 
            <input type="text" value="<?php
                    if(isset($_SESSION['imie']))
                    {
                        echo $_SESSION['imie'];
                    }
            ?>" name="imieEdit">
            <br>
            <b>Nazwisko:</b>
            <input type="text" value="<?php
                    if(isset($_SESSION['nazwisko']))
                    {
                        echo $_SESSION['nazwisko'];
                    }
            ?>" name="nazwiskoEdit">
            <br>
            <b>Adres:</b>
            <input type="text" value="<?php
                    if(isset($_SESSION['adres']))
                    {
                        echo $_SESSION['adres'];
                    }
            ?>" name="adresEdit">
                <?php
                    if(isset($_SESSION['error_Ina']))
                        {
                            echo '<div class="error">'.$_SESSION['error_Ina'].'</div>';
                            unset($_SESSION['error_Ina']);
                        }
                ?>
            <br>
            <b>Email:</b>
            <input type="email" value="<?php
                    if(isset($_SESSION['email']))
                    {
                        echo $_SESSION['email'];
                    }
            ?>" name="emailEdit">
            <?php
                    if(isset($_SESSION['error_email']))
                        {
                            echo '<div class="error">'.$_SESSION['error_email'].'</div>';
                            unset($_SESSION['error_email']);
                        }
                ?>
            <br>
                    <b> Login:</b>
            <input type="text" value="<?php
                    if(isset($_SESSION['login']))
                    {
                        echo $_SESSION['login'];
                    }
            ?>" name="loginEdit">
                <?php
                    if(isset($_SESSION['error_login']))
                        {
                            echo '<div class="error">'.$_SESSION['error_login'].'</div>';
                            unset($_SESSION['error_login']);
                        }
                ?>
            <br>
            
                    <b>Haslo:</b>
            <input type="password"  name="hasloEdit">
            <?php
                    if(isset($_SESSION['error_haslo']))
                        {
                            echo '<div class="error">'.$_SESSION['error_haslo'].'</div>';
                            unset($_SESSION['error_haslo']);
                        }
                ?>
            <br>
            <u> <input type="submit" name="zapisz" value="Zapisz!"></u>
                    </div>
            </form>
            </p>
            </div>
        </div>
    </div>
            
    <div class="tab-content" id="lekcje">
        <!-- Usuwanie i wyświetlanie przedmiotów-->
        <div class="wyswietlanie">
        <h3>Dodaj Przedmiot</h3>
            <?php
                $przedmioty = "SELECT id, przedmiot FROM slownik";

                $rezultat = $polaczenie->query($przedmioty);

                if ($rezultat->num_rows > 0) {
                    $petla=0;
                    while($wiersz = $rezultat->fetch_assoc()) {
                        $petla++;
                        echo $petla. ". " . $wiersz["przedmiot"]."<form style = 'display: inline;' method = 'post' action = 'nauczycielAkcje.php'> <button name = 'usuwaniePrzedmiotu' type = 'submit' value = '". $wiersz['id'] ."'>" . "Usun</button> </form>" . "
                        <form style = 'display: inline;' method = 'post' action = 'nauczycielAkcje.php'> 
                        <input type='hidden' name='nazwaPrzedmiotu' value='".$wiersz['przedmiot']."'/>
                        <button name = 'edytowaniePrzedmiotu' type = 'submit' value = '". $wiersz['id'] ."'>" . "Edytuj</button> </form>" . "<br>";
                    }
                    $rezultat->close();
                }
                if(isset($_SESSION['przedmioty']))
                {
                    ?>
                    <script>
                    alert(<?php echo '"'.$_SESSION["przedmioty"].'"'; ?>);
                    </script>
                    <?php
                    unset($_SESSION['przedmioty']);
                }
            ?>
        </div>
        <!-- Dodawanie przedmiotów -->
        <form class="dodaj" method="post" action="nauczycielAkcje.php">
        
        <input type="text" name="dodawanyPrzedmiot">
        <input type="submit" name="dodawaniePrzedmiotu" value="Dodaj przedmiot!">
        </form>
    </div>
    <div class="tab-content" id="klasy">
        <!-- Usuwanie i wyświetlanie klas-->
        <div class="wyswietlanie">
        <?php
            $klasy = "SELECT id, klasa FROM klasy";

            $rezultat = $polaczenie->query($klasy);

            if ($rezultat->num_rows > 0) {
                $petla = 0;
                while($wiersz = $rezultat->fetch_assoc()) {
                    $petla++;
                    echo $petla . ". " . $wiersz["klasa"]."<form style = 'display: inline;' method = 'post' action = 'nauczycielAkcje.php'> <button name = 'usuwanieKlasy' type = 'submit' value = '". $wiersz['id'] ."'>" . "Usun</button> </form>
                    <form style = 'display: inline;' method = 'post' action = 'nauczycielAkcje.php'> 
                    <input type='hidden' name='nazwaKlasy' value='".$wiersz['klasa']."'/>
                    <button name = 'edytowanieKlasy' type = 'submit' value = '". $wiersz['id'] ."'>" . "Edytuj</button> </form>" . "<br>";
                }
                $rezultat->close();
            }
            if(isset($_SESSION['klasy']))
            {
                ?>
                    <script>
                    alert(<?php echo '"'.$_SESSION["klasy"].'"'; ?>);
                    </script>
                    <?php
                unset($_SESSION['klasy']);
            }
        ?>
        
        </div>
        <!-- Dodawanie klasy -->
        
        <form class="dodaj" method="post" action="nauczycielAkcje.php">
        <input  type="text" name="dodawanaKlasa">
        <input  type="submit" name="dodawanieKlasy" value="Dodaj klasę!">
        </form>
        
    </div>
</div>

    <div id="stopka">
        PLAN LEKCJI &copy; Praktyka gr2
    </div>
    
</body>

</html>
<?php
    $polaczenie->close();
    if(isset($_SESSION['edycjaDanych']))
        {
        
        echo
        '<script type="text/JavaScript">
        const okno = document.querySelector(".tab-contents");
        const profil = document.querySelector("#profil");
        const wyswietlanie = document.querySelector(".wyswietlanieDanych");
        const edytowanie = document.querySelector(".edytowanieDanych");
        okno.classList.add("profilAnim");
        okno.style.display = "block";
        profil.classList.add("tab-content-active");
        wyswietlanie.style.display = "none";
        edytowanie.style.display = "block";
        
        </script>';
        }
        unset($_SESSION['edycjaDanych']);
?>

