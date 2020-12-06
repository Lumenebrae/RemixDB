DROP PROCEDURE IF EXISTS AddTrack;
DROP PROCEDURE IF EXISTS ConnectTrackArtist;
DROP PROCEDURE IF EXISTS ConnectTrackGroup;
DROP PROCEDURE IF EXISTS ConnectTrackAlbum;
DROP PROCEDURE IF EXISTS ConnectTrackTransform;
DROP PROCEDURE IF EXISTS MasterAddTrack;
DROP PROCEDURE IF EXISTS AddGroup;
DROP PROCEDURE IF EXISTS ConnectArtistGroup;
DROP PROCEDURE IF EXISTS MasterAddGroup;
DROP PROCEDURE IF EXISTS MasterAddArtist;
DROP PROCEDURE IF EXISTS MasterAddAlbum;

DELIMITER $$
CREATE PROCEDURE AddTrack(
	IN trackTitle TINYTEXT, 
	trackLength TIME,
    trackGenre TINYTEXT,
    trackUID INT(20),
    OUT trackID INT(20)
)
BEGIN
	INSERT INTO track (Name, Length, Genre, UID)
	VALUES (trackTitle, trackLength, trackGenre, trackUID);
    SET trackID = LAST_INSERT_ID();
END $$

##############################################################################

CREATE PROCEDURE ConnectTrackArtist(
	IN trackID INT(20), 
    artistID INT(20)
)
BEGIN
	INSERT INTO trackcreditartist (TID, AID)
	VALUES (trackID, artistID);
END $$

##############################################################################

CREATE PROCEDURE ConnectTrackGroup(
	IN trackID INT(20), 
    groupID INT(20)
)
BEGIN
	INSERT INTO trackcreditgroup (TID, GID)
	VALUES (trackID, groupID);
END $$

##############################################################################

CREATE PROCEDURE ConnectTrackAlbum(
	IN trackID INT(20), 
    albumID INT(20),
    trackNum INT(20)
)
BEGIN
	INSERT INTO albumtracks (ALID, TID, TrackNumber)
	VALUES (albumID, trackID, trackNum);
END $$

##############################################################################

CREATE PROCEDURE ConnectTrackTransform(
	IN transformID INT(20), 
	originalID INT(20)#,
    #transformtype TINYTEXT
)
BEGIN
	INSERT INTO remix (TransformedID, OriginalID)
	VALUES (transformID, originalID);
	#INSERT INTO remix (TransformedID, OriginalID, TransformType)
	#VALUES (transformID, originalID, transformtype);
END $$

##############################################################################

CREATE PROCEDURE MasterAddTrack(
	IN trackTitle TINYTEXT, 
	trackLength TIME,
    trackGenre TINYTEXT,
    trackUID INT(20),
    artistID TINYTEXT,
    groupID TINYTEXT,
    albumID TINYTEXT,
    originalID TINYTEXT,
    transformID TINYTEXT,
    OUT trackID INT(20)
)
BEGIN
	#example call might look like: CALL MasterAddTrack('name','1:00:00','genre', 1, "1,2,3,", "", "1,3;", "20,type;25,type;", "30,type;35,type;");
    #things that should already exist before masteraddtrack: user with supplied UID, artists with supplied AID, Albums with supplied ALID,
	CALL AddTrack(trackTitle, trackLength, trackGenre, trackUID, @trackID);
    SET trackID = @trackID;
    IF artistID THEN
		WHILE (LOCATE(',', artistID) > 0)
		DO
			SET @value = ELT(1, artistID);
			SET artistID = SUBSTRING(artistID, LOCATE(',', artistID) + 1);
			CALL ConnectTrackArtist(@trackID, @value);
		END WHILE;
    END IF;
    IF groupID THEN
		WHILE (LOCATE(',', groupID) > 0)
		DO
			SET @value = ELT(1, groupID);
			SET groupID = SUBSTRING(groupID, LOCATE(',', groupID) + 1);
			CALL ConnectTrackGroup(@trackID, @value);
		END WHILE;
    END IF;
	IF albumID THEN
		WHILE (LOCATE(';', albumID) > 0)
		DO
			SET @value = ELT(1, albumID);
			SET @tracknumber = SUBSTRING(@value, LOCATE(',', @value) + 1);
			SET albumID = SUBSTRING(albumID, LOCATE(';', albumID) + 1);
			CALL ConnectTrackAlbum(@trackID, @value, @tracknumber);
		END WHILE;
    END IF;
	IF originalID THEN
		WHILE (LOCATE(';', originalID) > 0)
		DO
			SET @value = ELT(1, originalID);
			#SET @transformtype = SUBSTRING(@value, LOCATE(',', @value) + 1);
			SET originalID = SUBSTRING(originalID, LOCATE(';', originalID) + 1);
			CALL ConnectTrackTransform(@value, @trackID);
			#CALL ConnectTrackTransform(@value, @trackID, @transformtype);
		END WHILE;
    END IF;
	IF transformID THEN
		WHILE (LOCATE(';', transformID) > 0)
		DO
			SET @value = ELT(1, transformID);
			#SET @transformtype = SUBSTRING(@value, LOCATE(',', @value) + 1);
			SET transformID = SUBSTRING(transformID, LOCATE(';', transformID) + 1);
			CALL ConnectTrackTransform(@trackID, @value);
			#CALL ConnectTrackTransform(@trackID, @value, @transformtype);
		END WHILE;
    END IF;
END $$

##############################################################################

CREATE PROCEDURE AddGroup(
	IN groupName TINYTEXT, 
	groupYear YEAR,
    groupType TINYTEXT,
    OUT groupID INT(20)
)
BEGIN
	INSERT INTO `groups` (Name, YearFormed, type)
	VALUES (groupName, groupYear, groupType);
    SET groupID = LAST_INSERT_ID();
END $$

##############################################################################

CREATE PROCEDURE ConnectArtistGroup(
	IN groupID INT(20), 
	artistID INT(20)
)
BEGIN
	INSERT INTO member (AID, GID)
	VALUES (artistID, groupID);
END $$

##############################################################################

CREATE PROCEDURE MasterAddGroup(
	IN groupname TINYTEXT, 
    groupyear YEAR, 
    grouptype TINYTEXT, 
    artistIDs TINYTEXT,
    OUT groupID INT(20)
)
BEGIN
	CALL AddGroup(groupname, groupyear, grouptype, @groupID);
    SET groupID = @groupID;
	IF artistIDs THEN
		WHILE (LOCATE(',', artistIDs) > 0)
		DO
			SET @value = ELT(1, artistIDs);
			SET artistIDs = SUBSTRING(artistIDs, LOCATE(',', artistIDs) + 1);
			CALL ConnectArtistGroup(@groupID, @value);
		END WHILE;
    END IF;
END $$

##############################################################################

CREATE PROCEDURE MasterAddArtist(
	IN artistName TINYTEXT, 
    OUT artistID INT(20)
)
BEGIN
	INSERT INTO artists (Name)
	VALUES (artistName);
    SET artistID = LAST_INSERT_ID();
END $$

##############################################################################

CREATE PROCEDURE MasterAddAlbum(
	IN artistID INT(20), 
    groupID INT(20), 
    albumName TINYTEXT, 
    OUT albumID INT(20)
)
BEGIN
	INSERT INTO albums (AID, GID, Name)
	VALUES (artistID, groupID, albumName);
    SET albumID = LAST_INSERT_ID();
END $$


##############################################################################
DELIMITER ;

