<?php
// wcf imports
namespace wcf\page;
use wcf\system\WCF;

require_once('Gw2BuildsearchPage.class.php');
require_once('Dropdown.class.php'); 
require_once('HtmlTag.class.php');

/**
 * Guild Wars 2 Buildsearch
 *
 * @author       Marcel H. 
 * @copyright    2013 Marcel H. 
 * @package      net.poebel.gw2.buildsearch
 */
class BuildDatabase
{	
	private $zugriff="";
	private $sql="";
	private $result="";
	private $adminID;
	
	public function __construct ()
	{
		 $this->zugriff = WCF::getDB();
		 $this->adminID = 4;  /* ### Hier muss die Administrations ID vom CMS eingetragen werden ### */
	}
	
	public function getBuilds()
	{
		$builds="";
		$sql="SELECT * from gw2_buildsearch_builds";
		$filterungen = 0; 
		if(!empty($_POST['Spielbereich']) && ($_POST['Spielbereich'] != 'alle')){
			if($filterungen==0){$sql .= " WHERE spielbereich = '". $_POST['Spielbereich'] ."'";}
			else{$sql .= " AND spielbereich = '". $_POST['Spielbereich'] ."'";}
			$filterungen++; 
		}
		if(!empty($_POST['Buildauslegung']) && ($_POST['Buildauslegung'] != 'alle')){
			if($filterungen==0){$sql .= " WHERE buildauslegung = '". $_POST['Buildauslegung'] ."'";}
			else{$sql .= " AND buildauslegung = '". $_POST['Buildauslegung'] ."'";}
			$filterungen++; 
		}
		if(!empty($_POST['Klasse']) && ($_POST['Klasse'] != 'alle')){
			if($filterungen==0){$sql .= " WHERE klasse = '". $_POST['Klasse'] ."'";}
			else{$sql .= " AND klasse = '". $_POST['Klasse'] ."'";}
			$filterungen++; 
		}
		if(!empty($_POST['Haupthand']) && ($_POST['Haupthand'] != 'alle')){
			if($filterungen==0){$sql .= " WHERE (haupthand = '". $_POST['Haupthand'] ."' OR haupthandoff = '". $_POST['Haupthand'] ."')";}
			else{$sql .= " AND (haupthand = '". $_POST['Haupthand'] ."' OR haupthandoff = '". $_POST['Haupthand'] ."')";}
			$filterungen++; 
		}
		if(!empty($_POST['Begleithand']) && ($_POST['Begleithand'] != 'alle')){
			if($filterungen==0){$sql .= " WHERE (begleithand = '". $_POST['Begleithand'] ."' OR begleithandoff = '". $_POST['Begleithand'] ."')";}
			else{$sql .= " AND (begleithand = '". $_POST['Begleithand'] ."' OR begleithandoff = '". $_POST['Begleithand'] ."')";}
			$filterungen++; 
		}
		/* Adminberechtigung pruefen */
		$arrayGruppen = WCF::getUser()->getGroupIDs();
		$admin = false;
		foreach($arrayGruppen as $gruppe){
			if($gruppe == $this->adminID){
				$admin = true; 
			}
		}
		$user = WCF::getUser()->username;
		if($user == ""){ 
			$admin = false;
		}
						
		$statement = $this->zugriff->prepareStatement($sql);
		$statement->execute();
		while ($row = $statement->fetchArray()) {
			if(!empty( $row['haupthand'])){
				$haupthandIcon = '<img title="' . $row['haupthand'] . '" src="wcf/icon/' . $row['haupthand'] . '.png" alt="' . $row['haupthand'] . '"</img>';
			} else { $haupthandIcon = ""; }
			if(!empty( $row['begleithand'])){
				$nebenhandIcon = '<img title="' . $row['begleithand'] . '" src="wcf/icon/' . $row['begleithand'] . '.png" alt="' . $row['begleithand'] . '"</img>';
			} else { $nebenhandIcon = ""; }
			if(!empty( $row['haupthandoff'])){
				$haupthandOffIcon = '<img title="' . $row['haupthandoff'] . '" src="wcf/icon/' . $row['haupthandoff'] . '.png" alt="' . $row['haupthandoff'] . '"</img>';
			} else { $haupthandOffIcon = ""; }
			if(!empty( $row['begleithandoff'])){
				$nebenhandOffIcon = '<img title="' . $row['begleithandoff'] . '" src="wcf/icon/' . $row['begleithandoff'] . '.png" alt="' . $row['begleithandoff'] . '"</img>';
			} else { $nebenhandOffIcon = ""; }
			
			$classFile = $row['klasse'];
			if($row['klasse'] == "Wächter"){
				$classFile = "Waechter"; 
			}
			if($row['klasse'] == "Waldläufer"){
				$classFile = "Waldlaeufer";
			}
			
			/* Bewertung */ /*build_0.png build_1.png*/
			/* Hier wird ausgelesen und gerechnet; dann wird 'gerundet' ermittelt */ $gerundet = 3;
			$bewertung1 = "build_1.png";
			$bewertung2 = "build_0.png";
			$bewertung3 = "build_0.png";
			$bewertung4 = "build_0.png";
			$bewertung5 = "build_0.png";
			if($gerundet >= 2){ $bewertung2 = "build_1.png";}
			if($gerundet >= 3){ $bewertung3 = "build_1.png";}
			if($gerundet >= 4){ $bewertung4 = "build_1.png";}
			if($gerundet >= 5){ $bewertung5 = "build_1.png";}
			$bewertungsTag = '<img class="bewertung" title="Bewertung: ' . $gerundet . ' von 5" src="wcf/icon/' . $bewertung1 . '" alt="Bewertung: ' . $gerundet . ' von 5"</img>';
			$bewertungsTag .= '<img class="bewertung" title="Bewertung: ' . $gerundet . ' von 5" src="wcf/icon/' . $bewertung2 . '" alt="Bewertung: ' . $gerundet . ' von 5"</img>';
			$bewertungsTag .= '<img class="bewertung" title="Bewertung: ' . $gerundet . ' von 5" src="wcf/icon/' . $bewertung3 . '" alt="Bewertung: ' . $gerundet . ' von 5"</img>';
			$bewertungsTag .= '<img class="bewertung" title="Bewertung: ' . $gerundet . ' von 5" src="wcf/icon/' . $bewertung4 . '" alt="Bewertung: ' . $gerundet . ' von 5"</img>';
			$bewertungsTag .= '<img class="bewertung" title="Bewertung: ' . $gerundet . ' von 5" src="wcf/icon/' . $bewertung5 . '" alt="Bewertung: ' . $gerundet . ' von 5"</img>';
		
			if( 0 < substr_count($row['link'], 'http')){
				$thisLink = $row['link'];
			} else{
				$thisLink = "http://" . $row['link'];
			}
		
			$builds .= '
			<div class="gefundenerDatensatz">
				<div class="gefundeneUeberschrift">
					<div class="gedundenerTitel floatleft">
						<!-- <a href="javascript:toggle(\'build_' . $row['id'] . '\')">' . $row['titel'] . '</a> -->
						<a class="collapsed" data-toggle="collapse" data-parent="#myMain" href="#build_' . $row['id'] . '">' . $row['titel'] . '</a>
					</div>
					<div class="gefundenerSpielbereich floatleft">' . $row['spielbereich'] . '</div>
					<div class="gefundeneBuildauslegung floatleft">' . $row['buildauslegung'] . '</div>
					<div class="gefundeneKlasse floatleft"><img title="' . $row['klasse'] . '" src="wcf/icon/' . $classFile . '.png" alt="' . $row['klasse'] . '"</img></div>
					<div class="gefundeneHaupthand floatleft">' . $haupthandIcon . '</div>
					<div class="gefundeneBegleithand floatleft">' . $nebenhandIcon . '</div>
					<div class="gefundeneHaupthandOff floatleft">' . $haupthandOffIcon . '</div>
					<div class="gefundeneBegleithandOff floatleft">' . $nebenhandOffIcon . '</div>
					<div class="gefundeneBewertung floatleft">' . $bewertungsTag . '</div>
				</div>
					
				<div id="build_' . $row['id'] . '" class="collapse">
					<div id="build_' . $row['id'] . '_" class="gefundenerInhalt">
						<form action="/index.php/Gw2Buildsearch/" method="POST">
							<input class="hidden" name="thisBuildID" value="' . $row['id'] . '" readonly="readonly">
							<div class="inhaltBeschreibung floatleft"><p><strong>Beschreibung: </strong>' . $row['beschreibung'] . '</p></div>
							<div class="infoBox floatright">
								<div class="inhaltKlicks"><p><strong>Anzahl Klicks: </strong>' . $row['klicks'] . '</p></div>
								<div class="inhaltAutor"><p><strong>Autor: </strong>' . $row['autor'] . '</p></div>
								<div class="inhaltErtstellungsdatum"><p><strong>Erstellt am: </strong>' . $row['erstellungsdatum'] . '</p></div>
							</div>
							<div class="inhaltLinks clear">
								<a href="' . $thisLink . '" target="_blank" class="button">Zum Build</a>
								<a class="collapsed button" data-toggle="collapse" data-parent="#myMain" href="#build_' . $row['id'] . '">Schliessen</a>';
								
								if($admin == true){ 
									$builds .= '<input name="delBuildAdmin" class="button delAsAdmin" type="submit" value="Build als Admin löschen">';
								}	
							$builds .= '
							</div>
						</form>
					</div>
				</div>
				
			</div>
			';
		}
		if($builds == ""){return '<div class="fehlerBox">Es wurden leider keine Ergebnisse auf die vorgegebenen Filterungsoptionen gefunden.</div>';}
		return $builds;
	}
	
	
	public function getMyBuilds()
	{
		/* Formular mit Löschfunktion */
		$builds="";
		$user = WCF::getUser()->username;
		if($user == ""){ 
			return '<div class="fehlerBox">Sie müssen sich anmelden, damit Sie Ihre Builds editieren können.</div>';
		}
		
		$sql="SELECT * from gw2_buildsearch_builds WHERE autor = '" . $user . "'";
		$statement = $this->zugriff->prepareStatement($sql);
		$statement->execute();
		
		/* tmp */
		$arraySpielbereich = array(0 => 'WvW', 1 => 'PvE', 2 => 'sPvP');
		$arrayBuildauslegung = array(0 => 'Schaden', 1 => 'Support/Tank', 2 => 'Bi-Auslegung');
		$arrayKlasse = array(0 => 'Krieger', 1 => 'Wächter', 2 => 'Dieb', 3 => 'Ingenieur', 4 => 'Waldläufer', 5 => 'Elementarmagier', 6 => 'Mesmer', 7 => 'Nekromant');
		$arrayHaupthand = array(0 => 'Gewehr', 1 => 'Grossschwert', 2 => 'Hammer', 3 => 'Kurzbogen', 4 => 'Langbogen', 5 => 'Stab', 
								6 => 'Axt', 7 => 'Dolch', 8 => 'Pistole', 9 => 'Schwert', 10 => 'Streitkolben', 11 => 'Zepter');
		$arrayNebenhand = array(0 => '-', 1 => 'Axt', 2 => 'Dolch', 3 => 'Pistole', 4 => 'Schwert', 5 => 'Streitkolben', 
								6 => 'Fackel', 7 => 'Fokus', 8 => 'Kriegshorn', 9 => 'Schild');
		$createSpielbereich = new Dropdown('Spielbereich', $arraySpielbereich);
		$createBuildauslegung = new Dropdown('Buildauslegung', $arrayBuildauslegung);
		$createKlasse = new Dropdown('Klasse', $arrayKlasse);
		$createHaupthand = new Dropdown('Hauptwaffensatz - Haupthand', $arrayHaupthand);
		$createBegleithand = new Dropdown('Hauptwaffensatz - Begleithand', $arrayNebenhand);
		$createHaupthandOff = new Dropdown('Nebenwaffensatz - Haupthand', $arrayHaupthand);
		$createBegleithandOff = new Dropdown('Nebenwaffensatz - Begleithand', $arrayNebenhand);
		/* tmp END */
		$counter = 0;
		while ($row = $statement->fetchArray()) {
			$counter++;
			
			$classFile = $row['klasse'];
			if($row['klasse'] == "Wächter"){
				$classFile = "Waechter"; 
			}
			if($row['klasse'] == "Waldläufer"){
				$classFile = "Waldlaeufer";
			}
			
			$builds .= '
			<div class="gefundenerDatensatz">
			 <form action="/index.php/Gw2Buildsearch/" method="POST">
				<input class="hidden" name="thisBuildID" value="' . $row['id'] . '" readonly="readonly">
				<div class="gefundeneUeberschrift">
					<div class="gedundenerTitel floatleft">
						<!-- <a href="javascript:toggle(\'build_' . $row['id'] . '\')">' . $row['titel'] . '</a> -->
						<a class="collapsed" data-toggle="collapse" data-parent="#myMain" href="#myBuild_' . $row['id'] . '">' . $row['titel'] . '</a>
					</div>
					<div class="gefundeneKlasse floatleft"><img title="' . $row['klasse'] . '" src="wcf/icon/' . $classFile . '.png" alt="' . $row['klasse'] . '"</img></div>
					<div class="gefundeneHaupthand floatleft">' . $row['haupthand'] . '</div>
					<div class="gefundeneBegleithand floatleft">' . $row['begleithand'] . '</div>
					<div class="gefundeneHaupthand floatleft">' . $row['haupthandoff'] . '</div>
					<div class="gefundeneBegleithand floatleft">' . $row['begleithandoff'] . '</div>
					<div class="gefundenesErstelldatum floatright">'. $row['erstellungsdatum'] .'</div>
				</div>
					
				<div id="myBuild_' . $row['id'] . '" class="collapse">
					<div class="gefundenerInhalt">
						<div class="createTitel">
									<label>Kurzbeschreibung</label>
									<input type="text" size="40" maxlength="45" name="editTitel" value="'. $row['titel'] . '"> 
								</div>
								<div class="createLink">
									<label>Link zum Build</label>
									<input type="text" size="40" maxlength="990" name="editLink" value="'. $row['link'] . '"> 
								</div>
								<div class="createBeschreibung">
									<label>Ausführliche Beschreibung</label>
									<textarea name="editBeschreibung" cols="50" rows="10" maxlength="9950">' . $row["beschreibung"] . '</textarea>
								</div>
								
								<div class="createKlasse">'. $createKlasse->getSelectedDropdown("edit", $row['klasse']) .'</div>
								<div class="createSpielbereich">'. $createSpielbereich->getSelectedDropdown("edit", $row['spielbereich']) .'</div>
								<div class="createBuildauslegung">'. $createBuildauslegung->getSelectedDropdown("edit", $row['buildauslegung']) .'</div>
								<div class="createHaupthand clear">'. $createHaupthand->getSelectedDropdownWithName("edit", "Haupthand", $row['haupthand']) .'</div>
								<div class="createBegleithand">'. $createBegleithand->getSelectedDropdownWithName("edit", "Nebenhand", $row['begleithand']) .'</div>
								<div class="createHaupthand clear">'. $createHaupthandOff->getSelectedDropdownWithName("edit", "HaupthandOff", $row['haupthandoff']) .'</div>
								<div class="createBegleithand">'. $createBegleithandOff->getSelectedDropdownWithName("edit", "NebenhandOff", $row['begleithandoff']) .'</div>
								
								<div class="buttons clear">
									<input name="safeEditedBuild" class="button" type="submit" value="Änderungen speichern">
									<!-- <a class="button" href="javascript:toggle(\'build_' . $row['id'] . '\')">Abbrechen</a> -->
									<a class="collapsed button" data-toggle="collapse" data-parent="#myMain" href="#myBuild_' . $row['id'] . '">Abbrechen</a>
									<input name="delBuildAutor" class="button delAsAdmin" type="submit" value="Build als Ersteller löschen">
								</div>
					</div>
				</div>
			 </form>	
			</div>
			';
		}
		if($counter == 0){return '<div class="fehlerBox">Sie haben noch keine Builds erstellt, welche Sie verwalten könnten.</div>';}
		return $builds;
	}
	
