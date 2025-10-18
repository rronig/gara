<?php
$server='localhost';
$dbname='investkosovo';
$db_username='pmauser';
$db_password='Mysql1.';
try{
$pdo=new PDO("mysql:host=$server;dbname=$dbname", $db_username, $db_password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
    die("Error: " . $e->getMessage());
}
?>
