<?php
$q = $_REQUEST["q"];


//creating a new connection object using mysqli
$connection = mysqli_connect('127.0.0.1', "Lumenebrae", 'bombkirby9bombkirby9', 'cs350');
if (!$connection) {
    die('Not connected : ' . mysqli_connect_error());
}

//if there is some error connecting to the database
//with die we will stop the further execution by displaying a message causing the error
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}




$query = "SELECT track.TID, track.Name, track.UID, track.Length, track.Genre from track join usertracks on track.TID = usertracks.TID where usertracks.UID ='".$q."'";

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
    echo 'UID="' . $row['UID'] . '" ';
    echo 'Length="' . $row['Length'] . '" ';
    echo 'Genre="' . $row['Genre'] . '" ';
    echo '/>';
    $ind = $ind + 1;
}

// End XML file
echo '</tracks>';
$connection->close();
