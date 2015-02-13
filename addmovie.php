<?php
  error_reporting(E_ALL);
  ini_set('display-errors', 'On');
$mysqli = new mysqli("localhost", "root", "", "trialdb");
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
/* Prepared statement, stage 1: prepare */
if (!($stmt = $mysqli->prepare("INSERT INTO video_store(name, category, length) VALUES (?, ?, ?)"))) {
     echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
}

//convert $_POST

//check that all values exist

  foreach ($_POST as $key => $value) {
    if (empty($value)) {
      echo "Missing parameter - " . $key;
      echo '<br>';
      $testNumber = False;
    }
  }

  echo '<br>';

//check if minutes valid value

if (!ctype_digit($_POST['minutes'])) {
      echo $key . " must be a length of minutes";
      echo '<br>';
  }
  
  echo '<br>';


$name = $_POST['name'];
$category = $_POST['category'];
$minutes = $_POST['minutes'];


/* Prepared statement, stage 2: bind and execute */

if (!$stmt->bind_param("ssi", $name, $category, $minutes)) {
    echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
}

if (!$stmt->execute()) {
    echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
}

// /* Prepared statement: repeated execution, only data transferred from client to server */
// for ($id = 2; $id < 5; $id++) {
//     if (!$stmt->execute()) {
//         echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
//     }
// }

// /* explicit close recommended */
// $stmt->close();

// /* Non-prepared statement */
// $res = $mysqli->query("SELECT id FROM test");
// var_dump($res->fetch_all


$mysqli->close();
header('Location: moviedb.php');
?>