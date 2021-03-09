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
        $_SESSION['wiadomoscDodawania'] = "Nie udało się zaaktualizować lekcji!".$conn->error;
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
        $_SESSION['wiadomoscDodawania'] = "Nie udało się usunąć lekcji!".$conn->error;
        $polaczenie->close();
        header("Location:planNauczyciel.php");
      }

}
else if(isset($_POST['edytowanieKlasy']))
{
    $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
    echo $_POST['nazwaKlasy'];
}
else
{
    header("Location:nauczyciel.php");
}
?>
<button onclick="location.href='planNauczyciel.php'">Powrót</button>
