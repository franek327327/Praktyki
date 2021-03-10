<head>
    <meta charset="utf-8" />
    <title>Nauczyciel - Edycja</title>
    <link rel="stylesheet" href="../css/style1.css">
    <script src="../js/app1.js" defer></script>
    <meta http-equiv="content-type" content="text/html; charset=ISO-8859-2">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<?php
session_start();
require "polaczenieZBaza.php";


// Dodawanie Lekcji
if(isset($_POST['dodawanie']))
{
                $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
                unset($_POST['dodawanie']);

                $czyMoznaWyslac = true;
            
                    $dodawanieLekcji=
                    "INSERT INTO plan (IdPrzedmiot, IdKlasa, IdDzien, IdGodzinaLekcyjna, IdSala, IdNauczyciel)
                    VALUES ('".$_POST['przedmiot']."', '".$_POST['klasa']."', '".$_POST['dzien']."', '".$_POST['godzina']."', '".$_POST['sala']."', '".$_POST['imieinazwisko']."')";

                    $sprawdzanieLekcji=
                    "SELECT idDzien, idGodzinaLekcyjna, idKlasa, IdNauczyciel
                    FROM plan
                    ";

                    $rezultatSprawdzania = $polaczenie->query($sprawdzanieLekcji);

                    // Sprawdzanie czy lekcja na daną godzinę danego dnia już istnieje dla klasy

                    if ($rezultatSprawdzania->num_rows > 0) 
                    {
                    while($wiersz = $rezultatSprawdzania->fetch_assoc()) 
                        {
                            if(($wiersz['idDzien'] == $_POST['dzien'] && $wiersz['idGodzinaLekcyjna'] == $_POST['godzina'] && $wiersz['idKlasa'] == $_POST['klasa']) || ($wiersz['idDzien'] == $_POST['dzien'] && $wiersz['idGodzinaLekcyjna'] == $_POST['godzina'] && $wiersz['IdNauczyciel'] == $_POST['imieinazwisko']))
                            {
                                $czyMoznaWyslac = false;
                            }
                        }
                    }

                    if($czyMoznaWyslac)
                {
                        if($polaczenie->query($dodawanieLekcji))
                        {
                            $_SESSION['wiadomoscDodawania'] = "Udało się dodać lekcję!";
                            $polaczenie->close();
                            header("Location:planNauczyciel.php");
                            
                        }else
                        {
                            $_SESSION['wiadomoscDodawania'] = "Nie udało się dodać lekcji!";
                            $polaczenie->close();
                            header("Location:planNauczyciel.php");
                        }
                }
                    else if(!$czyMoznaWyslac)
                {
                    $_SESSION['wiadomoscDodawania'] = "Podana lekcja już istnieje!";
                    $polaczenie->close();
                    header("Location:planNauczyciel.php");
                }	
}

// Usuwanie przedmiotu
else if(isset($_POST['usuwaniePrzedmiotu']))
{
    
    $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);

    $usuwanie = "DELETE FROM slownik WHERE id=".$_POST['usuwaniePrzedmiotu'];

    if ($polaczenie->query($usuwanie) === TRUE) {
        $_SESSION['przedmioty'] = "Usunięto przedmiot!";
        $polaczenie->close();
        unset($_POST['usuwaniePrzedmiotu']);
        header("Location:nauczyciel.php");
    } else {
        $_SESSION['przedmioty'] = "Ten przedmiot jest już używany w planie lekcji!";
        $polaczenie->close();
        unset($_POST['usuwaniePrzedmiotu']);
        header("Location:nauczyciel.php");
    }


}

