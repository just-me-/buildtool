<?php
// wcf imports
namespace wcf\page;
use wcf\system\WCF;

require_once('EsoBuildsearchPage.class.php');
require_once('Dropdown.class.php'); 
require_once('HtmlTag.class.php');

/**
 * Guild Wars 2 Buildsearch
 *
 * @author       Marcel H. 
 * @copyright    2014 Marcel H. 
 * @package      ch.merlin.eso.buildsearch
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
		$sql="SELECT * from eso_buildsearch_builds";
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
		if(!empty($_POST['Waffenset']) && ($_POST['Waffenset'] != 'alle')){
			if($filterungen==0){$sql .= " WHERE (waffenset = '". $_POST['Waffenset'] ."' OR waffensetoff = '". $_POST['Waffenset'] ."')";}
			else{$sql .= " AND (waffenset = '". $_POST['Waffenset'] ."' OR waffensetoff = '". $_POST['Waffenset'] ."')";}
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
		
			$waffensetIcon = $row['waffenset']; 
			$waffensetIconOff = $row['waffensetoff']; 
			
			if ($waffensetIcon == "Zerstörungsstab") {
				$waffensetIcon = "Zerstoerungsstab"; 
			}
			if ($waffensetIcon == "Zweihänder") {
				$waffensetIcon = "Zweihaender"; 
			}
			if ($waffensetIcon == "Einhand mit Schild") {
				$waffensetIcon = "Einhand_mit_Schild"; 
			}
			if ($waffensetIconOff == "Zerstörungsstab") {
				$waffensetIconOff = "Zerstoerungsstab"; 
			}
			if ($waffensetIconOff == "Zweihänder") {
				$waffensetIconOff = "Zweihaender"; 
			}
			if ($waffensetIconOff == "Einhand mit Schild") {
				$waffensetIconOff = "Einhand_mit_Schild"; 
			}
			
			
			if(!empty( $row['waffenset'])){
				$waffensetIcon = '<img title="' . $row['waffenset'] . '" src="wcf/icon/' . $waffensetIcon . '.png" alt="' . $row['waffenset'] . '"</img>';
			} else { $waffensetIcon = ""; }
			if(!empty( $row['waffensetoff'])){
				$waffensetOffIcon = '<img title="' . $row['waffensetoff'] . '" src="wcf/icon/' . $waffensetIconOff . '.png" alt="' . $row['waffensetoff'] . '"</img>';
			} else { $waffensetOffIcon = ""; }
			
			$classFile = $row['klasse'];
			
			/* Bewertung */
			$like_sth = $this->zugriff->prepareStatement('SELECT * from eso_buildsearch_like WHERE buildid = '.$row['id']); 
			$like_sth->execute();
			$like_counter = 0; 
			$user_likes = 0; 
			while ($like_row = $like_sth->fetchArray()) {
				// count all likes 
				$like_counter++;
				// do this user like alrdy? 
				if ($like_row['autor'] == $user) {
					$user_likes++;
				}
			}
			// ajax js - glow more on rollover; send on click 
			if($like_counter == 0) {
				$alt_text = "Sei der Erste, dem dieses Build gefällt! "; 
			} else {
				$alt_text = "Dieser Beitrag gefällt ".$like_counter." Personen. "; 
				if ($user_likes == 0) {
					$alt_text .= "Gefällt er dir auch?";
					$icon = "Veteran.png"; 
				} else {
					$alt_text .= "Dir auch. Magst du es nicht mehr?";
					$icon = "Veteran_glow.png"; 
				}
			} 
			
			if ($like_counter == 0) {
				$like_counter = ""; 
			}
			$bewertungsTag = '<span class="v_lvl">'.$like_counter.'</span><img class="bewertung" title="' . $alt_text . '" src="wcf/icon/' . $icon . '" 
				alt="' . $alt_text . '" onmouseout="src=\'wcf/icon/' . $icon . '\'" onmouseover="src=\'wcf/icon/Veteran_glow_more.png\'" </img>'; 
			$javascript_events = 'onclick="getVote(this)"'; 
		
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
					<div class="gefundeneWaffenset floatleft">' . $waffensetIcon . '</div>
					<div class="gefundeneWaffensetOff floatleft">' . $waffensetOffIcon . '</div>
					<div class="gefundeneBewertung floatleft">' . $bewertungsTag . '</div>
				</div>
					
				<div id="build_' . $row['id'] . '" class="collapse">
					<div id="build_' . $row['id'] . '_" class="gefundenerInhalt">
						<form action="/index.php/EsoBuildsearch/" method="POST">
							<input class="hidden" name="thisBuildID" value="' . $row['id'] . '" readonly="readonly">
							<div class="inhaltBeschreibung floatleft"><p><strong>Beschreibung: </strong>' . $row['beschreibung'] . '</p></div>
							<div class="infoBox floatright">
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
		
		$sql="SELECT * from eso_buildsearch_builds WHERE autor = '" . $user . "'";
		$statement = $this->zugriff->prepareStatement($sql);
		$statement->execute();
		
		/* tmp */
		$arraySpielbereich = array(0 => 'AvA', 1 => 'PvE', 2 => 'Bi-Auslegung');
		$arrayBuildauslegung = array(0 => 'Schaden', 1 => 'Support/Tank', 2 => 'Heilung');
		$arrayKlasse = array(0 => 'Drachenritter', 1 => 'Nachtklinge', 2 => 'Templer', 3 => 'Zauberer');
		$arrayWaffenset = array(0 => 'Zweihänder', 1 => 'Einhand mit Schild', 2 => 'Bogen', 
		3 => 'Zerstörungsstab', 4 => 'Wiederherstellungsstab');
		/* tmp END */
		$counter = 0;
		while ($row = $statement->fetchArray()) {
		
			$createSpielbereich = new Dropdown('Spielbereich', $arraySpielbereich);
			$createBuildauslegung = new Dropdown('Buildauslegung', $arrayBuildauslegung);
			$createKlasse = new Dropdown('Klasse', $arrayKlasse);
			$createWaffenset = new Dropdown('Hauptwaffensatz', $arrayWaffenset);
			$createWaffensetOff = new Dropdown('Nebenwaffensatz', $arrayWaffenset);
			
			$counter++;
			$classFile = $row['klasse'];
			$builds .= '
			<div class="gefundenerDatensatz">
			 <form action="/index.php/EsoBuildsearch/" method="POST">
				<input class="hidden" name="thisBuildID" value="' . $row['id'] . '" readonly="readonly">
				<div class="gefundeneUeberschrift">
					<div class="gedundenerTitel floatleft">
						<!-- <a href="javascript:toggle(\'build_' . $row['id'] . '\')">' . $row['titel'] . '</a> -->
						<a class="collapsed" data-toggle="collapse" data-parent="#myMain" href="#myBuild_' . $row['id'] . '">' . $row['titel'] . '</a>
					</div>
					<div class="gefundeneKlasse floatleft"><img title="' . $row['klasse'] . '" src="wcf/icon/' . $classFile . '.png" alt="' . $row['klasse'] . '"</img></div>
					<div class="gefundeneWaffenset floatleft">' . $row['waffenset'] . '</div>
					<div class="gefundeneWaffenset floatleft">' . $row['waffensetoff'] . '</div>
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
								<div class="createWaffenset clear">'. $createWaffenset->getSelectedDropdownWithName("edit", "Waffenset", $row['waffenset']) .'</div>
								<div class="createWaffenset clear">'. $createWaffensetOff->getSelectedDropdownWithName("edit", "WaffensetOff", $row['waffensetoff']) .'</div>
								
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
			$waffenset = strip_tags($_POST['createWaffenset']);
			$waffensetOff = strip_tags($_POST['createWaffensetOff']);
			
			$myValidate = new BuildValidate();
			
			if($myValidate->checkKlasse($klasse) != true){
				return "Die Klasse ist fehlerhaft.";
			}
			if($myValidate->checkSpielbereich($spielbereich) != true){
				return "Der Spielbereich ist fehlerhaft.";
			}
			if($myValidate->checkBuildauslegung($buildauslegung) != true){
				return "Die Buildauslegung ist fehlerhaft.";
			}
			
			$autor = WCF::getUser()->username;
			$erstellungsdatum = date("d.m.Y", time());
			 
			$sql = "
			INSERT INTO eso_buildsearch_builds (spielbereich, buildauslegung, klasse, waffenset, waffensetoff, titel, beschreibung, link, autor, erstellungsdatum) VALUES 
			('". $spielbereich ."', '". $buildauslegung ."', '". $klasse ."', '". $waffenset ."', '". $waffensetOff ."', '". $titel ."', '". $beschreibung ."', '". $link ."', '". $autor ."', '". $erstellungsdatum ."')
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
			if($user == ""){return "Die Anmelde-Session ist abgelaufen. Bitte anmelden.";}
			
			/* Testen, ob Ersteller == Updater ist; falls ja - dann aktualisieren. */
			$sql="SELECT * from eso_buildsearch_builds WHERE autor = '" . $user . "'";
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
				$waffenset = strip_tags($_POST['editWaffenset']);
				$waffensetOff = strip_tags($_POST['editWaffensetOff']);
				
				$myValidate = new BuildValidate();
				
				if($myValidate->checkKlasse($klasse) != true){
					return "Die Klasse ist fehlerhaft.";
				}
				if($myValidate->checkSpielbereich($spielbereich) != true){
					return "Der Spielbereich ist fehlerhaft.";
				}
				if($myValidate->checkBuildauslegung($buildauslegung) != true){
					return "Die Buildauslegung ist fehlerhaft.";
				}
				$erstellungsdatum = date("d.m.Y", time());
				
				$sql = "UPDATE eso_buildsearch_builds 
					SET spielbereich = '". $spielbereich ."', buildauslegung = '". $buildauslegung ."', klasse = '". $klasse ."', 
					waffenset = '". $waffenset ."', waffensetoff = '". $waffensetOff ."',  
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
			if($user == ""){return "Die Anmelde-Session ist abgelaufen. Bitte anmelden.";}
			
			$sql="SELECT * from eso_buildsearch_builds WHERE autor = '" . $user . "'";
			$statement = $this->zugriff->prepareStatement($sql);
			$statement->execute();
			$check = false;
			while ($row = $statement->fetchArray()){
				if($row['id']=$_POST['thisBuildID']){
					$check = true;
				}
			}
			if($check == true){
				$sql = "DELETE FROM eso_buildsearch_builds WHERE id = " . $_POST["thisBuildID"];
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
			
			$sql = "DELETE FROM eso_buildsearch_builds WHERE id = " . $_POST["thisBuildID"];
			$statement = $this->zugriff->prepareStatement($sql);
			$statement->execute();
			return "Build Nr. " . $_POST["thisBuildID"] . " wurde erfolgreich gelöscht.";
			
		}
	}
	
}
