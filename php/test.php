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

$profil = "SELECT imie, nazwisko, funkcja, id FROM uzytkownicy WHERE funkcja = 0";

$rezultat = $polaczenie->query($profil);

if ($rezultat->num_rows > 0) {
    $petla = 0;
	while($wiersz = $rezultat->fetch_assoc()) {
		$petla++;
		echo "Uczen " . $wiersz["id"] . ": " . $wiersz["imie"] . " " . $wiersz["nazwisko"] . "<br>";
	}
}
echo "<br>";
$usunProfil = "SELECT id FROM uzytkownicy WHERE funkcja = 0";

$rezultat = $polaczenie->query($usunProfil);

$sql = "DELETE FROM uzytkownicy WHERE id = 5";

if ($polaczenie->query($sql) === TRUE) {
    echo "Record deleted successfully";
} else {
    echo "Error deleting record: " . $rezultat->conect_error;
}

$polaczenie->close();
?>