<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "Traveling";

$conn = mysqli_connect($host, $username, $password, $database);

if(!$conn){
  die("connection failed " . mysqli_connect_error());
}
?>