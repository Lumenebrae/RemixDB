<?php
include 'orm.php';
$q = $_REQUEST["q"];

$row = getTrack($q);

header('Access-Control-Allow-Origin: *');
header("Content-type: text/xml");
echo "<?xml version='1.0' ?>";
echo '<info>';
echo '<track ';
echo 'title="' . $row['Name'] . '" ';
echo 'length="' . $row['Length'] . '" ';
echo 'genre="' . $row['Genre'] . '" ';
echo '/>';
echo '</info>';
