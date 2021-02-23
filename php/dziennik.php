<?php
session_start();
if(!isset($_SESSION['zalogowany']))
{
	header('Location:../index.php');
	exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dziennik</title>
</head>
<body>
<?php
echo "<p>Witaj <b>".$_SESSION['login']."</b>!<br>";
echo "Chodzisz do klasy <b>".$_SESSION['klasa']."</b><br>";
echo "A twój email to: <b>".$_SESSION['email']."</b></p><br>";
echo '[<a href="procesWylogowania.php"> Wyloguj się! </a>]';


?>
</body>
</html>