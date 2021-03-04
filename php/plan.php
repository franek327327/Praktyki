<?php
session_start();
require_once "polaczenieZBaza.php";

$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);

// wyswietlanie planu
$lekcja = 
"SELECT slownik.przedmiot, dni.dzien, godzinylekcyjne.godzina, sale.sala, klasy.klasa, plan.id
FROM slownik slownik, dni dni, godzinylekcyjne godzinylekcyjne, sale sale, klasy klasy, plan plan
where plan.IdPrzedmiot = slownik.id and plan.IdDzien = dni.id and plan.IdGodzinaLekcyjna = godzinylekcyjne.id and plan.IdSala = sale.id and plan.IdKlasa = klasy.id and plan.IdKlasa = 3";
	
$rezultat = $polaczenie->query($lekcja);

if ($rezultat->num_rows > 0) 
    {
	while($wiersz = $rezultat->fetch_assoc()) 
        {
		echo "Dzien: " . $wiersz["dzien"]. " - Lekcja: " . $wiersz["godzina"]. " - Przedmiot: " . $wiersz["przedmiot"]. " - Sala: " . $wiersz["sala"]. "<br>";
	    }
	}

// drukowanie
echo '<br> <button onclick="window.print()">Wydrukuj plan</button> <br><br>';

// dodawanie lekcji do planu
$przedmiot = "SELECT slownik.id, slownik.przedmiot FROM slownik";

$rezultat = $polaczenie->query($przedmiot);
echo '<form method="post" action="plan.php"> <select name="przedmiot">';

if ($rezultat->num_rows > 0) 
    {
	while($wiersz = $rezultat->fetch_assoc()) 
        {
        echo '<option value="' . $wiersz["id"] . '">' . $wiersz["przedmiot"] . "</option>";
        }
    }
echo "</select> </form>";










$polaczenie->close();
?>

