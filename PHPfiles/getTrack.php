<?php
$q = $_REQUEST["q"];

$connection=mysqli_connect ('127.0.0.1', "newuser", '', 'cs348');
if (!$connection) {
    die('Not connected : ' . mysqli_connect_error());
}

$query = "select * from track where TID=".$q;

$result = mysqli_query($connection, $query);
if (!$result) {
    die('Invalid query: ' . mysqli_error($connection));
}

$row = @mysqli_fetch_assoc($result);

header('Access-Control-Allow-Origin: *');
header("Content-type: text/xml");
echo "<?xml version='1.0' ?>";
echo '<info>';
echo '<track ';
echo 'title="' . $row['Name'] . '" ';
echo 'length="' . $row['Length'] . '" ';
echo 'genre="' . $row['Genre'] . '" ';
echo '/>';
echo '</info>';
$connection->close();

