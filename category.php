<?php
session_start();
$_SESSION['category_table'] = $_GET['categories'];
header('Location: moviedb.php');
?>