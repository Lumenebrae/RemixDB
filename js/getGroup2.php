<?php
$q = $_REQUEST["q"];

$connection=mysqli_connect ('127.0.0.1', "newuser", '', 'cs348');
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
$query = "select distinct artistName from artists join trackcreditgroup on artists.AID = trackcreditgroup.AID join bandgroups on trackcreditgroup.GID = bandgroups.GID where bandgroups.GID ='".$q."'";
$result1 = mysqli_query($connection, $query);


//retrieve associated tracks
$query = "select * from tracks where TID in (select TID from trackcreditartist where GID=".$q.")";
$result2 = mysqli_query($connection, $query);


//retrieve associated albums
$query = "select distinct albumName from albumtracks join albumtracks on trackcreditartist.TID = albumtracks.TID join bandgroups on bandgroups.GID = trackcreditartist.GID where bandgroups.GID = '".$q."'";
$result3 = mysqli_query($connection, $query);


$row = @mysqli_fetch_assoc($resultT);

header('Access-Control-Allow-Origin: *');
header("Content-type: text/xml");

echo "<?xml version='1.0' ?>";
echo '<info>';
echo '<track ';
echo 'AID="' . $row['GID'] . '" ';
echo 'name="' . $row['Name'] . '" ';
echo '/>';

//iterate through artists
if ($result1) {
    while ($row = @mysqli_fetch_assoc($result2)){
        // Add to XML document node
        echo '<artist ';
        echo 'artistName="' . $row['artistName'] . '" ';
        echo '/>';
    }
}

//iterate through tracks
if ($result1) {
    while ($row = @mysqli_fetch_assoc($result1)){
        // Add to XML document node
        echo '<track ';
        echo 'title="' . $row['Name'] . '" ';
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