<?php
    session_start();
    require "polaczenieZBaza.php";

    if(!isset($_SESSION['zalogowany']) || (isset($_SESSION['funkcja']) && $_SESSION['funkcja'] != 0))
    {
        header('Location:../index.php');
        exit();
    } 

    $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
    if(isset($_POST['edycjaDanych']))
    {
        $_SESSION['edycjaDanych'] = 1;
    }
    // Zapisywanie danych z edycji do bazy danych
    if (isset($_POST['zapisz']))
        {
            $ok = true;
            $imie=$_POST['imieEdit'];
            $nazwisko=$_POST['nazwiskoEdit'];
            $login=$_POST['loginEdit'];
            $email=$_POST['emailEdit'];
            $haslo=$_POST['hasloEdit'];

            //walidacja imienia, nazwiska i adresu
            if(strlen($imie) < 1 || strlen($nazwisko) < 1)
                {
                    $ok=false;
                    $_SESSION['error_Ina']="Nie wpisano imienia lub nazwiska";
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
            if(strlen($haslo)==0)
                {
                    $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
                    $rezultat = $polaczenie->query("SELECT haslo FROM uzytkownicy WHERE id=".$_SESSION['id']);
                    $czyZnaleziono = $rezultat->num_rows;
                    if($czyZnaleziono>0)
                    {   
                        $wiersz = $rezultat->fetch_assoc();
                        $haslo=$wiersz['haslo'];
                    }
                    $rezultat->close();
                    $polaczenie->close();
                }
            else if(strlen($haslo)<5 || (strlen($haslo)>50))
                {
                    {
                        $ok=false;
                        $_SESSION["error_haslo"]="Hasło musi zawierać od 5 do 50 znaków";
                    }

                }
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
                            $rezultat = $polaczenie->query("SELECT id FROM uzytkownicy WHERE email='$email' AND id <> ".$_SESSION['id']);
                            if(!$rezultat) throw new Exception($polaczenie->error);
                            
                            $ileMaili = $rezultat->num_rows;
                            if($ileMaili>0)
                            {
                                $ok=false;
                                $_SESSION['error_email']="Podany email już istnieje w bazie";
                            }
                            $rezultat->close();
                            
                            //czy login istnieje
                            $rezultat = $polaczenie->query("SELECT id FROM uzytkownicy WHERE BINARY login='$login' AND id <> ".$_SESSION['id']);
                            if(!$rezultat) throw new Exception($polaczenie->error);
                            
                            $ileLogin = $rezultat->num_rows;
                            if($ileLogin>0)
                            {
                                $ok=false;
                                $_SESSION['error_login']="Podany login już istnieje w bazie";
                            }
                            if($ok==true)
                            {
                                if($polaczenie->query("UPDATE uzytkownicy SET imie='$imie', nazwisko='$nazwisko', email='$email', login='$login', haslo='$haslo' WHERE id=".$_SESSION['id']))
                                {
                                    $_SESSION['rejestracjaUdana']=true;
                                    unset($_SESSION['edycjaDanych']);
                                }else
                                {
                                    throw new Exception($polaczenie->error);
                                }
                            }
                            
                            
                        }
                    }
                catch(Exception $e)
                    {
                        echo '<div class="error">Błąd serwera</div>';
                    }
        }
    // Zaaktualizowanie danych z bazy danych w zmiennych sesyjnych
    if($rezultat = @$polaczenie->query("SELECT * FROM uzytkownicy WHERE id=".$_SESSION['id']))
        {
            $czyZnaleziono = $rezultat->num_rows;
            if($czyZnaleziono>0)
            {
                $wiersz = $rezultat->fetch_assoc();
                $_SESSION['login'] = $wiersz['login'];
                $_SESSION['idKlasy'] = $wiersz['IdKlasa'];
                $_SESSION['email'] = $wiersz['email'];
                $_SESSION['imie'] = $wiersz['imie'];
                $_SESSION['nazwisko'] = $wiersz['nazwisko'];
                $_SESSION['funkcja'] = $wiersz['funkcja'];
                
                $rezultat->close();
            }
        }
    
    // Sprawdzanie czy użytkownik jest zalogowany i ma dobrą funkcję    
    if(!isset($_SESSION['zalogowany']) || (isset($_SESSION['funkcja']) && $_SESSION['funkcja'] != 0))
        {
            header('Location:../index.php');
            exit();
        } 
    // Zamiana id klasy na nazwę klasy
    if(isset($_SESSION['idKlasy']))
        {


            $rezultat = $polaczenie->query("SELECT id, klasa FROM klasy");


            if ($rezultat->num_rows > 0) 
            {
                while($wierszKlas = $rezultat->fetch_assoc()) 
                {
                    
                    if($_SESSION['idKlasy'] == $wierszKlas['id'])
                    {
                        $_SESSION['klasa'] = $wierszKlas['klasa'];
                    }
                }
                $rezultat->close();
            }


        }

    




?>


<!DOCTYPE HTML>
<html lang="pl">

