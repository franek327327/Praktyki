<?php
session_start();

/* if(!isset($_SESSION['zalogowany']) || (isset($_SESSION['funkcja']) && $_SESSION['funkcja'] != 1))
{
	header('Location:../index.php');
	exit();
} 
*/
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

// wyswietlanie wszystkich uczniow
$profil = "SELECT imie, nazwisko, funkcja, id FROM uzytkownicy WHERE funkcja = 0";

$rezultat = $polaczenie->query($profil);

if ($rezultat->num_rows > 0) {
    $petla = 0;
	while($wiersz = $rezultat->fetch_assoc()) {
		$petla++;
		echo "Uczen " . $wiersz["id"] . ": " . $wiersz["imie"] . " " . $wiersz["nazwisko"] . "<br>";
	}
}
echo '<br>';
// usuwanie uczniow o id == 5
$usunProfil = "SELECT id FROM uzytkownicy WHERE funkcja = 0";

$rezultat = $polaczenie->query($usunProfil);

$sql = "DELETE FROM uzytkownicy WHERE id = 5";

if ($polaczenie->query($sql) === TRUE) {
    echo "Record deleted successfully";
} else {
    echo "Error deleting record: " . $rezultat->conect_error;
}
?>

</body>
</html>   


