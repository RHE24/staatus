<?php
/*

Üldine konfiguratsioon

*/

$andmebaas['host'] = "localhost";
$andmebaas['database'] = "";
$andmebaas['user'] = "";
$andmebaas['password'] = "";

/*
Andmebaasi prefiks:
* mcs_
* s_

ilma prefiksita:
* users

# $con->prepare('SELECT * FROM '.[prefiks].' WHERE id = :id');

*/

try {
    $con = new PDO('mysql:host='.$andmebaas['host'].';dbname='.$andmebaas['database'].'', $andmebaas['user'], $andmebaas['password']);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo 'TÕRGE: ' . $e->getMessage();
}

//unset($andmebaas['password']);

?>