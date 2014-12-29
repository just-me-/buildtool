<?php
// wcf imports
namespace wcf\page;
use wcf\system\WCF;

require_once('HtmlTag.class.php'); 
require_once('Dropdown.class.php'); 
require_once('BuildDatabase.class.php'); 
require_once('BuildValidate.class.php');

/**
 * Guild Wars 2 Buildsearch
 *
 * @author       Marcel H. 
 * @copyright    2014 Marcel H. 
 * @package      ch.merlin.eso.buildsearch
 */
class EsoBuildsearchPage extends AbstractPage
{
    public $templateName = 'EsoBuildsearch';
	
	private $siteName="ESO Buildsuche";
	private $siteBeschreibung="Realisation durch <b>@Just_Merlin/Marcel H.</b>";
	
	public function readData() 
	{
        parent::readData(); 
		$instanz = WCF::getTPL();
		$instanz->assign('siteBeschreibung', $this -> siteBeschreibung);
		$instanz->assign('siteName', $this -> siteName);
		$this -> makeSomeChances($instanz);
		$this -> filter($instanz);
		$this -> inhalt($instanz);
		$this -> create($instanz);
		$this -> edit($instanz);
	}
	
	public function filter($instanz)
	{
		$arraySpielbereich = array(0 => 'alle', 1 => 'AvA', 2 => 'PvE', 3 => 'Bi-Auslegung');
		$arrayBuildauslegung = array(0 => 'alle', 1 => 'Schaden', 2 => 'Support/Tank', 3 => 'Heilung');
		$arrayKlasse = array(0 => 'alle', 1 => 'Drachenritter', 2 => 'Nachtklinge', 3 => 'Templer', 4 => 'Zauberer');
		$arrayWaffenset = array(0 => 'alle', 1 => 'Zweihänder', 2 => 'Beidhändig', 3 => 'Einhand mit Schild', 4 => 'Bogen', 
		5 => 'Zerstörungsstab', 6 => 'Wiederherstellungsstab');
		
		$filterSpielbereich = new Dropdown('Spielbereich', $arraySpielbereich);
		$filterBuildauslegung = new Dropdown('Buildauslegung', $arrayBuildauslegung);
		$filterKlasse = new Dropdown('Klasse', $arrayKlasse);
		$filterWaffenset = new Dropdown('Waffenset', $arrayWaffenset);

		$myFilter = '
			<form action="/index.php/EsoBuildsearch#myMain" method="POST">
				<div id="filter_inhalt">
				
				'. $filterSpielbereich->getDropdown() .'
				'. $filterBuildauslegung->getDropdown() .'
				'. $filterKlasse->getDropdown() .'
				'. $filterWaffenset->getDropdown() .'
				
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
		$arraySpielbereich = array(0 => 'AvA', 1 => 'PvE', 2 => 'Bi-Auslegung');
		$arrayBuildauslegung = array(0 => 'Schaden', 1 => 'Support/Tank', 2 => 'Heilung');
		$arrayKlasse = array(0 => 'Drachenritter', 1 => 'Nachtklinge', 2 => 'Templer', 3 => 'Zauberer');
		$arrayWaffenset = array(0 => 'Zweihänder', 1 => 'Beidhändig', 2 => 'Einhand mit Schild', 3 => 'Bogen', 
		4 => 'Zerstörungsstab', 5 => 'Wiederherstellungsstab');
		
		$createSpielbereich = new Dropdown('Spielbereich', $arraySpielbereich);
		$createBuildauslegung = new Dropdown('Buildauslegung', $arrayBuildauslegung);
		$createKlasse = new Dropdown('Klasse', $arrayKlasse);
		$createWaffenset = new Dropdown('Hauptwaffensatz', $arrayWaffenset);
		$createWaffensetOff = new Dropdown('Nebenwaffensatz', $arrayWaffenset);
		
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
			<form action="/index.php/EsoBuildsearch/" onsubmit="return validateNewBuild()" method="POST">
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
				<div class="createWaffenset">'. $createWaffenset->getOnlyDropdownWithName("create", "Waffenset") .'</div>
				<div class="createWaffensetOff">'. $createWaffensetOff->getOnlyDropdownWithName("create", "WaffensetOff") .'</div>
				
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
	
	public function assignVariables() {
        parent::assignVariables();
        // TODO - ausmisten und hier gruppieren
    }
}








