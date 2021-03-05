<?php

// wyswietlanie planu
session_start();
require_once "polaczenieZBaza.php";
$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);

$lekcje1 = 
"SELECT slownik.przedmiot, dni.dzien, godzinylekcyjne.godzina, sale.sala, klasy.klasa, plan.IdGodzinaLekcyjna, plan.IdPrzedmiot, plan.IdSala, plan.IdDzien
FROM slownik slownik, dni dni, godzinylekcyjne godzinylekcyjne, sale sale, klasy klasy, plan plan
where plan.IdPrzedmiot = slownik.id and plan.IdDzien = dni.id and plan.IdGodzinaLekcyjna = godzinylekcyjne.id and plan.IdSala = sale.id and plan.IdKlasa = klasy.id and plan.IdKlasa = 1 and plan.IdDzien = 1
ORDER BY plan.idGodzinaLekcyjna ASC";

$lekcje2 = 
"SELECT slownik.przedmiot, dni.dzien, godzinylekcyjne.godzina, sale.sala, klasy.klasa, plan.IdGodzinaLekcyjna, plan.IdPrzedmiot, plan.IdSala, plan.IdDzien
FROM slownik slownik, dni dni, godzinylekcyjne godzinylekcyjne, sale sale, klasy klasy, plan plan
where plan.IdPrzedmiot = slownik.id and plan.IdDzien = dni.id and plan.IdGodzinaLekcyjna = godzinylekcyjne.id and plan.IdSala = sale.id and plan.IdKlasa = klasy.id and plan.IdKlasa = 1 and plan.IdDzien = 2
ORDER BY plan.idGodzinaLekcyjna ASC";

$lekcje3 = 
"SELECT slownik.przedmiot, dni.dzien, godzinylekcyjne.godzina, sale.sala, klasy.klasa, plan.IdGodzinaLekcyjna, plan.IdPrzedmiot, plan.IdSala, plan.IdDzien
FROM slownik slownik, dni dni, godzinylekcyjne godzinylekcyjne, sale sale, klasy klasy, plan plan
where plan.IdPrzedmiot = slownik.id and plan.IdDzien = dni.id and plan.IdGodzinaLekcyjna = godzinylekcyjne.id and plan.IdSala = sale.id and plan.IdKlasa = klasy.id and plan.IdKlasa = 1 and plan.IdDzien = 3
ORDER BY plan.idGodzinaLekcyjna ASC";

$lekcje4 = 
"SELECT slownik.przedmiot, dni.dzien, godzinylekcyjne.godzina, sale.sala, klasy.klasa, plan.IdGodzinaLekcyjna, plan.IdPrzedmiot, plan.IdSala, plan.IdDzien
FROM slownik slownik, dni dni, godzinylekcyjne godzinylekcyjne, sale sale, klasy klasy, plan plan
where plan.IdPrzedmiot = slownik.id and plan.IdDzien = dni.id and plan.IdGodzinaLekcyjna = godzinylekcyjne.id and plan.IdSala = sale.id and plan.IdKlasa = klasy.id and plan.IdKlasa = 1 and plan.IdDzien = 4
ORDER BY plan.idGodzinaLekcyjna ASC";

$lekcje5 = 
"SELECT slownik.przedmiot, dni.dzien, godzinylekcyjne.godzina, sale.sala, klasy.klasa, plan.IdGodzinaLekcyjna, plan.IdPrzedmiot, plan.IdSala, plan.IdDzien
FROM slownik slownik, dni dni, godzinylekcyjne godzinylekcyjne, sale sale, klasy klasy, plan plan
where plan.IdPrzedmiot = slownik.id and plan.IdDzien = dni.id and plan.IdGodzinaLekcyjna = godzinylekcyjne.id and plan.IdSala = sale.id and plan.IdKlasa = klasy.id and plan.IdKlasa = 1 and plan.IdDzien = 5
ORDER BY plan.idGodzinaLekcyjna ASC";

$przedmioty =
"SELECT slownik.id, slownik.przedmiot
From slownik slownik";

$sala = 
"SELECT sale.id, sale.sala
FROM sale sale";


for($i = 1; $i <= 5; $i++)
{
    $rezultat = $polaczenie->query(${'lekcje'.$i});
    if ($rezultat->num_rows > 0) 
    {
        $petla = 0;
        while($wiersz = $rezultat->fetch_assoc()) 
        { 
            $petla++;
            $GLOBALS["Lekcja".$i."_".$wiersz["IdGodzinaLekcyjna"]] = $wiersz["przedmiot"];
        }
    }
}
		


