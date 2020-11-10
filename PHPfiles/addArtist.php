<?php
//$file = $_POST;
//$data = json_decode(file_get_contents('php://input'), true);
$q = $_REQUEST["q"];
$inputArray = explode("_", $q);


$con = mysqli_connect('127.0.0.1', "newuser", '', 'cs348');
if (!$con) {
    die('Not connected : ' . mysqli_connect_error());
}

$query = "SELECT MAX(TID) FROM track";
$result = mysqli_query($con, $query);
if (!$result) {
    return "could not get maxID";
}

$row = @mysqli_fetch_assoc($result);
$AID = $row['MAX(AID)'] + 1;


$query = "INSERT INTO track (AID, Name)
          VALUES 
          ('".$AID."',
           '".$q."')";

$result = mysqli_query($con, $query);
if (!$result) {
    die('Invalid query: ' . mysqli_error($con));
}
header('Access-Control-Allow-Origin: *');
header('Content-Type: text/xml');
echo $result;
$con->close();