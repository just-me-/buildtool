<?php
// wcf imports
namespace wcf\page;
use wcf\system\WCF;

require_once('BuildDatabase.class.php');

/**
 * Guild Wars 2 Buildsearch
 *
 * @author       Marcel H. 
 * @copyright    2014 Marcel H. 
 * @package      ch.merlin.eso.buildsearch
 */
class BuildValidate
{	
	
	public function checkSpielbereich($spielbereich)
	{
		$arraySpielbereich = array(0 => 'AvA', 1 => 'PvE', 2 => 'Bi-Auslegung');
		if (in_array($spielbereich, $arraySpielbereich)) {
			return true; 
		}
		return false; 
	}
	
	public function checkBuildauslegung($buildauslegung)
	{
		$arrayBuildauslegung = array(0 => 'Schaden', 1 => 'Schaden/Heilung', 2 => 'Support/Tank', 3 => 'Heilung', 4 => 'Heilung/Schaden');
		if (in_array($buildauslegung, $arrayBuildauslegung)) {
			return true; 
		}
		return false; 
	}
	
	public function checkKlasse($klasse)
	{
		$arrayKlasse = array(0 => 'Drachenritter', 1 => 'Nachtklinge', 2 => 'Templer', 3 => 'Zauberer');
		if (in_array($klasse, $arrayKlasse)) {
			return true; 
		}
		return false;
	}
	
	public function checkWeapon($waffenset, $begleithand, $klasse)
	{
		// there is no weapon validate for eso 
		return true;
	}
}