	public function setNewBuild()
	{
		if (isset($_POST["safeBuild"])) 
		{ 
			$user = WCF::getUser()->username;
			if($user == ""){ 
				return "Sie müssen sich anmelden, damit Sie ein Build erstellen können.";
			}
			/* htmlentities wurde wieder entfernt */
			if(!empty($_POST['createTitel'])){
				$titel = strip_tags($_POST['createTitel']);
			} else{ 
				return "Build wurde nicht erstellt; bitte eine Kurzbeschreibung angeben."; 
			}
			if(!empty($_POST['createBeschreibung'])){
				$beschreibung = strip_tags($_POST['createBeschreibung']);
			} else{ 
				return "Build wurde nicht erstellt; bitte eine Beschreibung angeben."; 
			}
			if(!empty($_POST['createLink'])){
				$link = strip_tags($_POST['createLink']);
			} else{ 
				return "Build wurde nicht erstellt; bitte einen Link angeben."; 
			}
			
			$spielbereich = strip_tags($_POST['createSpielbereich']);
			$buildauslegung = strip_tags($_POST['createBuildauslegung']);
			$klasse = strip_tags($_POST['createKlasse']);
			$haupthand = strip_tags($_POST['createHaupthand']);
			$begleithand = strip_tags($_POST['createNebenhand']);
			$haupthandOff = strip_tags($_POST['createHaupthandOff']);
			$begleithandOff = strip_tags($_POST['createNebenhandOff']);
			
			$myValidate = new BuildValidate();
			
			if($myValidate->checkKlasse($klasse) != true){
				return "Die Klasse ist fehlerhaft.";
			}
			if($myValidate->checkWeapon($haupthand, $begleithand, $klasse) != true){
				return "Die Waffenwahl ist fehlerhaft für die Klasse " . $klasse . ".";
			}
			if(($klasse == "Elementarmagier") || ($klasse == "Ingenieur")){
				$haupthandOff = "";
				$begleithandOff = "";
			}
			else{
				if($myValidate->checkWeapon($haupthandOff, $begleithandOff, $klasse) != true){
					return "Die Waffenwahl des zweiten Waffensets ist fehlerhaft für die Klasse " . $klasse . ".";
				}
			}
			if($myValidate->checkSpielbereich($spielbereich) != true){
				return "Der Spielbereich ist fehlerhaft.";
			}
			if($myValidate->checkBuildauslegung($buildauslegung) != true){
				return "Die Buildauslegung ist fehlerhaft.";
			}
			
			/* Zur Schoenheit wird der Gedankenstrich nicht in die DB geschrieben */
			if($begleithand == "-"){
				$begleithand = "";
			}
			if($begleithandOff == "-"){
				$begleithandOff = "";
			}
			
			$klicks = 0;
			$autor = WCF::getUser()->username;
			$erstellungsdatum = date("d.m.Y", time());
			 
			$sql = "
			INSERT INTO gw2_buildsearch_builds (spielbereich, buildauslegung, klasse, haupthand, begleithand, haupthandoff,  begleithandoff, titel, beschreibung, link, klicks, autor, erstellungsdatum) VALUES 
			('". $spielbereich ."', '". $buildauslegung ."', '". $klasse ."', '". $haupthand ."', '". $begleithand ."', '". $haupthandOff ."', '". $begleithandOff ."', '". $titel ."', '". $beschreibung ."', '". $link ."', ". $klicks .", '". $autor ."', '". $erstellungsdatum ."')
			";
			$statement = $this->zugriff->prepareStatement($sql);
			$statement->execute();
			return "Neues Build wurde erfolgreich erstellt."; 
		}
	}
	
