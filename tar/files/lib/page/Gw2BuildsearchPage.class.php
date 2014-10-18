<?php
// wcf imports
require_once(WCF_DIR . 'lib/page/AbstractPage.class.php');

require_once('HtmlTag.class.php'); 
require_once('Dropdown.class.php'); 
require_once('BuildDatabase.class.php'); 
require_once('BuildValidate.class.php');

/**
 * Guild Wars 2 Buildsearch
 *
 * @author       Marcel H. 
 * @copyright    2013 Marcel H. 
 * @package      net.poebel.gw2.buildsearch
 */
class Gw2BuildsearchPage extends AbstractPage
{
    public $templateName = 'Gw2Buildsearch';
	
	private $siteName="Gw2 Buildsuche";
	private $siteBeschreibung="Realisation durch Merlin.6750/Marcel H.";
	
	public function __construct ()
	{ 
		$instanz = WCF::getTPL();
		$instanz->assign('siteBeschreibung', $this -> siteBeschreibung);
		$instanz->assign('siteName', $this -> siteName);
		$this -> makeSomeChances($instanz);
		$this -> filter($instanz);
		$this -> inhalt($instanz);
		$this -> create($instanz);
		$this -> edit($instanz);
		parent::__construct();
	}
	
	public function filter($instanz)
	{
		$arraySpielbereich = array(0 => 'alle', 1 => 'WvW', 2 => 'PvE', 3 => 'sPvP');
		$arrayBuildauslegung = array(0 => 'alle', 1 => 'Schaden', 2 => 'Support/Tank', 3 => 'Bi-Auslegung');
		$arrayKlasse = array(0 => 'alle', 1 => 'Krieger', 2 => 'Wächter', 3 => 'Dieb', 4 => 'Ingenieur', 5 => 'Waldläufer', 6 => 'Elementarmagier', 7 => 'Mesmer', 8 => 'Nekromant');
		$arrayHaupthand = array(0 => 'alle', 1 => 'Gewehr', 2 => 'Grossschwert', 3 => 'Hammer', 4 => 'Kurzbogen', 5 => 'Langbogen', 6 => 'Stab', 
								7 => 'Axt', 8 => 'Dolch', 9 => 'Pistole', 10 => 'Schwert', 11 => 'Streitkolben', 
								12 => 'Zepter');
		$arrayNebenhand = array(0 => 'alle', 1 => 'Axt', 2 => 'Dolch', 3 => 'Pistole', 4 => 'Schwert', 5 => 'Streitkolben', 
								6 => 'Fackel', 7 => 'Fokus', 8 => 'Kriegshorn', 9 => 'Schild');
		
		$filterSpielbereich = new Dropdown('Spielbereich', $arraySpielbereich);
		$filterBuildauslegung = new Dropdown('Buildauslegung', $arrayBuildauslegung);
		$filterKlasse = new Dropdown('Klasse', $arrayKlasse);
		$filterHaupthand = new Dropdown('Haupthand', $arrayHaupthand);
		$filterBegleithand = new Dropdown('Begleithand', $arrayNebenhand);

		$myFilter = '
			<form action="/index.php?page=Gw2Buildsearch#myMain" method="POST">
				<div id="filter_inhalt">
				
				'. $filterSpielbereich->getDropdown() .'
				'. $filterBuildauslegung->getDropdown() .'
				'. $filterKlasse->getDropdown() .'
				'. $filterHaupthand->getDropdown() .'
				'. $filterBegleithand->getDropdown() .'
				
				</div>	
			</form>
		';
		$instanz->assign('filter', $myFilter);
	}
	
	public function inhalt($instanz)
	{
		$anbindung = new BuildDatabase();
		$myDatensatz = $anbindung->getBuilds();
		$instanz->assign('datensatz', $myDatensatz);
	}
	
	public function create($instanz)
	{
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
		
		$valueTitel = "";
		$valueBeschreibung = "";
		$valueLink = ""; 
		
		if(!empty($_POST['createTitel'])){
			$valueTitel = strip_tags($_POST['createTitel']);
		} 
		if(!empty($_POST['createBeschreibung'])){
			$valueBeschreibung = strip_tags($_POST['createBeschreibung']);
		} 
		if(!empty($_POST['createLink'])){
			$valueLink = strip_tags($_POST['createLink']);
		} 
		
		$myCreateForm = '
			<form action="/index.php?page=Gw2Buildsearch" method="POST">
				<div class="createTitel">
					<label>Kurzbeschreibung</label>
					<input type="text" size="40" maxlength="45" name="createTitel" value="' . $valueTitel . '"> 
				</div>
				<div class="createLink">
					<label>Link zum Build</label>
					<input type="text" size="40" maxlength="990" name="createLink" value="' . $valueLink . '"> 
				</div>
				<div class="createBeschreibung">
					<label>Ausführliche Beschreibung</label>
					<textarea name="createBeschreibung" cols="50" rows="10" maxlength="9950">' . $valueBeschreibung . '</textarea>
				</div>
				
				<div class="createKlasse">'. $createKlasse->getOnlyDropdown("create") .'</div>
				<div class="createSpielbereich">'. $createSpielbereich->getOnlyDropdown("create") .'</div>
				<div class="createBuildauslegung">'. $createBuildauslegung->getOnlyDropdown("create") .'</div>
				<div class="createHaupthand">'. $createHaupthand->getOnlyDropdownWithName("create", "Haupthand") .'</div>
				<div class="createBegleithand">'. $createBegleithand->getOnlyDropdownWithName("create", "Nebenhand") .'</div>
				<div class="createHaupthand">'. $createHaupthandOff->getOnlyDropdownWithName("create", "HaupthandOff") .'</div>
				<div class="createBegleithand">'. $createBegleithandOff->getOnlyDropdownWithName("create", "NebenhandOff") .'</div>
				
				<div class="buttons">
					<input name="safeBuild" class="button" type="submit" value="Build speichern">
					<!-- <a class="button" href="javascript:toggle(\'createBuild\')">Abbrechen</a> -->
					<a class="button" data-toggle="collapse" data-parent="#myMain" href="#createBuild_">Abbrechen</a>
				</div>
		</form>
		';

		$instanz->assign('createBuild', $myCreateForm);
		
	}
	
	public function edit($instanz)
	{
		$anbindung = new BuildDatabase();
		$myEditForms = $anbindung->getMyBuilds();
		$instanz->assign('editBuild', $myEditForms);
	}
	
	public function makeSomeChances($instanz)
	{
		$anbindung = new BuildDatabase();
		$myResult = $anbindung->setNewBuild();
		$myResult .= $anbindung->setEditBuild();
		$myResult .= $anbindung->deleteBuild();
		
		$myChance = "";
		if(!empty($myResult)){
			$myChance = '<div id="infoBox">' . $myResult . '</div>';
		}
		$instanz->assign('myChance', $myChance);
	}
}








