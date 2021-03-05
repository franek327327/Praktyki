<?php
session_start();
 require_once "polaczenieZBaza.php";

 $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);

    if(!isset($_SESSION['zalogowany']) || (isset($_SESSION['funkcja']) && $_SESSION['funkcja'] != 0))
    {
        header('Location:../index.php');
        exit();
    } 
    // Zamiana id klasy na nazwę klasy
    if(isset($_SESSION['idKlasy']))
    {
        require_once "polaczenieZBaza.php";

        $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);

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
    <title>plan lekcji</title>
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
            <a href="#Klasy">Klasy</a>
        </li>
		<li class="tab-el">
            <a href="procesWylogowania.php">Wyloguj</a>
        </li>

    </ul>
    </div>
<div class="tab-contents">
    <div class="tab-content" id="profil">
        <a class="close">✖</a>
        <img src="../img/avatar.png">
        <h1 class="profilText">
        <?php
            echo $_SESSION['imie']." ".$_SESSION['nazwisko'];
        ?>
        </h1>
        <p> 
       
       <?php 
       // Wyświetlanie klasy i dołączenie do klasy
      

       if(isset($_SESSION['klasa']))
           {
           echo "Klasa: ".$_SESSION['klasa'];
           }
       else
           {
               
               echo '<form method="post" action="uczen.php">';
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
               echo '<input type="submit" name="dolaczanie" value="Dołącz do klasy!"></form>';       //Przycisk
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
        echo "Email: " . $_SESSION['email'];
        echo "<br><br>";
        echo "Login : " . $_SESSION['login'];
        ?>
        <form method="post" action="uczen.php">
        <input type="submit" name="edycjaDanych" value="Edytuj dane"></form>
       
       </p>
    </div>

    <div class="tab-content" id="plan">
        <a class="close">✖</a>
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
    .(isset($GLOBALS['$Lekcja1_1']) ? $GLOBALS['$Lekcja1_1'] : "-").
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
<!-- Dodawanie do istniejącej klasy -->

    <div class="tab-content" id="Klasy">
        <a class="close">✖</a>
        
    </div>
</div>
    <div id="stopka">
        PLAN LEKCJI &copy; Praktyka gr2
    </div>
    

</body>

</html>
<?php
$polaczenie->close();
?>

