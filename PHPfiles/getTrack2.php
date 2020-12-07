<?php
include 'orm.php';
$q = $_REQUEST["q"];

$resultA = getTrackCreditArtist($q);
$resultG = getTrackCreditGroup($q);
$resultAL = getTrackCreditAlbum($q);
$resultR = getTrackCreditRemix($q);
$resultS = getTrackCreditSource($q);
$resultT = getTrack($q);

header('Access-Control-Allow-Origin: *');
header("Content-type: text/xml");

echo "<?xml version='1.0' ?>";
echo '<info>';
echo '<track ';
echo 'title="' . $resultT['Name'] . '" ';
echo 'length="' . $resultT['Length'] . '" ';
echo 'genre="' . $resultT['Genre'] . '" ';
echo 'UID="' . $resultT['UID'] . '" ';
echo '/>';

if (!empty($resultA)) {
    $index = 0;
    while (!empty($resultA[$index])){
        // Add to XML document node
        echo '<artist ';
        echo 'AID="' . $resultA[$index]['AID'] . '" ';
        echo 'artistName="' . $resultA[$index]['Name'] . '" ';
        echo '/>';
        $index++;
    }
}

if (!empty($resultG)) {
    $index = 0;
    while (!empty($resultG[$index])){
        echo '<group ';
        echo 'GID="' . $resultG[$index]['GID'] . '" ';
        echo 'name="' . $resultG[$index]['Name'] . '" ';
        echo 'year="' . $resultG[$index]['YearFormed'] . '" ';
        echo 'type="' . $resultG[$index]['type'] . '" ';
        echo '/>';
        $index++;
    }
}

if (!empty($resultAL)) {
    $index = 0;
    while (!empty($resultAL[$index])){
        echo '<album ';
        echo 'ALID="' . $resultAL[$index]['ALID'] . '" ';
        echo 'name="' . $resultAL[$index]['Name'] . '" ';
        echo '/>';
        $index++;
    }
}

if (!empty($resultR)) {
    $index = 0;
    while (!empty($resultR[$index])){
        echo '<remix ';
        echo 'TID="' . $resultR[$index]['TID'] . '" ';
        echo 'title="' . $resultR[$index]['Name'] . '" ';
        echo '/>';
        $index++;
    }
}

if (!empty($resultS)) {
    $index = 0;
    while (!empty($resultS[$index])){
        echo '<source ';
        echo 'TID="' . $resultS[$index]['TID'] . '" ';
        echo 'title="' . $resultS[$index]['Name'] . '" ';
        echo '/>';
        $index++;
    }
}

echo '</info>';


