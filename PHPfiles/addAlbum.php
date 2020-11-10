<?php
//$file = $_POST;
//$data = json_decode(file_get_contents('php://input'), true);
$q = $_REQUEST["q"];
$inputArray = explode("_", $q);
$AID = $inputArray[0];
$GID = $inputArray[1];
$name = $inputArray[2];

$con = mysqli_connect('127.0.0.1', "newuser", '', 'cs348');
if (!$con) {
    die('Not connected : ' . mysqli_connect_error());
}

$query = "SELECT MAX(ALID) FROM Albums";
$result = mysqli_query($con, $query);
if (!$result) {
    return "could not get maxID";
}

$row = @mysqli_fetch_assoc($result);
$ALID = $row['MAX(ALID)'] + 1;


$query = "INSERT INTO albums (ALID, AID, GID, Name)
          VALUES 
          ('".$ALID."',
           '".$AID."',
           '".$GID."',
           '".$name."')";

$result = mysqli_query($con, $query);
if (!$result) {
    die('Invalid query: ' . mysqli_error($con));
}
header('Access-Control-Allow-Origin: *');
header('Content-Type: text/xml');
echo $result;
$con->close();