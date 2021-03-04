<?php
session_start();
require_once "polaczenieZBaza.php";

$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);

// wyswietlanie planu
$lekcja = 
"SELECT slownik.przedmiot, dni.dzien, godzinylekcyjne.godzina, sale.sala, klasy.klasa, plan.id, plan.IdDzien, plan.IdGodzinaLekcyjna
FROM slownik slownik, dni dni, godzinylekcyjne godzinylekcyjne, sale sale, klasy klasy, plan plan
where plan.IdPrzedmiot = slownik.id and plan.IdDzien = dni.id and plan.IdGodzinaLekcyjna = godzinylekcyjne.id and plan.IdSala = sale.id and plan.IdKlasa = klasy.id
ORDER BY plan.IdDzien , plan.IdGodzinaLekcyjna";

$rezultat = $polaczenie->query($lekcja);

if ($rezultat->num_rows > 0) 
    {
	while($wiersz = $rezultat->fetch_assoc()) 
        {
		echo "Dzien: " . $wiersz["dzien"] . " - Lekcja: " . $wiersz["IdGodzinaLekcyjna"] . " - Przedmiot: " . $wiersz["przedmiot"] . " - Sala: " . $wiersz["sala"] . "<form style = 'display: inline;' method = 'post' action = 'plan.php'> <button name = 'usuwanie' type = 'submit' value = '". $wiersz['id'] ."'>" . "Usun</button> </form>" . "<br>";
	    }
	}

// usuwanie lekcji
if(isset($_POST['usuwanie']))
{
    if($polaczenie->query("DELETE FROM plan WHERE id = " . $_POST['usuwanie']))
    {
        header("Refresh:0");
        
    }else
    {
        echo "Nie udało się dodać lekcji!";
    }
    unset($_POST['usuwanie']);
}


// drukowanie
echo '<br> <button onclick="window.print()">Wydrukuj plan</button> <br><br>';

// dodawanie lekcji do planu
$przedmiot = "SELECT id, przedmiot FROM slownik";
$klasa = "SELECT id, klasa FROM klasy";
$dzien = "SELECT id, dzien FROM dni";
$godzina = "SELECT id, godzina FROM godzinylekcyjne";
$sala = "SELECT id, sala FROM sale";
$nauczyciel = "SELECT id, imie, nazwisko, funkcja FROM uzytkownicy WHERE funkcja = 1";

$rezultat1 = $polaczenie->query($przedmiot);
$rezultat2 = $polaczenie->query($klasa);
$rezultat3 = $polaczenie->query($dzien);
$rezultat4 = $polaczenie->query($godzina);
$rezultat5 = $polaczenie->query($sala);
$rezultat6 = $polaczenie->query($nauczyciel);

echo '<form method="post" action="plan.php"> <select name="przedmiot">';

if ($rezultat1->num_rows > 0) 
    {
	while($wiersz = $rezultat1->fetch_assoc()) 
        {
        echo '<option value="' . $wiersz["id"] . '">' . $wiersz["przedmiot"] . "</option>";
        }
    }
echo '</select><select name="klasa">';
    if ($rezultat2->num_rows > 0) 
    {
	while($wiersz = $rezultat2->fetch_assoc()) 
        {
        echo '<option value="' . $wiersz["id"] . '">' . $wiersz["klasa"] . "</option>";
        }
    }
    echo '</select><select name="dzien">';
if ($rezultat3->num_rows > 0) 
{
while($wiersz = $rezultat3->fetch_assoc()) 
    {
    echo '<option value="' . $wiersz["id"] . '">' . $wiersz["dzien"] . "</option>";
    }
}
echo '</select><select name="godzina">';
if ($rezultat4->num_rows > 0) 
{
while($wiersz = $rezultat4->fetch_assoc()) 
    {
    echo '<option value="' . $wiersz["id"] . '">' . $wiersz['id'] . '. ' . $wiersz["godzina"] . "</option>";
    }
}
echo '</select><select name="sala">';
if ($rezultat5->num_rows > 0) 
{
while($wiersz = $rezultat5->fetch_assoc()) 
    {
    echo '<option value="' . $wiersz["id"] . '">' . $wiersz["sala"] . "</option>";
    }
}
echo '</select><select name="imieinazwisko">';
if ($rezultat6->num_rows > 0) 
{
while($wiersz = $rezultat6->fetch_assoc()) 
    {
    echo '<option value="' . $wiersz["id"] . '">' . $wiersz["imie"] . ' ' . $wiersz["nazwisko"] . "</option>";
    }
}
echo '<br>';
echo '<input type="submit" name="dodawanie" value="Dodaj lekcję!">';
echo "</form>";

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
                header("Refresh:0");
                
            }else
            {
                echo "Nie udało się dodać lekcji!";
            }
    }
        else if(!$czyMoznaWyslac)
    {
        echo "O podanej godzinie podanego dnia dla podanej klasy już istnieje lekcja!";
    }	
}


$polaczenie->close();
?>

