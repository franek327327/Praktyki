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

$rezultat = $polaczenie->query($profil);

if ($rezultat->num_rows > 0) {
    $petla = 0;
	while($wiersz = $rezultat->fetch_assoc()) {
		$petla++;
		echo "Uczen: " . $wiersz["imie"] . " " . $wiersz["nazwisko"] . "<br>";
	}
}

$usunProfil = "SELECT id FROM uzytkownicy WHERE funkcja = 0";

$rezultat = $polaczenie->query($usunProfil);

if($a == 'del' and !empty($id)) {
    
    mysqli_query('DELETE id FROM test WHERE id="$id"')
    or die('Blad zapytania: '.mysqli_error());
    
    echo 'Rekord został usunęty z bazy';
}

$polaczenie->close();
?>