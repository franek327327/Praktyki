<?php

$a = trim($_GET['a']);
$id = trim($_GET['id']);

if($a == 'del' and !empty($id)) {
    
    mysqli_query("DELETE FROM test WHERE id='$id'")
    or die('Błąd zapytania: '.mysql_error());
    
    echo 'Rekord został usunęty z bazy';
}

?> 