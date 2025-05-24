<?php
$server='localhost';
$dbname='investkosovo';
$username='root';
$password='';
try{
$conn=new PDO("mysql:host=$server;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){"error".$e->getMessage();}
?>