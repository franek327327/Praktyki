<?php
session_start();
require_once "polaczenieZBaza.php";

$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);


if($rezultat = @$polaczenie->query(
	sprintf("SELECT * FROM uzytkownicy WHERE BINARY login='%s'",
	mysqli_real_escape_string($polaczenie,"franek372372"))))
	{
		$czyZnaleziono = $rezultat->num_rows;
		if($czyZnaleziono>0)
		{
			$_SESSION['zalogowany'] = true;
			$wiersz = $rezultat->fetch_assoc();
			$_SESSION['id'] = $wiersz['id'];
			$_SESSION['login'] = $wiersz['login'];
			$_SESSION['IdKlasa'] = $wiersz['IdKlasa'];
			$_SESSION['email'] = $wiersz['email'];
			$_SESSION['imie'] = $wiersz['imie'];
			$_SESSION['nazwisko'] = $wiersz['nazwisko'];
			$_SESSION['funkcja'] = $wiersz['funkcja'];
			
			$rezultat->close();
            echo $_SESSION['id'],
            "<br>",
			 $_SESSION['login'],
             "<br>",
             $_SESSION['IdKlasa'],
             "<br>",
             $_SESSION['email'],
             "<br>",
             $_SESSION['imie'],
             "<br>",
             $_SESSION['nazwisko'],
             "<br>",
             $_SESSION['funkcja'];
		}
	}
    $polaczenie->close();
?>