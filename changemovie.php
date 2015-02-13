<?php
session_start();
error_reporting(E_ALL);
ini_set('display-errors', 'On');
include("sqldb.php");
$name = $_POST['name']; // get name of movie to take action on

// toggle availability of movie

if (isset($_POST['check'])) {
  if (!($stmt = $mysqli->prepare("UPDATE video_store SET rented = ? WHERE name = ?"))) {
    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
  }
  $check = NULL;
  if ($_POST['check'] === 'check out') {
    $check = 0;
  } else {
    $check = 1;
  }
  if (!$stmt->bind_param("is", $check, $name)) {
    echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
  }
  if (!$stmt->execute()) {
    echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
  }
} else {

// Delete movie from table
  if (!($stmt = $mysqli->prepare("DELETE FROM video_store WHERE name = ?"))) {
    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
  }
  $name = $_POST['name'];
  if (!$stmt->bind_param("s", $name)) {
    echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
  }
  if (!$stmt->execute()) {
     echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
  }
}
$mysqli->close();
header('Location: moviedb.php');
?>