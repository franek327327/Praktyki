<?php
session_start();

 if(!isset($_SESSION['zalogowany']) || (isset($_SESSION['funkcja']) && $_SESSION['funkcja'] != 1))
{
	header('Location:../index.php');
	exit();
} 

?> 

<!DOCTYPE HTML>
<html lang="pl">

<head>
    <meta charset="utf-8" />
    <title>Nauczyciel - Uczniowie</title>
    <link rel="stylesheet" href="../css/style1.css">
    <script src="../js/app1.js" defer></script>
    <meta http-equiv="content-type" content="text/html; charset=ISO-8859-2">
    <link rel="preconnect" href="https://fonts.gstatic.com/%22%3E">
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=PT+Sans&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@200;700&display=swap" rel="stylesheet">
</head>

<body>


    <h1>Platforma Szkolna - Nauczyciel - uczniowie</h1>

    
<?php
require_once "polaczenieZBaza.php";
$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);


// Wyswietlanie wszystkich uczniow
//Uczniowie bez klasy
$uczenBezKlasa = "SELECT adres, IdKlasa, imie, nazwisko, email, funkcja, id FROM uzytkownicy WHERE IdKlasa IS NULL and funkcja = 0";
$rezultat = $polaczenie->query($uczenBezKlasa);
$petla = 0;
if ($rezultat->num_rows > 0) {
    
	while($wiersz = $rezultat->fetch_assoc()) {
		$petla++;
		echo "Uczen " . $petla . ": " . $wiersz["imie"] . " " . $wiersz["nazwisko"] . " | Brak Klasy | " . $wiersz['email']. " | ".$wiersz['adres']."<form style = 'display: inline;' method = 'post' action = 'uczniowie.php'> <button name = 'usuwanie' type = 'submit' value = '". $wiersz['id'] ."'>" . "Usun</button> </form>" . "<br>";
	}
}
//Uczniowie z klasą
$uczenKlasa = "SELECT u.IdKlasa, u.imie, u.nazwisko, u.email, u.funkcja, u.id, u.adres, k.klasa FROM uzytkownicy u, klasy k WHERE k.id = u.IdKlasa and funkcja = 0";
$rezultat = $polaczenie->query($uczenKlasa);
if ($rezultat->num_rows > 0) {
	while($wiersz = $rezultat->fetch_assoc()) {
		$petla++;
		echo "Uczen " . $petla . ": " . $wiersz["imie"] . " " . $wiersz["nazwisko"] . " | ".$wiersz['klasa']. " | " . $wiersz['email']. " | ".$wiersz['adres']."<form style = 'display: inline;' method = 'post' action = 'uczniowie.php'> <button name = 'usuwanie' type = 'submit' value = '". $wiersz['id'] ."'>" . "Usun</button> </form>" . "<br>";
	}
}
echo '<br>';
// usuwanie ucznia
?>
<a class="back" href="nauczyciel.php">Powrót</a>
<?php
if(isset($_SESSION['usunWiadomosc']))
{
    echo $_SESSION['usunWiadomosc'];
    unset($_SESSION['usunWiadomosc']);
}

if(isset($_POST['usuwanie']))
{
    if($polaczenie->query("DELETE FROM uzytkownicy WHERE id = ".$_POST['usuwanie']))
    {
        
        $_SESSION['usunWiadomosc'] = "Pomyślnie usunięto ucznia!";
        header("Refresh:0");
        
    }else
    {
        echo "Nie udalo sie usunac ucznia!";
    }
    unset($_POST['usuwanie']);
}
$polaczenie->close();
?>


<div id="stopka">
        PLAN LEKCJI &copy; Praktyka gr2
    </div>
</body>
</html>