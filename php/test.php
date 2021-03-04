<?php
session_start();
require_once "polaczenieZBaza.php";

$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);

$lekcja = 
"SELECT slownik.przedmiot, dni.dzien, godzinylekcyjne.godzina, sale.sala, klasy.klasa, plan.id
FROM slownik slownik, dni dni, godzinylekcyjne godzinylekcyjne, sale sale, klasy klasy, plan plan
where plan.IdPrzedmiot = slownik.id and plan.IdDzien = dni.id and plan.IdGodzinaLekcyjna = godzinylekcyjne.id and plan.IdSala = sale.id and plan.IdKlasa = klasy.id and plan.IdKlasa = 3";
	
$rezultat = $polaczenie->query($lekcja);

if ($rezultat->num_rows > 0) {
    $petla = 0;
	while($wiersz = $rezultat->fetch_assoc()) {
		$petla++;
		echo "Dzien: " . $wiersz["dzien"]. " - Lekcja: " . $wiersz["godzina"]. " - Przedmiot: " . $wiersz["przedmiot"]. " - Sala: " . $wiersz["sala"]. "<br>";
		//echo 'Lekcja '. $petla. ': <input type="text" name="login" value="'.$wiersz["godzina"].'">';
	  }
	}
	
echo '<button onclick="window.print()">Wydrukuj plan</button> <br><br>';

$profil = "SELECT imie, nazwisko, funkcja FROM uzytkownicy WHERE funkcja = 0";

$rezultat2 = $polaczenie->query($profil);

if ($rezultat2->num_rows > 0) {
    $petla = 0;
	while($wiersz2 = $rezultat2->fetch_assoc()) {
		$petla++;
		echo "Uczen: " . $wiersz2["imie"] . " " . $wiersz2["nazwisko"] . "<br>";
	}
}

$polaczenie->close();
?>