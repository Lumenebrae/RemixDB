<?php
//$file = $_POST;
//$data = json_decode(file_get_contents('php://input'), true);
$q = $_REQUEST["q"];
$inputArray = explode("_", $q);
$name = $inputArray[0];
$yearFormed = $inputArray[1];
$type = $inputArray[2];
$members = $inputArray[3];

$con = mysqli_connect('127.0.0.1', "newuser", '', 'cs348');
if (!$con) {
    die('Not connected : ' . mysqli_connect_error());
}

mysqli_begin_transaction($con);
try {
    mysqli_query($con,"SET SESSION TRANSACTION ISOLATION LEVEL READ COMMITTED");
    //auto incrementing ids enabled on tables, so no longer need to calculate it.

    $query = "SET @id = ''"; //create output variable
    mysqli_query($con, $query);
    $query = "CALL MasterAddGroup('".$name."','".$yearFormed."','".$type."','".$members."', @id)";
    mysqli_query($con, $query);
    $query = "SELECT @id AS id"; // fetch the output variable
    $result = mysqli_query($con, $query);
    $row = @mysqli_fetch_assoc($result);
    mysqli_commit($con);

    //send the trackID back
    header('Access-Control-Allow-Origin: *');
    header("Content-type: text/xml");
    echo '<id>';
    echo 'id="' . $row['id'] . '" ';
    echo '</id>';

} catch (mysqli_sql_exception $exception){
    mysqli_rollback($con);
    throw $exception;
}

$con->close();