<?php
session_start();
error_reporting(E_ALL);
ini_set('display-errors', 'On');
include("sqldb.php");

if (!($stmt = $mysqli->prepare("DELETE FROM video_store"))) {
  echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
  }
// if (!$stmt->bind_param()) {
//   echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
//   }
if (!$stmt->execute()) {
  echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
  }
$mysqli->close();
header('Location: moviedb.php');