<?php
$server='localhost'
$dbname='gara';
$username='root';
$password='';
try{
$conn=new PDO("mysql:host=$server;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
echo 'connected successfully';
}catch{$e}
?>