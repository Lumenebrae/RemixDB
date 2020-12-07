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
