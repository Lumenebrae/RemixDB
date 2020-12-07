<?php


function init(){ //function parameters, two variables.
    $connection = mysqli_connect('127.0.0.1', "newuser", '', 'cs348');
    if (!$connection) {
        die('Not connected : ' . mysqli_connect_error());
    }
    return $connection;
}
function endcon($connection){ //function parameters, two variables.
    $connection->close();
}

function getAlbum($q){
    $connection = init();
    $query = "select albums.ALID, artists.AID, albums.albumName, artists.artistName, bandgroups.title from albums left join artists on albums.AID = artists.AID left join bandgroups on albums.GID = bandgroups.GID where albums.ALID='".$q."'";

    $result = mysqli_query($connection, $query);
    if (!$result) {
        die('Invalid query: ' . mysqli_error($connection));
    }
    endcon($connection);
    return @mysqli_fetch_assoc($result);
}

function getArtist($q){
    $connection = init();
    $query = "select * from artists where AID=".$q;

    $result = mysqli_query($connection, $query);
    if (!$result) {
        die('Invalid query: ' . mysqli_error($connection));
    }
    endcon($connection);
    return @mysqli_fetch_assoc($result);
}

function getGroup($q){ //function parameters, two variables.
    $connection = init();
    $query = "select * from groups where GID=".$q;

    $result = mysqli_query($connection, $query);
    if (!$result) {
        die('Invalid query: ' . mysqli_error($connection));
    }
    endcon($connection);
    return @mysqli_fetch_assoc($result);
}

function getTrack($q){ //function parameters, two variables.
    $connection = init();
    $query = "select * from track where TID=".$q;

    $result = mysqli_query($connection, $query);
    if (!$result) {
        die('Invalid query: ' . mysqli_error($connection));
    }
    endcon($connection);
    return @mysqli_fetch_assoc($result);
}
function getTrackCreditArtist($q){
    $connection = init();
    $query = "select * from artists where AID in (select AID from trackcreditartist where TID=".$q.")";
    $result = mysqli_query($connection, $query);
    if (!$result) {
        die('Invalid query: ' . mysqli_error($connection));
    }
    $result2 = array();
    $index = 0;
    while ($row = @mysqli_fetch_assoc($result)){
        // Add to XML document node
        $result2[] = $row;
        $index++;
    }

    endcon($connection);
    return $result2;
}

function getTrackCreditGroup($q){
    $connection = init();
    $query = "select * from bandgroups where GID in (select GID from trackcreditgroup where TID=".$q.")";
    $result = mysqli_query($connection, $query);
    if (!$result) {
        die('Invalid query: ' . mysqli_error($connection));
    }
    $result2 = array();
    $index = 0;
    while ($row = @mysqli_fetch_assoc($result)){
        // Add to XML document node
        $result2[] = $row;
        $index++;
    }
    endcon($connection);
    return $result2;
}

function getTrackCreditAlbum($q){
    $connection = init();
    $query = "select * from albums where ALID in (select ALID from albumtracks where TID=".$q.")";
    $result = mysqli_query($connection, $query);
    if (!$result) {
        die('Invalid query: ' . mysqli_error($connection));
    }
    $result2 = array();
    $index = 0;
    while ($row = @mysqli_fetch_assoc($result)){
        // Add to XML document node
        $result2[] = $row;
        $index++;
    }
    endcon($connection);
    return $result2;
}

function getTrackCreditRemix($q){
    $connection = init();
    $query = "select * from track where TID in (select TransformedID from remix where OriginalID=".$q.")";
    $result = mysqli_query($connection, $query);
    if (!$result) {
        die('Invalid query: ' . mysqli_error($connection));
    }
    $result2 = array();
    $index = 0;
    while ($row = @mysqli_fetch_assoc($result)){
        // Add to XML document node
        $result2[] = $row;
        $index++;
    }
    endcon($connection);
    return $result2;
}

function getTrackCreditSource($q){
    $connection = init();
    $query = "select * from track where TID in (select OriginalID from remix where TransformedID=".$q.")";
    $result = mysqli_query($connection, $query);
    if (!$result) {
        die('Invalid query: ' . mysqli_error($connection));
    }
    $result2 = array();
    $index = 0;
    while ($row = @mysqli_fetch_assoc($result)){
        // Add to XML document node
        $result2[] = $row;
        $index++;
    }
    endcon($connection);
    return $result2;
}