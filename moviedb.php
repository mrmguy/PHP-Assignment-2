<?php
  error_reporting(E_ALL);
  ini_set('display-errors', 'On');
$mysqli = new mysqli("localhost", "root", "", "trialdb");
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

$sqt = "CREATE TABLE video_store (
    id int AUTO_INCREMENT PRIMARY KEY,
    name varchar(255) NOT NULL UNIQUE,
    category varchar(255),
    length int,
    rented bool NOT NULL DEFAULT 1
    );";

if (!$mysqli->query('DESCRIBE video_store')) {

/* Non-prepared statement */
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


// select categories for drop down menu
if (!($stmt2 = $mysqli->prepare("SELECT category FROM video_store"))) {
    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
}

if (!$stmt2->execute()) {
    echo "Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
}
$categorylist = NULL;
if (!$stmt2->bind_result($categorylist)) {
    echo "Binding output parameters failed: (" . $stmt->errno . ") " . $stmt->error;
}

echo '<form action="changetable.php" method="get">';
echo '<select name = "categories">';
while ($stmt2->fetch()) {
    echo '<option value = "' . $categorylist . '">' . $categorylist . '</option>';
}
echo '<input type = "submit">';
echo '</form>';




// select films to list in table
if (!($stmt = $mysqli->prepare("SELECT name, category, length, rented FROM video_store"))) {
    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
}

if (!$stmt->execute()) {
    echo "Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
}

$name    = NULL;
$category = NULL;
$minutes = NULL;
$rented = NULL;
$available = NULL;
$check = NULL;
if (!$stmt->bind_result($name, $category, $minutes, $rented)) {
    echo "Binding output parameters failed: (" . $stmt->errno . ") " . $stmt->error;
}


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

// /* Prepared statement, stage 1: prepare */
// if (!($stmt = $mysqli->prepare("INSERT INTO video_store(name, category, length) VALUES (?, ?, ?)"))) {
//      echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
// }

// /* Prepared statement, stage 2: bind and execute */
// $name = 'test';
// $category = 'comedy';
// $length = 120;
// if (!$stmt->bind_param("ssi", $name, $category, $length)) {
//     echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
// }

// if (!$stmt->execute()) {
//     echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
// }

// // /* Prepared statement: repeated execution, only data transferred from client to server */
// // for ($id = 2; $id < 5; $id++) {
// //     if (!$stmt->execute()) {
// //         echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
// //     }
// // }

// // /* explicit close recommended */
// // $stmt->close();

// // /* Non-prepared statement */
// // $res = $mysqli->query("SELECT id FROM test");
// // var_dump($res->fetch_all


$mysqli->close();
?>