echo
"<table>
<tr>
<th>Nr</th>
<th>Godzina</th>
<th>Poniedziałek</th>
<th>Wtorek</th>
<th>Środa</th>
<th>Czwartek</th>
<th>Piątek</th>
</tr>
<tr>
<td>1</td>
<td>8:00 - 8:45</td>
<td>"
.(isset($Lekcja1_1) ? $Lekcja1_1 : "-").
"</td>
<td>"
.(isset($Lekcja2_1) ? $Lekcja2_1 : "-").
"</td>
<td>"
.(isset($Lekcja3_1) ? $Lekcja3_1 : "-").
"</td>
<td>"
.(isset($Lekcja4_1) ? $Lekcja4_1 : "-").
"</td>
<td>"
.(isset($Lekcja5_1) ? $Lekcja5_1 : "-").
"</td>
</tr>
<tr>
<td>2</td>
<td>8:50 - 9:35</td>
<td>"
.(isset($Lekcja1_2) ? $Lekcja1_2 : "-").
"</td>
<td>"
.(isset($Lekcja2_2) ? $Lekcja2_2 : "-").
"</td>
<td>"
.(isset($Lekcja3_2) ? $Lekcja3_2 : "-").
"</td>
<td>"
.(isset($Lekcja4_2) ? $Lekcja4_2 : "-").
"</td>
<td>"
.(isset($Lekcja5_2) ? $Lekcja5_2 : "-").
"</td>
</tr>
<tr>
<td>3</td>
<td>9:45 - 10:30</td>
<td>"
.(isset($Lekcja1_3) ? $Lekcja1_3 : "-").
"</td>
<td>"
.(isset($Lekcja2_3) ? $Lekcja2_3 : "-").
"</td>
<td>"
.(isset($Lekcja3_3) ? $Lekcja3_3 : "-").
"</td>
<td>"
.(isset($Lekcja4_3) ? $Lekcja4_3 : "-").
"</td>
<td>"
.(isset($Lekcja5_3) ? $Lekcja5_3 : "-").
"</td>
</tr>
<tr>
<td>4</td>
<td>10:50 - 11:35</td>
<td>"
.(isset($Lekcja1_4) ? $Lekcja1_4 : "-").
"</td>
<td>"
.(isset($Lekcja2_4) ? $Lekcja2_4 : "-").
"</td>
<td>"
.(isset($Lekcja3_4) ? $Lekcja3_4 : "-").
"</td>
<td>"
.(isset($Lekcja4_4) ? $Lekcja4_4 : "-").
"</td>
<td>"
.(isset($Lekcja5_4) ? $Lekcja5_4 : "-").
"</td>
</tr>
<tr>
<td>5</td>
<td>11:40 - 12:25</td>
<td>"
.(isset($Lekcja1_5) ? $Lekcja1_5 : "-").
"</td>
<td>"
.(isset($Lekcja2_5) ? $Lekcja2_5 : "-").
"</td>
<td>"
.(isset($Lekcja3_5) ? $Lekcja3_5 : "-").
"</td>
<td>"
.(isset($Lekcja4_5) ? $Lekcja4_5 : "-").
"</td>
<td>"
.(isset($Lekcja5_5) ? $Lekcja5_5 : "-").
"</td>
</tr>
<tr>
<td>6</td>
<td>12:30 - 13:15</td>
<td>"
.(isset($Lekcja1_6) ? $Lekcja1_6 : "-").
"</td>
<td>"
.(isset($Lekcja2_6) ? $Lekcja2_6 : "-").
"</td>
<td>"
.(isset($Lekcja3_6) ? $Lekcja3_6 : "-").
"</td>
<td>"
.(isset($Lekcja4_6) ? $Lekcja4_6 : "-").
"</td>
<td>"
.(isset($Lekcja5_6) ? $Lekcja5_6 : "-").
"</td>
</tr>
<tr>
<td>7</td>
<td>13:20 - 14:05</td>
<td>"
.(isset($Lekcja1_7) ? $Lekcja1_7 : "-").
"</td>
<td>"
.(isset($Lekcja2_7) ? $Lekcja2_7 : "-").
"</td>
<td>"
.(isset($Lekcja3_7) ? $Lekcja3_7 : "-").
"</td>
<td>"
.(isset($Lekcja4_7) ? $Lekcja4_7 : "-").
"</td>
<td>"
.(isset($Lekcja5_7) ? $Lekcja5_7 : "-").
"</td>
</tr>
<tr>
<td>8</td>
<td>14:10 - 14:55</td>
<td>"
.(isset($Lekcja1_8) ? $Lekcja1_8 : "-").
"</td>
<td>"
.(isset($Lekcja2_8) ? $Lekcja2_8 : "-").
"</td>
<td>"
.(isset($Lekcja3_8) ? $Lekcja3_8 : "-").
"</td>
<td>"
.(isset($Lekcja4_8) ? $Lekcja4_8 : "-").
"</td>
<td>"
.(isset($Lekcja5_8) ? $Lekcja5_8 : "-").
"</td>
</tr>
</table>";
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

