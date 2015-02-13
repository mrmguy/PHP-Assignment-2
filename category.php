<?php
session_start();
$_SESSION['category_table'] = $_GET['categories'];
var_dump($_SESSION);
header('Location: moviedb.php');