	public function setEditBuild()
	{
		if (isset($_POST["safeEditedBuild"])) 
		{ 
			$user = WCF::getUser();
			if($user == ""){return "Das Anmelde-Session abgelaufen. Bitte anmelden.";}
			
			/* Testen, ob Ersteller == Updater ist; falls ja - dann aktualisieren. */
			$sql="SELECT * from gw2_buildsearch_builds WHERE autor = '" . $user . "'";
			$result = $this->zugriff->sendQuery($sql);
			$statement = $this->zugriff->prepareStatement($sql);
			$statement->execute();
			$check = false;
			while ($row = $statement->fetchArray()){
				if($row['id']=$_POST['thisBuildID']){
					$check = true;
				}
			}
			if($check == true)
			{	
				if(!empty($_POST['editTitel'])){
					$titel = strip_tags($_POST['editTitel']); 
				} else{ 
					return "Build wurde nicht erstellt; bitte eine Kurzbeschreibung angeben."; 
				}
				if(!empty($_POST['editBeschreibung'])){
					$beschreibung = strip_tags($_POST['editBeschreibung']);
				} else{ 
					return "Build wurde nicht erstellt; bitte eine Beschreibung angeben."; 
				}
				if(!empty($_POST['editLink'])){
					$link = strip_tags($_POST['editLink']);
				} else{ 
					return "Build wurde nicht erstellt; bitte einen Link angeben."; 
				}
				
				$spielbereich = strip_tags($_POST['editSpielbereich']);
				$buildauslegung = strip_tags($_POST['editBuildauslegung']);
				$klasse = strip_tags($_POST['editKlasse']);
				$haupthand = strip_tags($_POST['editHaupthand']);
				$begleithand = strip_tags($_POST['editNebenhand']);
				$haupthandOff = strip_tags($_POST['editHaupthandOff']);
				$begleithandOff = strip_tags($_POST['editNebenhandOff']);
				
				$myValidate = new BuildValidate();
				
				if($myValidate->checkKlasse($klasse) != true){
					return "Die Klasse ist fehlerhaft.";
				}
				if($myValidate->checkWeapon($haupthand, $begleithand, $klasse) != true){
					return "Die Waffenwahl ist fehlerhaft für die Klasse " . $klasse . ".";
				}
				if(($klasse == "Elementarmagier") || ($klasse == "Ingenieur")){
					$haupthandOff = "";
					$begleithandOff = "";
				}
				else{
					if($myValidate->checkWeapon($haupthandOff, $begleithandOff, $klasse) != true){
						return "Die Waffenwahl des zweiten Waffensets ist fehlerhaft für die Klasse " . $klasse . ".";
					}
				}
				if($myValidate->checkSpielbereich($spielbereich) != true){
					return "Der Spielbereich ist fehlerhaft.";
				}
				if($myValidate->checkBuildauslegung($buildauslegung) != true){
					return "Die Buildauslegung ist fehlerhaft.";
				}
				
				/* Zur Schoenheit wird der Gedankenstrich nicht in die DB geschrieben */
				if($begleithand == "-"){
					$begleithand = "";
				}
				if($begleithandOff == "-"){
					$begleithandOff = "";
				}
				$erstellungsdatum = date("d.m.Y", time());
				
				$sql = "UPDATE gw2_buildsearch_builds 
					SET spielbereich = '". $spielbereich ."', buildauslegung = '". $buildauslegung ."', klasse = '". $klasse ."', 
					haupthand = '". $haupthand ."', begleithand = '". $begleithand ."', haupthandoff = '". $haupthandOff ."',  begleithandoff = '". $begleithandOff ."', 
					titel = '". $titel ."', beschreibung = '". $beschreibung ."', link = '". $link ."', erstellungsdatum = '". $erstellungsdatum ."'
					WHERE id = " . $_POST["thisBuildID"];
				$statement = $this->zugriff->prepareStatement($sql);
				$statement->execute();
				return "Dein Build wurde erfolgreich editiert.";
			}
			else{ return "Das System hat Sie nicht als Autor erkennt. Es wurde keine Änderung vorgenommen.";} 
		}
		
		if (isset($_POST["delBuildAutor"])) 
		{ 
			$user = WCF::getUser();
			if($user == ""){return "Das Anmelde-Session abgelaufen. Bitte anmelden.";}
			
			$sql="SELECT * from gw2_buildsearch_builds WHERE autor = '" . $user . "'";
			$statement = $this->zugriff->prepareStatement($sql);
			$statement->execute();
			$check = false;
			while ($row = $statement->fetchArray()){
				if($row['id']=$_POST['thisBuildID']){
					$check = true;
				}
			}
			if($check == true){
				$sql = "DELETE FROM gw2_buildsearch_builds WHERE id = " . $_POST["thisBuildID"];
				$statement = $this->zugriff->prepareStatement($sql);
				$statement->execute();
				return "Dein Build wurde erfolgreich gelöscht.";
			}
			else{ return "Das System hat Sie nicht als Autor erkennt. Es wurde keine Änderung vorgenommen.";}
			 
		}
	}
	
	public function deleteBuild()
	{
		/* Pruefen ob Benutzername oder Adminberechtigung stimmt als Valedierung */
		if (isset($_POST["delBuildAdmin"])) 
		{ 
			$arrayGruppen = WCF::getUser()->getGroupIDs();
			$admin = false;
			foreach($arrayGruppen as $gruppe){
				if($gruppe == $this->adminID){
					$admin = true; 
				}
			}
			if($admin != true){ return "Sie sind kein Admin!";}
			
			$sql = "DELETE FROM gw2_buildsearch_builds WHERE id = " . $_POST["thisBuildID"];
			$statement = $this->zugriff->prepareStatement($sql);
			$statement->execute();
			return "Build Nr. " . $_POST["thisBuildID"] . " wurde erfolgreich gelöscht.";
			
		}
	}
	
}










