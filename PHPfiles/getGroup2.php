<?php
$q = $_REQUEST["q"];

$connection = mysqli_connect('127.0.0.1', "newuser", '', 'cs349');
if (!$connection) {
    die('Not connected : ' . mysqli_connect_error());
}

//retrieve artist data
$query = "select * from bandgroups where GID= ".$q;
$resultT = mysqli_query($connection, $query);
if (!$resultT) { #does this differentiate between null and empty? the answer: it does not.
    die('Invalid query: ' . mysqli_error($connection));
}

//retrieve associated artists
$query = "select distinct a.Name, a.AID from artists as a join member on a.AID = member.AID where member.GID ='".$q."'";
$result1 = mysqli_query($connection, $query);


//retrieve associated tracks
$query = "select * from track where TID in (select TID from trackcreditgroup where GID=".$q.")";
$result2 = mysqli_query($connection, $query);


//retrieve associated albums
$query = "select distinct a.Name, a.ALID from albums as a where a.GID = '".$q."'";
$result3 = mysqli_query($connection, $query);


$row = @mysqli_fetch_assoc($resultT);

header('Access-Control-Allow-Origin: *');
header("Content-type: text/xml");

echo "<?xml version='1.0' ?>";
echo '<info>';
echo '<group ';
echo 'GID="' . $row['GID'] . '" ';
echo 'name="' . $row['Name'] . '" ';
echo 'yearformed="' . $row['YearFormed'] . '" ';
echo 'type="' . $row['type'] . '" ';
echo '/>';

//iterate through artists
if ($result1) {
    while ($row = @mysqli_fetch_assoc($result1)){
        // Add to XML document node
        echo '<artist ';
        echo 'name="' . $row['Name'] . '" ';
        echo 'AID="' . $row['AID'] . '" ';
        echo '/>';
    }
}

//iterate through track
if ($result2) {
    while ($row = @mysqli_fetch_assoc($result2)){
        // Add to XML document node
        echo '<track ';
        echo 'title="' . $row['Name'] . '" ';
        echo 'TID="' . $row['TID'] . '" ';
        echo '/>';

    }
}

//iterate through albums
if ($result3) {
    while ($row = @mysqli_fetch_assoc($result3)){
        // Add to XML document node
        echo '<album ';
        echo 'ALID="' . $row['ALID'] . '" ';
        echo 'name="' . $row['Name'] . '" ';
        echo '/>';
    }
}

// End XML file
echo '</info>';
$connection->close();
