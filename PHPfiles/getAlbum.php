<?php
include 'orm.php';
$q = $_REQUEST["q"];

$row = getAlbum($q);

header('Access-Control-Allow-Origin: *');
header("Content-type: text/xml");
echo "<?xml version='1.0' ?>";
echo '<info>';
echo '<album ';
echo 'ALID="' . $row['ALID'] . '" ';
echo 'AID="' . $row['AID'] . '" ';
echo 'albumName="' . $row['albumName'] . '" ';
echo 'artistName="' . $row['artistName'] . '" ';
echo 'title="' . $row['title'] . '" ';
echo '/>';
echo '</info>';