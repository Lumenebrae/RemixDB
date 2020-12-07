<?php
$q = $_REQUEST["q"];

$connection = mysqli_connect('127.0.0.1', "Lumenebrae", 'bombkirby9bombkirby9', 'cs350');
if (!$connection) {
    die('Not connected : ' . mysqli_connect_error());
}

//retrieve artist data
$query = "select * from artists where AID= ".$q;
$resultT = mysqli_query($connection, $query);
if (!$resultT) { #does this differentiate between null and empty? the answer: it does not.
    die('Invalid query: ' . mysqli_error($connection));
}

//retrieve associated tracks
$query = "select * from track where TID in (select TID from trackcreditartist where AID=".$q.")";
$result1 = mysqli_query($connection, $query);


//retrieve associated groups
$query = "select distinct g.Name from bandgroups as g join member on g.GID = member.GID where member.AID ='".$q."'";
$result2 = mysqli_query($connection, $query);


//retrieve associated albums
$query = "select distinct a.Name from albums as a join artists on a.AID = artists.AID where artists.AID = '".$q."'";
$result3 = mysqli_query($connection, $query);


$row = @mysqli_fetch_assoc($resultT);

header('Access-Control-Allow-Origin: *');
header("Content-type: text/xml");

echo "<?xml version='1.0' ?>";
echo '<info>';
echo '<artist ';
echo 'AID="' . $row['AID'] . '" ';
echo 'name="' . $row['Name'] . '" ';
echo '/>';

//iterate through track
if ($result1) {
    while ($row = @mysqli_fetch_assoc($result1)){
        // Add to XML document node
        echo '<track ';
        echo 'title="' . $row['Name'] . '" ';
        echo '/>';

    }
}

//iterate through groups
if ($result2) {
    while ($row = @mysqli_fetch_assoc($result2)){
        // Add to XML document node
        echo '<group ';
        echo 'GID="' . $row['GID'] . '" ';
        echo 'name="' . $row['Name'] . '" ';
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