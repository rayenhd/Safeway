<?php

$host = 'localhost';
$user = 'root';
$passwrd = '';
$dbname = 'webtest';

$connect = mysqli_connect($host, $user, $passwrd, $dbname);

if($connect === false){
    die('error in connection' . mysqli_connect_error());
}


try{
    $db = new PDO('mysql:host =' . $host . ';dbname=' . $dbname, $user, '' );
    $db->exec('SET NAMES "UTF8"');
}catch(PDOException $e){
    echo 'Erreur : ' . $e->getMessage();
    die();
}





