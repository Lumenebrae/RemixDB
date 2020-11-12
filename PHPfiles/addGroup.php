<?php
//$file = $_POST;
//$data = json_decode(file_get_contents('php://input'), true);
$q = $_REQUEST["q"];
$inputArray = explode("_", $q);
$name = $inputArray[0];
$yearFormed = $inputArray[1];
$type = $inputArray[2];

$con = mysqli_connect('127.0.0.1', "newuser", '', 'cs348');
if (!$con) {
    die('Not connected : ' . mysqli_connect_error());
}

$query = "SELECT MAX(GID) FROM groups";
$result = mysqli_query($con, $query);
if (!$result) {
    return "could not get maxID";
}

$row = @mysqli_fetch_assoc($result);
$GID = $row['MAX(GID)'] + 1;



$query = "INSERT INTO groups (GID, Name, YearFormed, Type)
          VALUES 
          ('".$GID."',
           '".$name."',
           '".$yearFormed."',
           '".$type."')";

$result = mysqli_query($con, $query);
if (!$result) {
    die('Invalid query: ' . mysqli_error($con));
}
header('Access-Control-Allow-Origin: *');
header('Content-Type: text/xml');
echo $result;
$con->close();