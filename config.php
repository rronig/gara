<?php
$server='localhost';
$dbname='investkosovo';
$username='root';
$password='';
try{
$pdo=new PDO("mysql:host=$server;dbname=$dbname", $username, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){"error".$e->getMessage();}
?>