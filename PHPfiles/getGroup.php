<?php
include 'orm.php';
$q = $_REQUEST["q"];

$row = getGroup($q);

header('Access-Control-Allow-Origin: *');
header("Content-type: text/xml");
echo "<?xml version='1.0' ?>";
echo '<info>';
echo '<group ';
echo 'GID="' . $row['GID'] . '" ';
echo 'Name="' . $row['Name'] . '" ';
echo 'YearFormed="' . $row['YearFormed'] . '" ';
echo 'type="' . $row['type'] . '" ';
echo '/>';
echo '</info>';