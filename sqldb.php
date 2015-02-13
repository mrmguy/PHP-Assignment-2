<?php

error_reporting(E_ALL);
  ini_set('display-errors', 'On');
$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "burnstem-db", "O0lEQKSs8rekq3sh", "burnstem-db");
  if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
  }
// $mysqli = new mysqli("localhost", "root", "", "trialdb");
// if ($mysqli->connect_errno) {
//     echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
// }

?>