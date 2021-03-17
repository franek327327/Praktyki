<head>
    <meta charset="utf-8" />
    <title>Plan lekcji</title>
    <link rel="stylesheet" href="../css/style1.css">
    <script src="../js/app1.js" defer></script>
    <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="http://html2canvas.hertzen.com/dist/html2canvas.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="content-type" content="text/html; charset=ISO-8859-2">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=PT+Sans&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@200;700&display=swap" rel="stylesheet">
</head>
<body>
<h1>Platforma Szkolna - Plan</h1>
<a class="back" href="nauczyciel.php">Powrót</a>
<div id="plan">
        <h3>Plan Lekcji</h3>
<?php
// wyswietlanie planu
session_start();
if(!isset($_SESSION['zalogowany']) || (isset($_SESSION['funkcja']) && $_SESSION['funkcja'] != 0))
    {
        header('Location:../index.php');
        exit();
    } 

if(!isset($_SESSION['jestKlasa']))
{
    echo "<a href='uczen.php'>Kliknij by dodać klasę</a>";
    $_SESSION['edycjaDanych'] = 1;
    exit();
}
?>
<?php
require_once "polaczenieZBaza.php";
$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);

$lekcje1 = 
            "SELECT slownik.przedmiot, dni.dzien, godzinylekcyjne.godzina, sale.sala, klasy.klasa, plan.IdGodzinaLekcyjna, plan.IdPrzedmiot, plan.IdSala, plan.IdDzien, uzytkownicy.imie, uzytkownicy.nazwisko, plan.id, godzinyLekcyjne.id as gId
            FROM slownik slownik, dni dni, godzinylekcyjne godzinylekcyjne, sale sale, klasy klasy, plan plan, uzytkownicy uzytkownicy
            where plan.IdNauczyciel = uzytkownicy.id and plan.IdPrzedmiot = slownik.id and plan.IdDzien = dni.id and plan.IdGodzinaLekcyjna = godzinylekcyjne.id and plan.IdSala = sale.id and plan.IdKlasa = klasy.id and plan.IdKlasa = ".$_SESSION['idKlasy']." AND plan.IdDzien = 1
            ORDER BY plan.idGodzinaLekcyjna ASC";
        
            $lekcje2 = 
            "SELECT slownik.przedmiot, dni.dzien, godzinylekcyjne.godzina, sale.sala, klasy.klasa, plan.IdGodzinaLekcyjna, plan.IdPrzedmiot, plan.IdSala, plan.IdDzien, uzytkownicy.imie, uzytkownicy.nazwisko, plan.id, godzinyLekcyjne.id as gId
            FROM slownik slownik, dni dni, godzinylekcyjne godzinylekcyjne, sale sale, klasy klasy, plan plan, uzytkownicy uzytkownicy
            where plan.IdNauczyciel = uzytkownicy.id and plan.IdPrzedmiot = slownik.id and plan.IdDzien = dni.id and plan.IdGodzinaLekcyjna = godzinylekcyjne.id and plan.IdSala = sale.id and plan.IdKlasa = klasy.id and plan.IdKlasa = ".$_SESSION['idKlasy']." AND plan.IdDzien = 2
            ORDER BY plan.idGodzinaLekcyjna ASC";
        
            $lekcje3 = 
            "SELECT slownik.przedmiot, dni.dzien, godzinylekcyjne.godzina, sale.sala, klasy.klasa, plan.IdGodzinaLekcyjna, plan.IdPrzedmiot, plan.IdSala, plan.IdDzien, uzytkownicy.imie, uzytkownicy.nazwisko, plan.id, godzinyLekcyjne.id as gId
            FROM slownik slownik, dni dni, godzinylekcyjne godzinylekcyjne, sale sale, klasy klasy, plan plan, uzytkownicy uzytkownicy
            where plan.IdNauczyciel = uzytkownicy.id and plan.IdPrzedmiot = slownik.id and plan.IdDzien = dni.id and plan.IdGodzinaLekcyjna = godzinylekcyjne.id and plan.IdSala = sale.id and plan.IdKlasa = klasy.id and plan.IdKlasa = ".$_SESSION['idKlasy']." AND plan.IdDzien = 3
            ORDER BY plan.idGodzinaLekcyjna ASC";
        
            $lekcje4 = 
            "SELECT slownik.przedmiot, dni.dzien, godzinylekcyjne.godzina, sale.sala, klasy.klasa, plan.IdGodzinaLekcyjna, plan.IdPrzedmiot, plan.IdSala, plan.IdDzien, uzytkownicy.imie, uzytkownicy.nazwisko, plan.id, godzinyLekcyjne.id as gId
            FROM slownik slownik, dni dni, godzinylekcyjne godzinylekcyjne, sale sale, klasy klasy, plan plan, uzytkownicy uzytkownicy
            where plan.IdNauczyciel = uzytkownicy.id and plan.IdPrzedmiot = slownik.id and plan.IdDzien = dni.id and plan.IdGodzinaLekcyjna = godzinylekcyjne.id and plan.IdSala = sale.id and plan.IdKlasa = klasy.id and plan.IdKlasa = ".$_SESSION['idKlasy']." AND plan.IdDzien = 4
            ORDER BY plan.idGodzinaLekcyjna ASC";
        
            $lekcje5 = 
            "SELECT slownik.przedmiot, dni.dzien, godzinylekcyjne.godzina, sale.sala, klasy.klasa, plan.IdGodzinaLekcyjna, plan.IdPrzedmiot, plan.IdSala, plan.IdDzien, uzytkownicy.imie, uzytkownicy.nazwisko, plan.id, godzinyLekcyjne.id as gId
            FROM slownik slownik, dni dni, godzinylekcyjne godzinylekcyjne, sale sale, klasy klasy, plan plan, uzytkownicy uzytkownicy
            where plan.IdNauczyciel = uzytkownicy.id and plan.IdPrzedmiot = slownik.id and plan.IdDzien = dni.id and plan.IdGodzinaLekcyjna = godzinylekcyjne.id and plan.IdSala = sale.id and plan.IdKlasa = klasy.id and plan.IdKlasa = ".$_SESSION['idKlasy']." AND plan.IdDzien = 5
            ORDER BY plan.idGodzinaLekcyjna ASC";
        
        
            for($i = 1; $i <= 5; $i++)
            {
                $rezultat = $polaczenie->query(${'lekcje'.$i});
                if ($rezultat->num_rows > 0) 
                {
                    $petla = 0;
                    while($wiersz = $rezultat->fetch_assoc()) 
                    { 
                        $petla++;
                        $GLOBALS["Lekcja".$i."_".$wiersz["IdGodzinaLekcyjna"]] = $wiersz['przedmiot']." ".$wiersz['sala']."<br> ".$wiersz['imie']." ".$wiersz['nazwisko'];
                    }
                    $rezultat->close();
                }
            }
            echo
            "<div class='drukuj'><table>
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
            </table></div>";
            
            $polaczenie->close();
?>
<button id="pl" onclick="printDiv();">Drukuj</button>
<button onclick="Download();">Pobierz</button>
<button onclick="SendMail();">Wyślij na email</button>

</div>
<div id="stopka">
        PLAN LEKCJI &copy; Praktyka gr2
    </div>
    
</body>
</html>