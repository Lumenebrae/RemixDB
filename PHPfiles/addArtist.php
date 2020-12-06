<?php
//$file = $_POST;
//$data = json_decode(file_get_contents('php://input'), true);
$q = $_REQUEST["q"];
$inputArray = explode("_", $q);


#$con = mysqli_connect('127.0.0.1',  "newuser", '', 'cs348');
$con = mysqli_connect('127.0.0.1',  "Lumenebrae", 'bombkirby9bombkirby9', 'remixdbz');
if (!$con) {
    die('Not connected : ' . mysqli_connect_error());
}


mysqli_begin_transaction($con);
try {
    mysqli_query($con,"SET SESSION TRANSACTION ISOLATION LEVEL READ COMMITTED");

    $query = "SELECT MAX(AID) FROM artists";
    $result = mysqli_query($con, $query);
    $row = @mysqli_fetch_assoc($result);
    $AID = $row['MAX(AID)'] + 1;
    $query = "INSERT INTO artists (Name)
          VALUES ('".$q."')";

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