<?php
//$file = $_POST;
//$data = json_decode(file_get_contents('php://input'), true);
$q = $_REQUEST["q"];
$inputArray = explode("_", $q);

$con = mysqli_connect('127.0.0.1', "Lumenebrae", 'bombkirby9bombkirby9', 'cs350');
if (!$con) {
    die('Not connected : ' . mysqli_connect_error());
}


mysqli_begin_transaction($con);
try {
    mysqli_query($con,"SET SESSION TRANSACTION ISOLATION LEVEL READ COMMITTED");

    $query = "SET @id = ''"; //create output variable
    mysqli_query($con, $query);
    $query = "CALL MasterAddArtist('".$inputArray[0]."', @id)";
    mysqli_query($con, $query);
    $query = "SELECT @id AS id"; // fetch the output variable
    $result = mysqli_query($con, $query);
    $row = @mysqli_fetch_assoc($result);
    mysqli_commit($con);

    //send the artistID back
    header('Access-Control-Allow-Origin: *');
    header("Content-type: text/xml");
    echo "<?xml version='1.0' ?>";
    echo '<info>';
    echo '<id ';
    echo 'id="' . $row['id'] . '" ';
    echo '/>';
    echo '</info>';

} catch (mysqli_sql_exception $exception){
    mysqli_rollback($con);
    throw $exception;
}
$con->close();