// Dodawanie przedmiotu
else if(isset($_POST['dodawaniePrzedmiotu']))
{
    $czyMoznaWyslac = true;
    unset($_POST['dodawaniePrzedmiotu']);
    $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
    $dodawanie = "INSERT INTO slownik (przedmiot) VALUES ('".$_POST['dodawanyPrzedmiot']."')";
    $sprawdzanie = "SELECT id, przedmiot FROM slownik WHERE przedmiot=".$_POST['dodawanyPrzedmiot'];
    $rezultat = $polaczenie->query($sprawdzanie);
    
    if(strlen($_POST['dodawanyPrzedmiot']) == 0)
    {
            $czyMoznaWyslac=false;
            $_SESSION['przedmioty']="Nie wpisano przedmiotu!";
            $polaczenie->close();
            header("Location:nauczyciel.php");
    }
    if($rezultat->num_rows > 0)
        {
            $czyMoznaWyslac = false;
            $_SESSION['przedmioty'] = "Podany przedmiot jest już w bazie danych!";
            $polaczenie->close();
            header("Location:nauczyciel.php");
        }
    

    if($czyMoznaWyslac)
    {
        if ($polaczenie->query($dodawanie) === TRUE) {
            $_SESSION['przedmioty']="Dodano przedmiot!";
            $polaczenie->close();
            header("Location:nauczyciel.php");
          } else {
            $_SESSION['przedmioty']="Nie udało się dodać przedmiotu!";
            $polaczenie->close();
            header("Location:nauczyciel.php");
          }
    }



}

// Usuwanie klasy
elseif(isset($_POST['usuwanieKlasy']))
{
    $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);

    $usuwanie = "DELETE FROM klasy WHERE id=".$_POST['usuwanieKlasy'];

    if ($polaczenie->query($usuwanie) === TRUE) {
        $_SESSION['klasy'] = "Usunięto klasę!";
        $polaczenie->close();
        unset($_POST['usuwaniePrzedmiotu']);
        header("Location:nauczyciel.php");
    } else {
        $_SESSION['klasy'] = "Ta klasa jest używana w planie!";
        $polaczenie->close();
        unset($_POST['usuwaniePrzedmiotu']);
        header("Location:nauczyciel.php");
    }

}

// Dodawanie klasy
else if(isset($_POST['dodawanieKlasy']))
{
    $czyMoznaWyslac = true;
    unset($_POST['dodawanieKlasy']);
    $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
    $dodawanie = "INSERT INTO klasy (klasa) VALUES ('".$_POST['dodawanaKlasa']."')";
    $sprawdzanie = "SELECT id, klasa FROM klasy WHERE klasa=".$_POST['dodawanaKlasa'];
    $rezultat = $polaczenie->query($sprawdzanie);
    
    if(strlen($_POST['dodawanaKlasa']) == 0)
    {
            $czyMoznaWyslac=false;
            $_SESSION['klasy']="Nie wpisano klasy!";
            $polaczenie->close();
            header("Location:nauczyciel.php");
    }
    if($rezultat->num_rows > 0)
        {
            $czyMoznaWyslac = false;
            $_SESSION['klasy'] = "Podana klasa jest już w bazie danych!";
            $polaczenie->close();
            header("Location:nauczyciel.php");
        }
    

    if($czyMoznaWyslac)
    {
        if ($polaczenie->query($dodawanie) === TRUE) {
            $_SESSION['klasy']="Dodano klasę!";
            $polaczenie->close();
            header("Location:nauczyciel.php");
          } else {
            $_SESSION['klasy']="Nie udało się dodać klasy!";
            $polaczenie->close();
            header("Location:nauczyciel.php");
          }
    }



}
   
