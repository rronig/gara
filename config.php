<?php
$dbname='gara';
$username='root';
$password='';
$conn=new mysqli($dbname, $username, $password);
if ($conn->connect_error){
    die("connection failed".$conn->connect_error);
}
echo 'connected successfully';
?>