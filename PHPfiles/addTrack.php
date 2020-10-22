<?php
//$file = $_POST;
//$data = json_decode(file_get_contents('php://input'), true);
$q = $_REQUEST["q"];
$inputArray = explode("_", $q);
$name = $inputArray[0];
$length = $inputArray[1];
$genre = $inputArray[2];
$UID = $inputArray[3];

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
$TID = $row['MAX(TID)'] + 1;


//$trackArt = $data['imageString'];
if (1/*strpos($trackArt, '<<>>') !== false*/) {
    $query = "INSERT INTO track (TID, Name, Length, Genre, UID)
          VALUES 
          ('".$TID."',
           '".$name."',
           '".$length."',
           '".$genre."',
           '".$UID."')";
} else {
    $query = "INSERT INTO track (TID, Name, Length, Genre, UID)
          VALUES 
          ('".$TID."',
           '".$name."',
           '".$length."',
           '".$genre."',
           '".$UID."')";
}
$result = mysqli_query($con, $query);
if (!$result) {
    die('Invalid query: ' . mysqli_error($con));
}
header('Access-Control-Allow-Origin: *');
header('Content-Type: text/xml');
echo $result;
$con->close();