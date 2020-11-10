<?php
$q = $_REQUEST["q"];

$connection=mysqli_connect ('127.0.0.1', "newuser", '', 'cs348');
if (!$connection) {
    die('Not connected : ' . mysqli_connect_error());
}
//retrieve track data
$query = "select * from track where TID=".$q;
$resultT = mysqli_query($connection, $query);
if (!$resultT) { #does this differentiate between null and empty? the answer: it does not.
    die('Invalid query: ' . mysqli_error($connection));
}

//retrieve associated artists
$query = "select * from artists where AID in (select AID from trackcreditartist where TID=".$q.")";
$resultA = mysqli_query($connection, $query);

//retrieve associated groups
$query = "select * from groups where GID in (select GID from trackcreditgroup where TID=".$q.")";
$resultG = mysqli_query($connection, $query);

//retrieve associated remixes. Should use a join later to access transformation type and artist
$query = "select * from track where TID in (select TransformedID from remix where OriginalID=".$q.")";
$resultR = mysqli_query($connection, $query);

//retrieve associated sources. Should use a join later to access transformation type and artist
$query = "select * from track where TID in (select OriginalID from remix where TransformedID=".$q.")";
$resultS = mysqli_query($connection, $query);

$row = @mysqli_fetch_assoc($resultT);

header('Access-Control-Allow-Origin: *');
header("Content-type: text/xml");

echo "<?xml version='1.0' ?>";
echo '<info>';
echo '<track ';
echo 'title="' . $row['Name'] . '" ';
echo 'length="' . $row['Length'] . '" ';
echo 'genre="' . $row['Genre'] . '" ';
echo 'UID="' . $row['UID'] . '" ';
echo '/>';

$ind=0;
if ($resultA) {
    while ($row = @mysqli_fetch_assoc($resultA)){
        // Add to XML document node
        echo '<artist ';
        echo 'AID="' . $row['AID'] . '" ';
        echo 'name="' . $row['Name'] . '" ';
        echo '/>';
        $ind = $ind + 1;
    }
}
$ind=0;
//iterate through groups
if ($resultG) {
    while ($row = @mysqli_fetch_assoc($resultG)){
        // Add to XML document node
        echo '<group ';
        echo 'GID="' . $row['GID'] . '" ';
        echo 'name="' . $row['Name'] . '" ';
        echo '/>';
        $ind = $ind + 1;
    }
}
$ind=0;
//iterate through remixes
if ($resultR) {
    while ($row = @mysqli_fetch_assoc($resultR)){
        // Add to XML document node
        echo '<remix ';
        echo 'TID="' . $row['TID'] . '" ';
        echo 'title="' . $row['Title'] . '" ';
        echo '/>';
        $ind = $ind + 1;
    }
}
$ind=0;
//iterate through sources
if ($resultS) {
    while ($row = @mysqli_fetch_assoc($resultS)){
        // Add to XML document node
        echo '<source ';
        echo 'TID="' . $row['TID'] . '" ';
        echo 'title="' . $row['Title'] . '" ';
        echo '/>';
        $ind = $ind + 1;
    }
}

// End XML file
echo '</info>';
$connection->close();

