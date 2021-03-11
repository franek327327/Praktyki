<?php
    session_start();
    require "polaczenieZBaza.php";

    if(!isset($_SESSION['zalogowany']) || (isset($_SESSION['funkcja']) && $_SESSION['funkcja'] != 0))
    {
        header('Location:../index.php');
        exit();
    } 
    if(isset($_SESSION['wiadomosc']))
    {

        ?>
        <script>alert(<?php echo '"'.$_SESSION['wiadomosc'].'"'?>)</script>
        <?php
        unset($_SESSION['wiadomosc']);
    }

    $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
    
    
    // Zaaktualizowanie danych z bazy danych w zmiennych sesyjnych
    if($rezultat = @$polaczenie->query("SELECT * FROM uzytkownicy WHERE id=".$_SESSION['id']))
        {
            $czyZnaleziono = $rezultat->num_rows;
            if($czyZnaleziono>0)
            {
                $wiersz = $rezultat->fetch_assoc();
                $_SESSION['login'] = $wiersz['login'];
                if($wiersz['IdKlasa'] != NULL)
                {
                    $_SESSION['jestKlasa'] = 1;
                }else if($wiersz['IdKlasa'] == NULL)
                {
                    unset($_SESSION['jestKlasa']);
                }
                $_SESSION['idKlasy'] = $wiersz['IdKlasa'];
                $_SESSION['email'] = $wiersz['email'];
                $_SESSION['imie'] = $wiersz['imie'];
                $_SESSION['nazwisko'] = $wiersz['nazwisko'];
                $_SESSION['funkcja'] = $wiersz['funkcja'];
                $_SESSION['adres'] = $wiersz['adres'];
                
                $rezultat->close();
            }
        }
    
    // Sprawdzanie czy użytkownik jest zalogowany i ma dobrą funkcję    
    if(!isset($_SESSION['zalogowany']) || (isset($_SESSION['funkcja']) && $_SESSION['funkcja'] != 0))
        {
            header('Location:../index.php');
            exit();
        } 
    // Zamiana id klasy na nazwę klasy
    if(isset($_SESSION['jestKlasa']))
        {

            $rezultat = $polaczenie->query("SELECT id, klasa FROM klasy");


            if ($rezultat->num_rows > 0) 
            {
                while($wierszKlas = $rezultat->fetch_assoc()) 
                {
                    
                        if($_SESSION['idKlasy'] == $wierszKlas['id'])
                        {
                            $_SESSION['klasa'] = $wierszKlas['klasa'];
                        }
                }
                $rezultat->close();
            }


        }else if (!isset($_SESSION['jestKlasa']))
        {
            $_SESSION['klasa'] = NULL;
        }

    




?>


<!DOCTYPE HTML>
<html lang="pl">

<head>
    <meta charset="utf-8" />
    <title>Uczeń</title>
    <link rel="stylesheet" href="../css/style1.css">
    <script src="../js/app1.js" defer></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="content-type" content="text/html; charset=ISO-8859-2">
    <link rel="preconnect" href="https://fonts.gstatic.com/%22%3E">
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=PT+Sans&display=swap" rel="stylesheet">
</head>

<body>


    <h1>Platforma Szkolna - Uczeń</h1>
  
   
    <div id="meni">
        <ul>
            <li class="tab-el"><a href="#profil">Profil</a></li>
            <li class="tab-el"><a href="planUczen.php">Plan</a></li>
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
             if(isset($_SESSION['idKlasy']))
                {
                    echo "<b>Klasa:</b> ".$_SESSION['klasa'];
                }
            else
                {       
                    echo 'Edytuj profil by dołączyć do klasy!';
                }
                echo "<br><br>";
                echo "<b>Email:</b> " . $_SESSION['email'];
                echo "<br><br>";
                echo "<b>Login:</b> " . $_SESSION['login'];
                echo "<br><br>";
                echo "<b>Adres:</b> " . $_SESSION['adres'];
                echo "<br><br>";
            ?>
            <form method="post" action="uczenAkcje.php">
            <input type="submit" name="edycjaDanych" value="Edytuj dane"></form>
            </h2>
        </div>
        
        <p> 
        <!-- Wyświetlanie klasy -->
       <?php

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

            unset($_POST['dolaczanie']);

        }
             
        ?>
        
        
  
       </p>
    </div>
    <div class="edytowanieDanych" style="display:none">
        <p>
        <form method="post" action="uczenAkcje.php">  
            
        <!-- Edytowanie danych użytkownika -->
        
        <div id="dane">
            <div class="tlo">
            <b>Klasa:</b>
            <select name="klasaEdit">
            <?php
            $rezultat = $polaczenie->query("SELECT id, klasa FROM klasy");
            if ($rezultat->num_rows > 0) 
            {
                while($wierszKlas = $rezultat->fetch_assoc()) 
                {
                    
                    echo '<option value="' .$wierszKlas['id']. '">' . $wierszKlas["klasa"] ."</option>";       
                }
                $rezultat->close();
            }
            ?>
            </select>
            <br>
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
        unset($_SESSION['edycjaDanych']);
        }
        
?>

