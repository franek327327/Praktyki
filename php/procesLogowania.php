<?php 

session_start();

if(isset($_POST['login']))
{
	
}

if(!isset($_POST['login']) && !isset($_POST['haslo']))
{
	header('Location:../index.php');
	exit();
}
require_once "polaczenieZBaza.php";

$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);

if($polaczenie->connect_errno!=0)
{
	echo "Błąd mySQL: ".$polaczenie->connect_errno;
}else
{
$_SESSION['fr_loginLog'] = $_POST['login'];
$_SESSION['rozwLog'] = true;
$login = $_POST['login'];
$haslo = $_POST['haslo'];
$login = htmlentities($login, ENT_QUOTES, "UTF-8");
$haslo = htmlentities($haslo, ENT_QUOTES, "UTF-8");
}
if($rezultat = @$polaczenie->query(
sprintf("SELECT * FROM uczniowie WHERE BINARY login='%s' AND BINARY haslo='%s'",
mysqli_real_escape_string($polaczenie,$login),
mysqli_real_escape_string($polaczenie,$haslo))))
{
	$czyZnaleziono = $rezultat->num_rows;
	if($czyZnaleziono>0)
	{
		$_SESSION['zalogowany'] = true;
		$wiersz = $rezultat->fetch_assoc();
		$_SESSION['id'] = $wiersz['id'];
		$_SESSION['login'] = $wiersz['login'];
		$_SESSION['klasa'] = $wiersz['klasa'];
		$_SESSION['email'] = $wiersz['email'];
		$_SESSION['imie'] = $wiersz['imie'];
		$_SESSION['nazwisko'] = $wiersz['nazwisko'];
		$_SESSION['adres'] = $wiersz['adres'];
		
		$rezultat->close();
		header('Location:uczen.php');
	}else
	{
		if($rezultat = @$polaczenie->query(
			sprintf("SELECT * FROM nauczyciele WHERE BINARY login='%s' AND BINARY haslo='%s'",
			mysqli_real_escape_string($polaczenie,$login),
			mysqli_real_escape_string($polaczenie,$haslo))))
			{
				$czyZnaleziono = $rezultat->num_rows;
				if($czyZnaleziono>0)
				{
					$_SESSION['zalogowany'] = true;
					$wiersz = $rezultat->fetch_assoc();
					$_SESSION['id'] = $wiersz['id'];
					$_SESSION['login'] = $wiersz['login'];
					$_SESSION['klasa'] = $wiersz['klasa'];
					$_SESSION['email'] = $wiersz['email'];
					$_SESSION['imie'] = $wiersz['imie'];
					$_SESSION['nazwisko'] = $wiersz['nazwisko'];
					$_SESSION['adres'] = $wiersz['adres'];
					
					$rezultat->close();
					header('Location:nauczyciel.php');
				}else
				{
					$_SESSION['blad'] = '<span style="color:red">Zły login lub hasło!</span>';
					header('Location:../index.php');
				}
			}
	}
	
	


$polaczenie->close();
}

?>