// Edytowanie lekcji
else if(isset($_POST['edycjaLekcji']))
{
    $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
    $przedmiot = "SELECT id, przedmiot FROM slownik";
             $klasa = "SELECT id, klasa FROM klasy";
             $dzien = "SELECT id, dzien FROM dni";
             $godzina = "SELECT id, godzina FROM godzinylekcyjne";
             $sala = "SELECT id, sala FROM sale";
             $nauczyciel = "SELECT id, imie, nazwisko, funkcja FROM uzytkownicy WHERE funkcja = 1";
             $_SESSION['idLekcji'] = $_POST['id'];
             
             $rezultat1 = $polaczenie->query($przedmiot);
             $rezultat2 = $polaczenie->query($klasa);
             $rezultat3 = $polaczenie->query($sala);
             $rezultat4 = $polaczenie->query($nauczyciel);
                   
             echo "Edycja lekcji ".$_POST['lekcja']. ". <br>Dzień: ".$_POST['dzien'];
             echo '<form method="post" action=""> <select name="przedmiot">';
             if ($rezultat1->num_rows > 0) 
                 {
                     while($wiersz = $rezultat1->fetch_assoc()) 
                     {
                         if($wiersz['przedmiot'] == $_POST['przedmiot'])
                         {
                         echo '<option value="' . $wiersz["id"] . '" selected>' . $wiersz["przedmiot"] . "</option>";
                         }else
                         {
                            echo '<option value="' . $wiersz["id"] . '">' . $wiersz["przedmiot"] . "</option>"; 
                         }
                     }
                 }
             echo '</select><select name="klasa">';
             if ($rezultat2->num_rows > 0) 
                 {
                     while($wiersz = $rezultat2->fetch_assoc()) 
                     {
                        if($wiersz['klasa'] == $_POST['klasa'])
                         {
                         echo '<option value="' . $wiersz["id"] . '" selected>' . $wiersz["klasa"] . "</option>";
                         }else
                         {
                            echo '<option value="' . $wiersz["id"] . '">' . $wiersz["klasa"] . "</option>"; 
                         }
                    }
                 }
             echo '</select><select name="sala">';
             if ($rezultat3->num_rows > 0) 
                 {
                     while($wiersz = $rezultat3->fetch_assoc()) 
                         {
                            if($wiersz['sala'] == $_POST['sala'])
                            {
                            echo '<option value="' . $wiersz["id"] . '" selected>' . $wiersz["sala"] . "</option>";
                            }else
                            {
                               echo '<option value="' . $wiersz["id"] . '">' . $wiersz["sala"] . "</option>"; 
                            }
                         }
                 }
             echo '</select><select name="imieinazwisko">';
             if ($rezultat4->num_rows > 0) 
                 {
                     while($wiersz = $rezultat4->fetch_assoc()) 
                         {
                            if($wiersz['imie'] == $_POST['imie'] && $wiersz['nazwisko'] == $_POST['nazwisko'])
                            {
                            echo '<option value="' . $wiersz["id"] . '" selected>' . $wiersz["imie"] . " " . $wiersz["nazwisko"] . "</option>";
                            }else
                            {
                               echo '<option value="' . $wiersz["id"] . '">' . $wiersz["imie"] . " " . $wiersz["nazwisko"] . "</option>"; 
                            }
                 }
             echo '<br>';
             echo '<input type="submit" name="aktualizacjaLekcji" value="Zapisz zmiany!">';
             echo '<input type="submit" name="usuniecieLekcji" value="Usuń lekcję!">';
             echo "</form>";  
             ?>
            <button onclick="location.href='plannauczyciel.php'">powrót</button>
            <?php 

            }
}
// Aktualizacja lekcji po edycji
else if(isset($_POST['aktualizacjaLekcji']))
{
    $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
    $zapytanie ="UPDATE plan SET IdPrzedmiot='".$_POST['przedmiot']."', IdKlasa='".$_POST['klasa']."', IdSala='".$_POST['sala']."', IdNauczyciel='".$_POST['imieinazwisko']."' WHERE id=".$_SESSION['idLekcji'];
    unset($_SESSION['idLekcji']);
    if ($polaczenie->query($zapytanie) === TRUE) {
        $_SESSION['wiadomoscDodawania'] = "Poprawanie zaaktualizowano lekcję!";
        $polaczenie->close();
        header("Location:planNauczyciel.php");
      } else {
        $_SESSION['wiadomoscDodawania'] = "Nie udało się zaaktualizować lekcji!";
        $polaczenie->close();
        header("Location:planNauczyciel.php");
      }
}
//Usunięcie lekcji
else if(isset($_POST['usuniecieLekcji']))
{
    $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
    $usuwanie = "DELETE FROM plan WHERE id=".$_SESSION['idLekcji'];
    unset($_SESSION['idLekcji']);
    if ($polaczenie->query($usuwanie) === TRUE) {
        $_SESSION['wiadomoscDodawania'] = "Poprawanie usunięto lekcję!";
        $polaczenie->close();
        header("Location:planNauczyciel.php");
      } else {
        $_SESSION['wiadomoscDodawania'] = "Nie udało się usunąć lekcji!";
        $polaczenie->close();
        header("Location:planNauczyciel.php");
      }

}
//edytowanie klasy
else if(isset($_POST['edytowanieKlasy']))
{
    $_SESSION["nazwaKlasy"] = $_POST["nazwaKlasy"];
    echo '<form method="post" action="nauczycielAkcje.php">';
    echo '<input type="text" name="zmianaKlasy" value="'.$_SESSION['nazwaKlasy'].'">';
    echo '<input type="submit" name="edytuj" value="edytuj klase">';
    echo "</form>";
    $_SESSION["KlasaID"]=$_POST["edytowanieKlasy"];
    ?>
    <button onclick="location.href='nauczyciel.php'">powrót</button>
    <?php 
   
}  
elseif(isset($_POST["zmianaKlasy"]))
{
    if($_POST["nazwaKlasy"]  == "")
    {
        $_POST["nazwaKlasy"] = $_SESSION["nazwaKlasy"];
    }
    $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
    
    
    $update = "UPDATE klasy SET klasa ='" .$_POST['zmianaKlasy']. "' WHERE id=" .$_SESSION['KlasaID'];
    if ($polaczenie->query($update) == TRUE) 
    {
        $_SESSION['klasy'] = "Udało się zmienić nazwę klasy!";
        $polaczenie->close();
        header("Location:nauczyciel.php");
    }
    else
    {
        $_SESSION['klasy'] = "Nie udało się zmienić nazwy klasy!";
        $polaczenie->close();
        header("Location:nauczyciel.php");
    }
    

}
//edytowanie przedmiotu
else if(isset($_POST['edytowaniePrzedmiotu']))
{
    echo '<form method="post" action="nauczycielAkcje.php">';
    echo '<input type="text" name="zmianaPrzedmiotu" value="'.$_POST['nazwaPrzedmiotu'].'">';
    echo '<input type="submit" name="edytuj" value="Zapisz!">';
    echo "</form>";
    $_SESSION["PrzedmiotID"]=$_POST["edytowaniePrzedmiotu"];
    ?>
    <button onclick="location.href='nauczyciel.php'">powrót</button>
    <?php 
   
}  
elseif(isset($_POST["zmianaPrzedmiotu"]))
{
    $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
    
    
    $update = "UPDATE slownik SET przedmiot ='" .$_POST['zmianaPrzedmiotu']. "' WHERE id=" .$_SESSION['PrzedmiotID'];
    if ($polaczenie->query($update) == TRUE) 
    {
        $_SESSION['przedmioty'] = "Udało się zmienić nazwę przedmiotu!";
        $polaczenie->close();
        header("Location:nauczyciel.php");
    }
    else
    {
        $_SESSION['wiadomoscDodawania'] = "Nie udało się zmienić nazwy przedmiotu!";
        $polaczenie->close();
        header("Location:nauczyciel.php");
    }

}
//Edycja profilu
else if(isset($_POST['edycjaDanych']))
{
    $_SESSION['edycjaDanych'] = 1;
    header("Location:nauczyciel.php");
}
// Zapisywanie danych z edycji profilu do bazy danych
else if (isset($_POST['zapisz']))
{
        $ok = true;
        $imie=$_POST['imieEdit'];
        $nazwisko=$_POST['nazwiskoEdit'];
        $login=$_POST['loginEdit'];
        $email=$_POST['emailEdit'];
        $haslo=$_POST['hasloEdit'];
        $adres=$_POST['adresEdit'];

        //walidacja imienia, nazwiska i adresu
        if(strlen($imie) < 1 || strlen($nazwisko) < 1 || strlen($adres) < 1)
            {
                $ok=false;
                $_SESSION['error_Ina']="Nie wpisano imienia, nazwiska lub adresu";
            }

        //walidacja loginu	
        if (ctype_alnum($login)==false)
            {
                $ok=false;
                $_SESSION['error_login']="Login może się składać tylko z cyfr i liter (bez polskich znaków)";
            }
        
        if((strlen($login)<1) || (strlen($login)>50))
            {
                $ok=false;
                $_SESSION["error_login"]="Nie wpisano loginu lub login ma więcej niż 50 znaków";
            }
        
        //walidacja emaila	
        if(strlen($email)<1)
            {
                $ok=false;
                $_SESSION['error_email']="Nie podano emaila";
            }

        $emailVal = filter_var($email, FILTER_SANITIZE_EMAIL);
        //walidacja hasla
        if(strlen($haslo)==0)
            {
                $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
                $rezultat = $polaczenie->query("SELECT haslo FROM uzytkownicy WHERE id=".$_SESSION['id']);
                $czyZnaleziono = $rezultat->num_rows;
                if($czyZnaleziono>0)
                {   
                    $wiersz = $rezultat->fetch_assoc();
                    $haslo=$wiersz['haslo'];
                }
                $rezultat->close();
                $polaczenie->close();
            }
        else if(strlen($haslo)<5 || (strlen($haslo)>50))
            {
                {
                    $ok=false;
                    $_SESSION["error_haslo"]="Hasło musi zawierać od 5 do 50 znaków";
                }

            }

        require_once "polaczenieZBaza.php";
        mysqli_report(MYSQLI_REPORT_STRICT);     
            try
                {
                    $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
                    if($polaczenie->connect_errno!=0)
                    {
                        throw new Exception(mysqli_connect_errno());
                    }
                    else
                    {
                        //Czy mail istnieje
                        $rezultat = $polaczenie->query("SELECT id FROM uzytkownicy WHERE email='$email' AND id <> ".$_SESSION['id']);
                        if(!$rezultat) throw new Exception($polaczenie->error);
                        
                        $ileMaili = $rezultat->num_rows;
                        if($ileMaili>0)
                        {
                            $ok=false;
                            $_SESSION['error_email']="Podany email już istnieje w bazie";
                        }
                        $rezultat->close();
                        
                        //czy login istnieje
                        $rezultat = $polaczenie->query("SELECT id FROM uzytkownicy WHERE BINARY login='$login' AND id <> ".$_SESSION['id']);
                        if(!$rezultat) throw new Exception($polaczenie->error);
                        
                        $ileLogin = $rezultat->num_rows;
                        if($ileLogin>0)
                        {
                            $ok=false;
                            $_SESSION['error_login']="Podany login już istnieje w bazie";
                        }
                        if($ok==true)
                        {
                            if($polaczenie->query("UPDATE uzytkownicy SET adres='$adres', imie='$imie', nazwisko='$nazwisko', email='$email', login='$login', haslo='$haslo' WHERE id=".$_SESSION['id']))
                            {
                                $_SESSION['wiadomosc'] ="Pomyślnie zaaktualizowano dane!";
                                header("Location:nauczyciel.php");
                            }else
                            {
                                $_SESSION['wiadomosc'] ="Nie udało się zaaktualizować danych!";
                                header("Location:nauczyciel.php");
                            }
                        }
                        
                        
                    }
                }
            catch(Exception $e)
                {
                    echo '<div class="error">Błąd serwera</div>';
                }
}
else
{
    header("Location:nauczyciel.php");
}
?>
</body>
