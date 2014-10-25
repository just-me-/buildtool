CREATE TABLE eso_buildsearch_builds(
	id int(10) UNSIGNED NOT NULL auto_increment,
	spielbereich varchar(50),
	buildauslegung varchar(50),
	klasse varchar(50),
	waffenset varchar(50),
	waffensetoff varchar(50),
	titel varchar(50),
	beschreibung varchar(9950),
	link varchar(995),
	autor varchar(50),
	erstellungsdatum varchar(10),
	PRIMARY KEY  (id)
);

INSERT INTO eso_buildsearch_builds (id, spielbereich, buildauslegung, klasse, waffenset, waffensetoff, titel, beschreibung, link, autor, erstellungsdatum)
	VALUES 
		(1, 'AvA', 'Schaden', 'Drachenritter', 'Bogen', 'Zweihänder', 'TitelBeschreibung1', 'Das ist eine sehr lange Buildbeschreibung1', 'www.google.ch', 'Hans Peter', '13.09.2012'), 
		(2, 'PvE', 'Heilung', 'Zauberer', 'Zweihänder', 'Bogen', 'TitelBeschreibung2', 'Das ist eine sehr lange Buildbeschreibung2', 'www.google.ch', 'Hans Muster', '14.12.2012'), 
		(3, 'Bi-Auslegung', 'Support/Tank', 'Templer', 'Zweihänder', 'Bogen', 'TitelBeschreibung3', 'Das ist eine sehr lange Buildbeschreibung3', 'www.google.ch', 'Muster Peter', '15.11.2013');


CREATE TABLE eso_buildsearch_like(
	id int(10) UNSIGNED NOT NULL auto_increment,
	buildid INTEGER NOT NULL,
	autor varchar(50),
	erstellungsdatum varchar(10),
	PRIMARY KEY  (id)
);
ALTER TABLE eso_buildsearch_like ADD FOREIGN KEY (buildid) REFERENCES eso_buildsearch_builds (id) ON DELETE CASCADE;


INSERT INTO eso_buildsearch_like (id, buildid, autor, erstellungsdatum)
		VALUES
		(1, 1, 'Max Muster', '12.12.2013'),
		(2, 1, 'Max Muster', '12.12.2013'),
		(3, 2, 'Max Muster', '12.12.2013');