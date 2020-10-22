<?php
$q = $_REQUEST["q"];

$connection=mysqli_connect ('127.0.0.1', "newuser", '', 'cs348');
if (!$connection) {
    die('Not connected : ' . mysqli_connect_error());
}

$query = "SELECT * FROM track
WHERE INSTR(Name, '".$q."') > 0";

$result = mysqli_query($connection, $query);
if (!$result) {
    die('Invalid query: ' . mysqli_error($connection));
}


header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// Start XML file, echo parent node
while ($row = @mysqli_fetch_assoc($result)) {
    echo nl2br(json_encode($row)."\r\n");
}
$connection->close();
