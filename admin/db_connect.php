<?php 

$conn= new mysqli('localhost','root','','ems_db')or die("Could not connect to mysql".mysqli_error($con));

if(!$conn)
{
    die("Connection failed: " . mysqli_connect_error());
}
?>