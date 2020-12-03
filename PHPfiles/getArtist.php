<?php
include 'orm.php';
$q = $_REQUEST["q"];

$row = getArtist($q);

header('Access-Control-Allow-Origin: *');
header("Content-type: text/xml");
echo "<?xml version='1.0' ?>";
echo '<info>';
echo '<artist ';
echo 'AID="' . $row['AID'] . '" ';
echo 'Name="' . $row['Name'] . '" ';
echo '/>';
echo '</info>';