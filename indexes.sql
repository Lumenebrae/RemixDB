#DROP INDEX idx_albums_name 
#DROP INDEX idx_artists_name 
#DROP INDEX idx_groups_name 
#DROP INDEX idx_track_name 

#BTree indexes are auto generated on primary keys and some key components
#B Tree, Non-unique. these indexes created to assist the search function to search by Name, and retrieve the appropriate ID for loading pages etc.
#Using Btree because we use INSTR when searching, would not be appropriate to use hash on non-exact match type queries
#Non-unique because songs can share names, 

CREATE INDEX idx_albums_name ON albums (Name(255), ALID) USING BTREE;
CREATE INDEX idx_artists_name ON artists (Name(255), AID) USING BTREE;
CREATE INDEX idx_groups_name ON bandgroups (Name(255), GID) USING BTREE;
CREATE INDEX idx_track_name ON track (Name(255), TID) USING BTREE;
