<?php
session_start();


if (isset($_POST['emailReg']))
{
	$_SESSION['rozwRej'] = true;
	$ok = true;
	
	$imie=$_POST['imieReg'];
	$nazwisko=$_POST['nazwiskoReg'];
	$adres=$_POST['adresReg'];
	$login=$_POST['loginReg'];
	$email=$_POST['emailReg'];
	$haslo1=$_POST['haslo1'];
	$haslo2=$_POST['haslo2'];
	$funkcja = NULL;
	if(isset($_POST['uN']) && $_POST['uN'] == "uczen")
	{
		$funkcja = 0;
	}else if(isset($_POST['uN']) && $_POST['uN'] == "nauczyciel")
	{
		$funkcja = 1;
	}

	//walidacja imienia, nazwiska i adresu

	if(strlen($imie) < 1 || strlen($nazwisko) < 1 || strlen($adres) < 1)
	{
		$ok=false;
		$_SESSION['error_Ina']="Nie wpisano imienia, nazwiska lub adresu";
	}

	//walidacja loginu	
	
	if (ctype_alnum($login)==false)
	{
		$ok=false;
		$_SESSION['error_login']="Login może się składać tylko z cyfr i liter (bez polskich znaków)";
	}
	
	if((strlen($login)<1) || (strlen($login)>50))
	{
		$ok=false;
		$_SESSION["error_login"]="Nie wpisano loginu lub login ma więcej niż 50 znaków";
	}
	
//walidacja emaila	
	
	if(strlen($email)<1)
	{
		$ok=false;
		$_SESSION['error_email']="Nie podano emaila";
	}

	$emailVal = filter_var($email, FILTER_SANITIZE_EMAIL);
	
//walidacja hasla

	if(strlen($haslo1)<5 || (strlen($haslo1)>50))
	{
		$ok=false;
		$_SESSION["error_haslo"]="Hasło musi zawierać od 5 do 50 znaków";
	}

	if($haslo1!=$haslo2)
	{
		$ok=false;
		$_SESSION["error_haslo"]="Hasła nie są identyczne";
	}
	
	//$haslo_hash = password_hash($haslo1, PASSWORD_DEFAULT);
	
	if(!isset($_POST['uN']))
	{
		$_SESSION["error_wybor"]="Zaznacz czy jesteś uczniem czy nauczycielem";
	}
	
	$_SESSION['fr_login'] = $login;
	$_SESSION['fr_email'] = $email;
	$_SESSION['fr_imie'] = $imie;
	$_SESSION['fr_nazwisko'] = $nazwisko;
	$_SESSION['fr_adres'] = $adres;

	if (isset($_POST['uN']))
	{
		if($_POST['uN']=="uczen")
		{
			$_SESSION['fr_uN'] = "uczen";
		}else if($_POST['uN']=="nauczyciel")
		{
			$_SESSION['fr_uN'] = "nauczyciel";
		}
	}
	
		require_once "php/polaczenieZBaza.php";
		mysqli_report(MYSQLI_REPORT_STRICT);
		
		try
		{
			$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
			if($polaczenie->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
			else
			{
				//Czy mail istnieje
				$rezultat = $polaczenie->query("SELECT id FROM uzytkownicy WHERE email='$email'");
				if(!$rezultat) throw new Exception($polaczenie->error);
				
				$ileMaili = $rezultat->num_rows;
				if($ileMaili>0)
				{
					$ok=false;
					$_SESSION['error_email']="Podany email już istnieje w bazie";
				}
				
				//czy login istnieje
				$rezultat = $polaczenie->query("SELECT id FROM uzytkownicy WHERE login='$login'");
				if(!$rezultat) throw new Exception($polaczenie->error);
				
				$ileLogin = $rezultat->num_rows;
				if($ileLogin>0)
				{
					$ok=false;
					$_SESSION['error_login']="Podany login już istnieje w bazie";
				}
				if($ok==true)
				{
					if($polaczenie->query("INSERT INTO uzytkownicy VALUES (NULL, '$imie', '$nazwisko', '$funkcja', '$email', '$login', '$haslo1', NULL, '$adres')"))
					{
						$_SESSION['rejestracjaUdana']=true;
						
						
					}else
					{
						throw new Exception($polaczenie->error);
					}
				}
				
				$polaczenie->close();
			}
		}
		catch(Exception $e)
		{
			echo '<div class="error">Błąd serwera</div>';
		}
		
		

	
}

if(isset($_SESSION['rejestracjaUdana']) && $_SESSION['rejestracjaUdana']==true)
{
	echo "Rejestracja udana, możesz zalogować się na twoje konto";
	unset($_SESSION['rejestracjaUdana']);
}


if((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']==true))
{
	if($_SESSION['funkcja'] == 0)
	{
		header('Location:php/uczen.php');
	}else if($_SESSION['funkcja'] == 1)
	{
		header('Location:php/nauczyciel.php');
	}
	exit();
}
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
    <meta charset="utf-8" />
    <title>plan lekcji</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/app.js" defer></script>
    <meta http-equiv="content-type" content="text/html; charset=ISO-8859-2">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.gstatic.com/%22%3E">
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=PT+Sans&display=swap" rel="stylesheet">
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Dosis:wght@600&display=swap" rel="stylesheet">
</head>
<body>
    <div id="container">


        <h1>Platforma Szkolna - Projekt</h1>

        <div id="logo">
            <h2 class="logowanie-text">Logowanie:</h2>


            <div id="bcolor">
                
                    <a class="log-btn">Zaloguj się!</a>
                    <div class="log" style="<?php
					if(isset($_SESSION['rozwLog']) && $_SESSION['rozwLog'] == true)
					{
						echo "display: block";
						unset($_SESSION['rozwLog']);
					}else
					{
						echo "display: none";
					}
					?>">
                        <form action="php/procesLogowania.php" method="POST">
                                <a>Login:</a> <input type="text" name="login" value="<?php
							if(isset($_SESSION['fr_loginLog']))
							{
								echo $_SESSION['fr_loginLog'];
								unset($_SESSION['fr_loginLog']);
							}
							?>">
								
                                <a>Hasło:</a> <input type="password" name="haslo" id="haslo">
								<?php
						if(isset($_SESSION['blad']))
						{
							echo $_SESSION['blad'];
							unset($_SESSION['blad']);
						}
					?>
								<br>
                            <input type="submit" value="Zaloguj się">
                        </form>
                    </div>

                </br>
					
                    <a class="reg-btn">Zarejestruj się!</a>
                    <div class="reg " style="<?php
					if(isset($_SESSION['rozwRej']) && $_SESSION['rozwRej'] == true)
					{
						echo "display: block";
						unset($_SESSION['rozwRej']);
					}else
					{
						echo "display: none";
					}
					?>">
						<form method="POST">
						
							<a>Imię:</a> <input type="text" value="<?php
							if(isset($_SESSION['fr_imie']))
							{
								echo $_SESSION['fr_imie'];
								unset($_SESSION['fr_imie']);
							}
							?>" name="imieReg"> 

                            <a>Nazwisko:</a> <input type="text" value="<?php
							if(isset($_SESSION['fr_nazwisko']))
							{
								echo $_SESSION['fr_nazwisko'];
								unset($_SESSION['fr_nazwisko']);
							}
							?>" name="nazwiskoReg"> 

							<a>Adres:</a> <input type="text" value="<?php
							if(isset($_SESSION['fr_adres']))
							{
								echo $_SESSION['fr_adres'];
								unset($_SESSION['fr_adres']);
							}
							?>" name="adresReg"> 
							
							
							<?php
							if(isset($_SESSION['error_Ina']))
							{
								echo '<div class="error">'.$_SESSION['error_Ina'].'</div>';
								unset($_SESSION['error_Ina']);
							}
							?>

							<a>Email:</a> <input type="email" value="<?php
							if(isset($_SESSION['fr_email']))
							{
								echo $_SESSION['fr_email'];
								unset($_SESSION['fr_email']);
							}
							?>" name="emailReg"> 

							<?php
							if(isset($_SESSION['error_email']))
							{
								echo '<div class="error">'.$_SESSION['error_email'].'</div>';
								unset($_SESSION['error_email']);
							}
							?>
                            <a>Login:</a> <input type="text" value="<?php
							if(isset($_SESSION['fr_login']))
							{
								echo $_SESSION['fr_login'];
								unset($_SESSION['fr_login']);
							}
							?>" name="loginReg"> 
							<?php
							if(isset($_SESSION['error_login']))
							{
								echo '<div class="error">'.$_SESSION['error_login'].'</div>';
								unset($_SESSION['error_login']);
							}
							?>
                            <a>Hasło:</a> <input type="password" name="haslo1"> 
							<?php
							if(isset($_SESSION['error_haslo']))
							{
								echo '<div class="error">'.$_SESSION['error_haslo'].'</div>';
								unset($_SESSION['error_haslo']);
							}
							?>
                            <a>Powtórz hasło:</a> <input type="password" name="haslo2"> 
							<br>
							<label>
							<input type="radio" name="uN" value="uczen" <?php
							if(isset($_SESSION['fr_uN']))
							{
								if($_SESSION['fr_uN']=="uczen")
								{
								echo "checked";
								unset($_SESSION['fr_uN']);
								}
							}
							?>>Uczeń
							</label>
							<label>
							<input type="radio" name="uN" value="nauczyciel" <?php
							if(isset($_SESSION['fr_uN']))
							{
								if($_SESSION['fr_uN']=="nauczyciel")
								{
								echo "checked";
								unset($_SESSION['fr_uN']);
								}
							}
							?>>Nauczyciel
							</label>
							<?php
							if(isset($_SESSION['error_wybor']))
							{
								echo '<div class="error">'.$_SESSION['error_wybor'].'</div>';
								unset($_SESSION['error_wybor']);
							}
							?>
                            <input type="submit" value="Zarejestruj się">
						</form>
                    </div>

            </div>

        </div>



        <div id="stopka">
            PLAN LEKCJI &copy; Praktyka gr2
        </div>


    </div>
<br>

</body>
</html>