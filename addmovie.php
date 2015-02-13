<?php
session_start();
error_reporting(E_ALL);
ini_set('display-errors', 'On');
$testNumber = TRUE;
$mysqli = new mysqli("localhost", "root", "", "trialdb");
if ($mysqli->connect_errno) {
  echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
if (!($stmt = $mysqli->prepare("INSERT INTO video_store(name, category, length) VALUES (?, ?, ?)"))) {
     echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
}

//check that name exists

if (empty($_POST['name'])) {
  echo "Name is a required field";
  echo '<br>';
  $testNumber = False;
  }

//check if minutes valid value
if (!empty($_POST['minutes'])) {
if (!ctype_digit($_POST['minutes'])) {
  echo "length must be a positive number";
  echo '<br>';
  $testNumber = False;
}
}
//check if minutes negative

// if (($_POST['minutes'] < 1)) {
//   echo "length must be positive";
//   echo '<br>';
//   $testNumber = False;
// }

// add movie if valid input parameters

if ($testNumber) {
  $name = $_POST['name'];
  $category = $_POST['category'];
  $minutes = $_POST['minutes'];

  if (!$stmt->bind_param("ssi", $name, $category, $minutes)) {
    echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
  }
  if (!$stmt->execute()) {
    echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
  }
  $mysqli->close();
  header('Location: moviedb.php');
  }
else {
  echo "Click <a href = 'moviedb.php'> here</a> to return to the entry screen and try again";
  $mysqli->close();
}

?>