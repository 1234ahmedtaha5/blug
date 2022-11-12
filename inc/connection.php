<?php
session_start();
$localhost="localhost";
$user="root";
$pass="";
$db_name="blog";
$conn=mysqli_connect($localhost,$user,$pass,$db_name);