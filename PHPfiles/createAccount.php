<?php
// Get the q parameter from URL
$q = $_REQUEST["q"];
$inputArray = explode("_", $q);
$username = $inputArray[0];
$password = $inputArray[1];
$name = $inputArray[2];
$email = $inputArray[3];


// Opens a connection to a MySQL server
$connection=mysqli_connect ('127.0.0.1', "newuser", '', 'cs348');
if (!$connection) {
    die('Not connected : ' . mysqli_connect_error());
}

$query = "SELECT MAX(UID) FROM user";
$result = mysqli_query($connection, $query);
if (!$result) {
    return "could not get maxID";
}

$row = @mysqli_fetch_assoc($result);
$userID = $row['MAX(userID)'] + 1;

// Query for inserting a new user
$query = "INSERT INTO user (UID, UserName, Password, Realname, Email)
          VALUES 
          ('".$userID."',
           '".$username."',
           '".$password."',
           '".$name."',
           '".$email."')";

// Insert the user and recive a response
if ($connection->query($query) === TRUE) {
    echo "Inserted user succesfully";
} else {
    echo "Error inserting user: " . $connection->error;
}
?>