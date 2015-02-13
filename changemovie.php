<?php
  error_reporting(E_ALL);
  ini_set('display-errors', 'On');
$mysqli = new mysqli("localhost", "root", "", "trialdb");
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

$name = $_POST['name']; // get name of movie to take action on

// toggle availability of movie

if (isset($_POST['check'])) {

	/* Prepared statement, stage 1: prepare */
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

	/* Prepared statement, stage 1: prepare */
	if (!($stmt = $mysqli->prepare("DELETE FROM video_store WHERE name = ?"))) {
		echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}

	$name = $_POST['name'];
	echo $name;
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