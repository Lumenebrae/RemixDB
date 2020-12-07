<?php
$q = $_REQUEST["q"];

$connection = mysqli_connect('127.0.0.1', "newuser", '', 'cs348');
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
header("Content-type: text/xml");

// Start XML file, echo parent node
echo "<?xml version='1.0' ?>";
echo '<tracks>';
$ind=0;
// Iterate through the rows, printing XML nodes for each
while ($row = @mysqli_fetch_assoc($result)){
    // Add to XML document node
    echo '<track ';
    echo 'TID="' . $row['TID'] . '" ';
    echo 'Name="' . $row['Name'] . '" ';
    echo 'Length="' . $row['Length'] . '" ';
    echo 'Genre="' . $row['Genre'] . '" ';
    echo 'UID="' . $row['UID'] . '" ';
    echo '/>';
    $ind = $ind + 1;
}

// End XML file
echo '</tracks>';
$connection->close();
