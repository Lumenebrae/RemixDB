<?php
$q = $_REQUEST["q"];

$connection=mysqli_connect ('127.0.0.1', "newuser", '', 'cs348');
if (!$connection) {
    die('Not connected : ' . mysqli_connect_error());
}
//retrieve track data
$query = "select * from albums where ALID=".$q;
$result1 = mysqli_query($connection, $query);


//retrieve associated artists
$query = "select distinct artistName from artists join trackcreditartist on artists.AID = trackcreditartist.AID join albumtracks on trackcreditartist.TID = albumtracks.TID where albumtracks.ALID = '".$q."'";
$result2 = mysqli_query($connection, $query);

//retrieve associated groups
$query = "select distinct title from bandgroups join trackcreditgroup on bandgroups.GID = trackcreditgroup.GID join albumtracks on trackcreditgroup.TID = albumtracks.TID where albumtracks.ALID ='".$q."'";
$result3 = mysqli_query($connection, $query);



//retrieve associated remixes. Should use a join later to access transformation type and artist
$query = "select TrackNumber, Name from track join albumtracks on track.TID = albumtracks.TID where albumtracks.ALID = '".$q."' order by TrackNumber ASC";
$result4 = mysqli_query($connection, $query);

//retrieve associated sources. Should use a join later to access transformation type and artist


$row = @mysqli_fetch_assoc($result1);

header('Access-Control-Allow-Origin: *');
header("Content-type: text/xml");

echo "<?xml version='1.0' ?>";
echo '<info>';
echo '<album ';
echo 'ALID="' . $row['ALID'] . '" ';
echo 'name="' . $row['albumName'] . '" ';
echo '/>';


if ($result2) {
    while ($row = @mysqli_fetch_assoc($result2)){
        // Add to XML document node
        echo '<artist ';
        echo 'artistName="' . $row['artistName'] . '" ';
        echo '/>';
    }
}

//iterate through groups
if ($result3) {
    while ($row = @mysqli_fetch_assoc($result3)){
        // Add to XML document node
        echo '<group ';
        echo 'name="' . $row['title'] . '" ';
        echo '/>';
    }
}

if ($result4) {
    while ($row = @mysqli_fetch_assoc($result4)){
        // Add to XML document node
        echo '<track ';
        echo 'title="' . $row['Name'] . '" ';
        echo '/>';

    }
}

//iterate through remixes


// End XML file
echo '</info>';
$connection->close();

