<?php
  //session_start();
  error_reporting(E_ALL);
  ini_set('display-errors', 'On');

  //connect to database

  $mysqli = new mysqli("localhost", "root", "", "trialdb");
  if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
  }

// table creation statement

$sqt = "CREATE TABLE video_store (
    id int AUTO_INCREMENT PRIMARY KEY,
    name varchar(255) NOT NULL UNIQUE,
    category varchar(255),
    length int,
    rented bool NOT NULL DEFAULT 1
    );";

// if table exist do not create

if (!$mysqli->query('DESCRIBE video_store')) {
    if (!$mysqli->query($sqt)) {
        echo "Table creation failed: (" . $mysqli->errno . ") " . $mysqli->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Video Store</title>
</head>
<body>

<!-- form entry to add movie -->

<form action="addmovie.php" method="post">
<fieldset>
	<legend>Enter a Film</legend>
	<p>Name:</p>
    <p><input type="text" name="name"></p>

    <p>Category</p>
    <p><input type="text" name="category"></p>
    
    <p>Length:</p>
    <p><input type="text" name="minutes"></p>
    <p><input type="submit" value = "Add Film"></p>
</fieldset>

</form>

<form action="deleteall.php">
	<input type="submit" value="Delete all films">


</body>
</html>
<?php

// category drop down menu

if (!($stmt2 = $mysqli->prepare("SELECT DISTINCT category FROM video_store ORDER BY category ASC"))) {
  echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
}
if (!$stmt2->execute()) {
  echo "Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
}
$categorylist = NULL;
if (!$stmt2->bind_result($categorylist)) {
  echo "Binding output parameters failed: (" . $stmt->errno . ") " . $stmt->error;
}
echo '<form action="moviedb.php" method="post">';
echo '<select name = "categories">';
while ($stmt2->fetch()) {
  echo '<option value = "' . $categorylist . '">' . $categorylist . '</option>';
}
echo '<option value = "All">All</option>';
echo '<input type = "submit">';
echo '</form>';



$name    = NULL;
$category = NULL;
$minutes = NULL;
$rented = NULL;
$available = NULL;
$check = NULL;
$categories = NULL;

// select films to list in table


// if ($_SERVER["REQUEST_METHOD"] == "POST") {

//   if ($_POST['categories'] != 'All') {


//     // query table with movies from select category

//     if (!($stmt = $mysqli->prepare("SELECT name, category, length, rented FROM video_store WHERE category = ?"))) {
//       echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
//     }
//     $categoryitem = $_POST['categories'];
//     if (!$stmt->bind_param("s", $categoryitem)) {
//       echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
//     }

//     if (!$stmt->execute()) {
//       echo "Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
//     }

//     if (!$stmt->bind_result($name, $category, $minutes, $rented)) {
//       echo "Binding output parameters failed: (" . $stmt->errno . ") " . $stmt->error;
//     }
//   } 

// else {

    //query table with all movies

  if (!($stmt = $mysqli->prepare("SELECT name, category, length, rented FROM video_store"))) {
    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
  }

  if (!$stmt->execute()) {
    echo "Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
  }

  if (!$stmt->bind_result($name, $category, $minutes, $rented)) {
    echo "Binding output parameters failed: (" . $stmt->errno . ") " . $stmt->error;
  }
//}
    
// output table of movies

echo '<p>';
  echo '<table border = 1>';
  echo '<tr><td>name</td><td>category</td><td>length</td><td>availability</td><td></td><td></td></tr>';
while ($stmt->fetch()) {
    if ($rented) { 
        $available = "available";
        $check = "check out";
    } else {
        $available = "checked out";
        $check = "check in";
    }
    echo '<form action ="changemovie.php" method="post">';
    echo '<tr><td>' . $name . '</td><td>' . $category . '</td><td>' . $minutes . '</td><td>' . $available . '</td>
    <input type = "hidden" name = "name" value = "'.$name.'">
    <td><input type="submit" value="Delete"></td>
    <td><input type="submit" name = "check" value="'.$check.'"</td></tr>';
    echo '</form>';
}



$mysqli->close();
?>