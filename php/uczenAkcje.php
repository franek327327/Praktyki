<?php
session_start();
require "polaczenieZBaza.php";

if(isset($_POST['edycjaDanych']))
{
    $_SESSION['edycjaDanych'] = 1;
    header("Location:uczen.php");
}
// Zapisywanie danych z edycji do bazy danych
else if (isset($_POST['zapisz']))
{
        $ok = true;
        $imie=$_POST['imieEdit'];
        $nazwisko=$_POST['nazwiskoEdit'];
        $login=$_POST['loginEdit'];
        $idKlasy=$_POST['klasaEdit'];
        $email=$_POST['emailEdit'];
        $haslo=$_POST['hasloEdit'];
        $adres=$_POST['adresEdit'];

        //walidacja imienia, nazwiska i adresu
        if(strlen($imie) < 1 || strlen($nazwisko) < 1 || strlen($adres) < 1)
            {
                $ok=false;
                $_SESSION['error_Ina']="Nie wpisano imienia, nazwiska lub adresu!";
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
                            $_SESSION['wiadomosc'] ="Podany email już istnieje w bazie!";
                            header("Location:uczen.php");
                        }
                        $rezultat->close();
                        
                        //czy login istnieje
                        $rezultat = $polaczenie->query("SELECT id FROM uzytkownicy WHERE BINARY login='$login' AND id <> ".$_SESSION['id']);
                        if(!$rezultat) throw new Exception($polaczenie->error);
                        
                        $ileLogin = $rezultat->num_rows;
                        if($ileLogin>0)
                        {
                            $ok=false;
                            $_SESSION['wiadomosc'] ="Podany login już istnieje w bazie!";
                            header("Location:uczen.php");
                        }
                        if($ok==true)
                        {
                            if($polaczenie->query("UPDATE uzytkownicy SET adres ='$adres', IdKlasa='$idKlasy', imie='$imie', nazwisko='$nazwisko', email='$email', login='$login', haslo='$haslo' WHERE id=".$_SESSION['id']))
                            {
                                $_SESSION['wiadomosc'] ="Pomyślnie zaaktualizowano dane!";
                                header("Location:uczen.php");
                            }else
                            {
                                $_SESSION['wiadomosc'] ="Nie udało się zaaktualizować danych!";
                                header("Location:uczen.php");
                            }
                        }
                        
                        
                    }
                }
            catch(Exception $e)
                {
                    echo '<div class="error">Błąd serwera</div>';
                }
}else
{
    header("Location:uczen.php");
}
?>