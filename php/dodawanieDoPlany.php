<?php
session_start();
require_once "polaczenieZBaza.php";
$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);

            // Dodawanie Lekcji

            if(isset($_POST['dodawanie']))
            {
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
                            $_SESSION['wiadomoscDodawania'] = "Udało się dodać lekcję!";
                            $polaczenie->close();
                            header("Location:nauczyciel.php");
                            
                        }else
                        {
                            $_SESSION['wiadomoscDodawania'] = "Nie udało się dodać lekcji!";
                            $polaczenie->close();
                            header("Location:nauczyciel.php");
                        }
                }
                    else if(!$czyMoznaWyslac)
                {
                    $_SESSION['wiadomoscDodawania'] = "Taka lekcja już istnieje!";
                    $polaczenie->close();
                    header("Location:nauczyciel.php");
                }	
            }
            
?>

