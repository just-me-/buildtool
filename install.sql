DROP TABLE IF EXISTS gw2_buildsearch_builds;
DROP TABLE IF EXISTS gw2_buildsearch_comment;

CREATE TABLE IF NOT EXISTS gw2_buildsearch_builds(
	id int(10) UNSIGNED NOT NULL auto_increment,
	spielbereich varchar(50),
	buildauslegung varchar(50),
	klasse varchar(50),
	haupthand varchar(50),
	begleithand varchar(50),
	haupthandoff varchar(50),
	begleithandoff varchar(50),
	titel varchar(50),
	beschreibung varchar(9950),
	link varchar(995),
	klicks int(10),
	autor varchar(50),
	erstellungsdatum varchar(10),
	PRIMARY KEY  (id)
);

INSERT INTO gw2_buildsearch_builds (id, spielbereich, buildauslegung, klasse, haupthand, begleithand, haupthandoff,  begleithandoff, titel, beschreibung, link, klicks, autor, erstellungsdatum)
	VALUES 
		(1, 'PvE', 'Schaden', 'Krieger', 'Schwert', 'Schild', 'Axt', 'Axt', 'TitelBeschreibung1', 'Das ist eine sehr lange Buildbeschreibung1', 'www.google.ch', 5, 'Hans Peter', '13.09.2012'), 
		(2, 'WvW', 'Bi-Auslegung', 'Mesmer', 'Axt', 'Axt', 'Stab', NULL, 'TitelBeschreibung2', 'Das ist eine sehr lange Buildbeschreibung2', 'www.google.ch', 5, 'Hans Muster', '14.12.2012'), 
		(3, 'sPvP', 'Support/Tank', 'Elementarmagier', 'Stab', NULL, NULL, NULL, 'TitelBeschreibung3', 'Das ist eine sehr lange Buildbeschreibung3', 'www.google.ch', 5, 'Muster Peter', '15.11.2013');




--	CREATE TABLE IF NOT EXISTS gw2_buildsearch_comment(
--		id int(10) UNSIGNED NOT NULL auto_increment,
--		buildid INTEGER NOT NULL,
--		kommentar varchar(255),
--		bewertung int,
--		autor varchar(50),
--		erstellungsdatum varchar(10),
--		PRIMARY KEY  (id),
--		FOREIGN KEY (buildid) REFERENCES gw2_buildsearch_builds ( Id )
--	);

--	INSERT INTO gw2_buildsearch_comment (id, buildid, kommentar, bewertung, autor, erstellungsdatum)
--		VALUES
--		(1, 1, 'Ich finde das Build ganz gut.', 4, 'Max Muster', '12.12.2013'),
--		(2, 1, 'Ich finde das Build sehr gut.', 5, 'Max Muster', '12.12.2013'),
--		(3, 2, 'Ich finde das Build sehr schlecht.', 1, 'Max Muster', '12.12.2013');