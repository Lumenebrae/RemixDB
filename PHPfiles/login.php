<?php

$q = $_REQUEST["q"];
$inputArray = explode("_", $q);
$email = $inputArray[0];
$password = $inputArray[1];

// Opens a connection to a MySQL server
$connection = mysqli_connect('127.0.0.1', "newuser", '', 'cs348');
if (!$connection) {
    die('Not connected : ' . mysqli_connect_error());
}

$query = "SELECT UID, UserName, Password FROM user
    WHERE
        Email = '" . $email . "'";


header('Access-Control-Allow-Origin: *');
header("Content-type: text/xml");


$result = mysqli_query($connection, $query);
if ($connection->query($query) === TRUE) {
    echo "Login Failed, Connection Failed";
    die('Invalid query: ' . mysqli_error($connection));
} else {
    while ($row = $result->fetch_array()) {
        echo $row['userID'] . " " . $row['userName'] . " " . $row['PASSWORD'];
    }
}