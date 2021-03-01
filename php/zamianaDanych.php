<?php
$a = trim($_REQUEST['a']);
$id = trim($_GET['id']);

if($a == 'edit' and !empty($id)) {

    $wynik = mysql_query("SELECT * FROM test WHERE
    id='$id'")
    or die('Błąd zapytania');

    if(mysql_num_rows($wynik) > 0) {
  
        $r = mysql_fetch_assoc($wynik);
      
        echo '<form action="index.php" method="post">
        <input type="hidden" name="a" value="save" />
        <input type="hidden" name="id" value="'.$id.'" />
        imię:<br />
        <input type="text" name="imie"
        value="'.$r['imie'].'" /><br />
        e-mail:<br />
        <input type="text" name="email"
        value="'.$r['email'].'" /><br />
        <input type="submit" value="popraw" />
        </form>';
    }
}
elseif($a == 'save') {

    $id = $_POST['id'];
    $imie = trim($_POST['imie']);
    $email = trim($_POST['email']);

    mysql_query("UPDATE test SET imie='$imie',
    email='$email' WHERE id='$id'")
    or die('Błąd zapytania');
    echo 'Dane zostały zaktualizowane';
}
?> 