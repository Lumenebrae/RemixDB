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

mysqli_begin_transaction($con);
try {
    mysqli_query($con,"SET SESSION TRANSACTION ISOLATION LEVEL READ COMMITTED");

    $query = "SET @id = ''"; //create output variable
    mysqli_query($con, $query);
    if ($AID == "" && $GID == ""){
        $query = "CALL MasterAddAlbum(null, null,'".$name."', @id)";
    }else if($AID == ""){
        $query = "CALL MasterAddAlbum(null,'".$GID."','".$name."', @id)";
    }else if($GID == ""){
        $query = "CALL MasterAddAlbum('".$AID."', null,'".$name."', @id)";
    }else{
        $query = "CALL MasterAddAlbum('".$AID."','".$GID."','".$name."', @id)";
    }
    mysqli_query($con, $query);
    $query = "SELECT @id AS id"; // fetch the output variable
    $result = mysqli_query($con, $query);
    $row = @mysqli_fetch_assoc($result);
    mysqli_commit($con);

    //send the albumID back
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