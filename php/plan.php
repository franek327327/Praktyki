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
echo "</select><select>";
    if ($rezultat2->num_rows > 0) 
    {
	while($wiersz = $rezultat2->fetch_assoc()) 
        {
        echo '<option value="' . $wiersz["id"] . '">' . $wiersz["klasa"] . "</option>";
        }
    }
echo "</select><select>";
if ($rezultat3->num_rows > 0) 
{
while($wiersz = $rezultat3->fetch_assoc()) 
    {
    echo '<option value="' . $wiersz["id"] . '">' . $wiersz["dzien"] . "</option>";
    }
}
echo "</select><select>";
if ($rezultat4->num_rows > 0) 
{
while($wiersz = $rezultat4->fetch_assoc()) 
    {
    echo '<option value="' . $wiersz["id"] . '">' . $wiersz["godzina"] . "</option>";
    }
}
echo "</select><select>";
if ($rezultat5->num_rows > 0) 
{
while($wiersz = $rezultat5->fetch_assoc()) 
    {
    echo '<option value="' . $wiersz["id"] . '">' . $wiersz["sala"] . "</option>";
    }
}
echo "</select><select>";
if ($rezultat6->num_rows > 0) 
{
while($wiersz = $rezultat6->fetch_assoc()) 
    {
    echo '<option value="' . $wiersz["id"] . '">' . $wiersz["imie"] . ' ' . $wiersz["nazwisko"] . "</option>";
    }
}



echo "</form>";







$polaczenie->close();
?>

