<?php
//$file = $_POST;
//$data = json_decode(file_get_contents('php://input'), true);
$q = $_REQUEST["q"];
$inputArray = explode("_", $q);
$name = $inputArray[0];
$length = $inputArray[1];
$genre = $inputArray[2];
$UID = $inputArray[3];
$AID = $inputArray[4];
$GID = $inputArray[5];
$ALID = $inputArray[6];
$ORID = $inputArray[7];
$TRID = $inputArray[8];

$con = mysqli_connect('127.0.0.1',  "Lumenebrae", 'bombkirby9bombkirby9', 'remixdbz');
if (!$con) {
    die('Not connected : ' . mysqli_connect_error());
}

mysqli_begin_transaction($con);
try {
    mysqli_query($con,"SET SESSION TRANSACTION ISOLATION LEVEL READ COMMITTED");
    //$query = "SELECT MAX(TID) FROM track";
    //$result = mysqli_query($con, $query);
    //if (!$result) {
    //    return "could not get maxID";
    //}

    //$row = @mysqli_fetch_assoc($result);
    //$TID = $row['MAX(TID)'] + 1;


//$trackArt = $data['imageString'];
    //$query = "INSERT INTO track (TID, Name, Length, Genre, UID)
    //      VALUES
    //      ('".$TID."',
    //       '".$name."',
    //       '".$length."',
    //       '".$genre."',
    //       '".$UID."')";
    $query = "CALL MasterAddTrack('".$name."','".$length."','".$genre."',".$UID.",'".$AID."','".$GID."','".$ALID."','".$ORID."','".$TRID."')";
    $result = mysqli_query($con, $query);
        mysqli_commit($con);
} catch (mysqli_sql_exception $exception){
    mysqli_rollback($con);
    throw $exception;
}

header('Access-Control-Allow-Origin: *');
//header('Content-Type: text/xml');

echo $result;

$con->close();