<head>
    <meta charset="utf-8" />
    <title>Uczeń</title>
    <link rel="stylesheet" href="../css/style1.css">
    <script src="../js/app1.js" defer></script>
    <meta http-equiv="content-type" content="text/html; charset=ISO-8859-2">
    <link rel="preconnect" href="https://fonts.gstatic.com/%22%3E">
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=PT+Sans&display=swap" rel="stylesheet">
</head>

<body>


    <h1>Platforma Szkolna - Uczeń</h1>
   <div id="Menu">
    <ul class="blink-text-menu tab">
        <li class="tab-el">
            <a href="#profil">Profil</a>
        </li>
        <li class="tab-el">
            <a href="#plan">Plan</a>
        </li>
		<li class="tab-el">
            <a href="procesWylogowania.php">Wyloguj</a>
        </li>

    </ul>
    </div>
<div class="tab-contents">
    <a class="close">✖</a>
    <div class="tab-content" id="profil">
        <div id="login">
        
            <img src="../img/avatar.png">
            <div class="wyswietlanieDanych"><h2 class="profilText">
            <?php
                echo $_SESSION['imie']." ".$_SESSION['nazwisko'];
            ?>
            </h2>
        </div>
        
        <p> 
        <!-- Wyświetlanie klasy i dołączenie do klasy -->
       <?php 
        

        if(isset($_SESSION['idKlasy']))
            {
            echo "Klasa: ".$_SESSION['klasa'];
            }
        else
            {
                
                echo '<form method="post">';
                echo '<select name="dodanieDoKlasy">';
                
                

                $rezultat = $polaczenie->query("SELECT id, klasa FROM klasy");
                if ($rezultat->num_rows > 0) 
                {
                    while($wierszKlas = $rezultat->fetch_assoc()) 
                    {
                        
                        echo '<option value="' .$wierszKlas['id']. '">' . $wierszKlas["klasa"] ."</option>";        //Rozwijany
                    }
                    $rezultat->close();
                }
                echo "</select>";
                echo '<input  type="submit" name="dolaczanie" value="Dołącz do klasy!"></form>';       //Przycisk
            }



        if(isset($_POST['dolaczanie']))
        {

            if($polaczenie->query("UPDATE uzytkownicy SET IdKlasa=".$_POST['dodanieDoKlasy']." WHERE id=".$_SESSION['id']))
            {
                $_SESSION['idKlasy'] = $_POST['dodanieDoKlasy'];
                header("Refresh:0");
                        
            }else
            {
                echo $_POST['dodanieDoKlasy'];
            }

            unset($_POST);

        }
        
            echo "<br><br>";
            echo "<b>Email:</b> " . $_SESSION['email'];
            echo "<br><br>";
            echo "<b>Login:</b> " . $_SESSION['login'];
        ?>
        
        <form method="post">
        <input type="submit" name="edycjaDanych" value="Edytuj dane"></form>
  
       </p>
    </div>
    <div class="edytowanieDanych" style="display:none">
        <p>
        <form method="post">  
            
        <!-- Edytowanie Danych użytkownika -->
        
        <div id="dane">
            <div class="tlo">
            <b> Imie:</b> 
            <input type="text" value="<?php
                    if(isset($_SESSION['imie']))
                    {
                        echo $_SESSION['imie'];
                    }
            ?>" name="imieEdit">
            <br>
            <b>Nazwisko:</b>
            <input type="text" value="<?php
                    if(isset($_SESSION['nazwisko']))
                    {
                        echo $_SESSION['nazwisko'];
                    }
            ?>" name="nazwiskoEdit">
                <?php
                    if(isset($_SESSION['error_Ina']))
                        {
                            echo '<div class="error">'.$_SESSION['error_Ina'].'</div>';
                            unset($_SESSION['error_Ina']);
                        }
                ?>
            <br>
            <b>Email:</b>
            <input type="email" value="<?php
                    if(isset($_SESSION['email']))
                    {
                        echo $_SESSION['email'];
                    }
            ?>" name="emailEdit">
            <?php
                    if(isset($_SESSION['error_email']))
                        {
                            echo '<div class="error">'.$_SESSION['error_email'].'</div>';
                            unset($_SESSION['error_email']);
                        }
                ?>
            <br>
                    <b> Login:</b>
            <input type="text" value="<?php
                    if(isset($_SESSION['login']))
                    {
                        echo $_SESSION['login'];
                    }
            ?>" name="loginEdit">
                <?php
                    if(isset($_SESSION['error_login']))
                        {
                            echo '<div class="error">'.$_SESSION['error_login'].'</div>';
                            unset($_SESSION['error_login']);
                        }
                ?>
            <br>
            
                    <b>Haslo:</b>
            <input type="password"  name="hasloEdit">
            <?php
                    if(isset($_SESSION['error_haslo']))
                        {
                            echo '<div class="error">'.$_SESSION['error_haslo'].'</div>';
                            unset($_SESSION['error_haslo']);
                        }
                ?>
            <br>
            <u> <input type="submit" name="zapisz" value="Zapisz!"></u>
                    </div>
            </form>
            </p>
            </div>
        </div>
    </div>
    <div class="tab-content" id="plan">
       <?php
            $lekcje1 = 
            "SELECT slownik.przedmiot, dni.dzien, godzinylekcyjne.godzina, sale.sala, klasy.klasa, plan.IdGodzinaLekcyjna, plan.IdPrzedmiot, plan.IdSala, plan.IdDzien
            FROM slownik slownik, dni dni, godzinylekcyjne godzinylekcyjne, sale sale, klasy klasy, plan plan
            where plan.IdPrzedmiot = slownik.id and plan.IdDzien = dni.id and plan.IdGodzinaLekcyjna = godzinylekcyjne.id and plan.IdSala = sale.id and plan.IdKlasa = klasy.id and plan.IdKlasa = ".$_SESSION['idKlasy']." AND plan.IdDzien = 1
            ORDER BY plan.idGodzinaLekcyjna ASC";
        
            $lekcje2 = 
            "SELECT slownik.przedmiot, dni.dzien, godzinylekcyjne.godzina, sale.sala, klasy.klasa, plan.IdGodzinaLekcyjna, plan.IdPrzedmiot, plan.IdSala, plan.IdDzien
            FROM slownik slownik, dni dni, godzinylekcyjne godzinylekcyjne, sale sale, klasy klasy, plan plan
            where plan.IdPrzedmiot = slownik.id and plan.IdDzien = dni.id and plan.IdGodzinaLekcyjna = godzinylekcyjne.id and plan.IdSala = sale.id and plan.IdKlasa = klasy.id and plan.IdKlasa = ".$_SESSION['idKlasy']." AND plan.IdDzien = 2
            ORDER BY plan.idGodzinaLekcyjna ASC";
        
            $lekcje3 = 
            "SELECT slownik.przedmiot, dni.dzien, godzinylekcyjne.godzina, sale.sala, klasy.klasa, plan.IdGodzinaLekcyjna, plan.IdPrzedmiot, plan.IdSala, plan.IdDzien
            FROM slownik slownik, dni dni, godzinylekcyjne godzinylekcyjne, sale sale, klasy klasy, plan plan
            where plan.IdPrzedmiot = slownik.id and plan.IdDzien = dni.id and plan.IdGodzinaLekcyjna = godzinylekcyjne.id and plan.IdSala = sale.id and plan.IdKlasa = klasy.id and plan.IdKlasa = ".$_SESSION['idKlasy']." AND plan.IdDzien = 3
            ORDER BY plan.idGodzinaLekcyjna ASC";
        
            $lekcje4 = 
            "SELECT slownik.przedmiot, dni.dzien, godzinylekcyjne.godzina, sale.sala, klasy.klasa, plan.IdGodzinaLekcyjna, plan.IdPrzedmiot, plan.IdSala, plan.IdDzien
            FROM slownik slownik, dni dni, godzinylekcyjne godzinylekcyjne, sale sale, klasy klasy, plan plan
            where plan.IdPrzedmiot = slownik.id and plan.IdDzien = dni.id and plan.IdGodzinaLekcyjna = godzinylekcyjne.id and plan.IdSala = sale.id and plan.IdKlasa = klasy.id and plan.IdKlasa = ".$_SESSION['idKlasy']." AND plan.IdDzien = 4
            ORDER BY plan.idGodzinaLekcyjna ASC";
        
            $lekcje5 = 
            "SELECT slownik.przedmiot, dni.dzien, godzinylekcyjne.godzina, sale.sala, klasy.klasa, plan.IdGodzinaLekcyjna, plan.IdPrzedmiot, plan.IdSala, plan.IdDzien
            FROM slownik slownik, dni dni, godzinylekcyjne godzinylekcyjne, sale sale, klasy klasy, plan plan
            where plan.IdPrzedmiot = slownik.id and plan.IdDzien = dni.id and plan.IdGodzinaLekcyjna = godzinylekcyjne.id and plan.IdSala = sale.id and plan.IdKlasa = klasy.id and plan.IdKlasa = ".$_SESSION['idKlasy']." AND plan.IdDzien = 5
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
                    $rezultat->close();
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
       ?>
    </div>
</div>
</div>
    <div id="stopka">
        PLAN LEKCJI &copy; Praktyka gr2
    </div>
    

</body>

</html>
<?php
    $polaczenie->close();
    if(isset($_SESSION['edycjaDanych']))
        {
        
        echo
        '<script type="text/JavaScript">
        const okno = document.querySelector(".tab-contents");
        const profil = document.querySelector("#profil");
        const wyswietlanie = document.querySelector(".wyswietlanieDanych");
        const edytowanie = document.querySelector(".edytowanieDanych");
        okno.classList.add("profilAnim");
        okno.style.display = "block";
        profil.classList.add("tab-content-active");
        wyswietlanie.style.display = "none";
        edytowanie.style.display = "block";
        
        </script>';
        }
        unset($_POST['edycjaDanych']);
?>

