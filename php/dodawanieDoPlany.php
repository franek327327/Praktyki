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
                    "SELECT idDzien, idGodzinaLekcyjna, idKlasa
                    FROM plan
                    ";

                    $rezultatSprawdzania = $polaczenie->query($sprawdzanieLekcji);

                    // Sprawdzanie czy lekcja na daną godzinę danego dnia już istnieje dla klasy

                    if ($rezultatSprawdzania->num_rows > 0) 
                    {
                    while($wiersz = $rezultatSprawdzania->fetch_assoc()) 
                        {
                            if($wiersz['idDzien'] == $_POST['dzien'] && $wiersz['idGodzinaLekcyjna'] == $_POST['godzina'] && $wiersz['idKlasa'] == 1)
                            {
                                $czyMoznaWyslac = false;
                            }
                        }
                    }

                    if($czyMoznaWyslac)
                {
                        if($polaczenie->query($dodawanieLekcji))
                        {
                            $_SESSION['wiadomoscDodawania'] = "<div class ='alert'><span class='closebtn' onclick='this.parentElement.style.display='".'"none;"'."'>&times;</span> Udało się dodać lekcję!</div>";
                            $polaczenie->close();
                            header("Location:planNauczyciel.php");
                            
                        }else
                        {
                            $_SESSION['wiadomoscDodawania'] = "<div class ='alert'><span class='closebtn' onclick='this.parentElement.style.display='"."none;"."'>&times;</span> Udało się dodać lekcję!</div>";
                            $polaczenie->close();
                            header("Location:planNauczyciel.php");
                        }
                }
                    else if(!$czyMoznaWyslac)
                {
                    $_SESSION['wiadomoscDodawania'] = "<div class ='alert'><span class='closebtn' onclick='this.parentElement.style.display='"."none;"."'>&times;</span> Udało się dodać lekcję!</div>";
                    $polaczenie->close();
                    header("Location:planNauczyciel.php");
                }	
}

// Usuwanie przedmiotu
if(isset($_POST['usuwaniePrzedmiotu']))
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
if(isset($_POST['dodawaniePrzedmiotu']))
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
if(isset($_POST['usuwanieKlasy']))
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
if(isset($_POST['dodawanieKlasy']))
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
            
?>

