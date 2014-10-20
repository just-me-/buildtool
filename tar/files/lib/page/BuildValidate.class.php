<?php
// wcf imports
namespace wcf\page;
use wcf\system\WCF;

require_once('BuildDatabase.class.php');

/**
 * Guild Wars 2 Buildsearch
 *
 * @author       Marcel H. 
 * @copyright    2013 Marcel H. 
 * @package      net.poebel.gw2.buildsearch
 */
class BuildValidate
{	
	
	public function checkSpielbereich($spielbereich)
	{
		$arraySpielbereich = array(0 => 'WvW', 1 => 'PvE', 2 => 'sPvP');
		if (in_array($spielbereich, $arraySpielbereich)) {
			return true; 
		}
		return false; 
	}
	
	public function checkBuildauslegung($buildauslegung)
	{
		$arrayBuildauslegung = array(0 => 'Schaden', 1 => 'Support/Tank', 2 => 'Bi-Auslegung');
		if (in_array($buildauslegung, $arrayBuildauslegung)) {
			return true; 
		}
		return false; 
	}
	
	public function checkKlasse($klasse)
	{
		$arrayKlasse = array(0 => 'Krieger', 1 => 'Wächter', 2 => 'Dieb', 3 => 'Ingenieur', 4 => 'Waldläufer', 5 => 'Elementarmagier', 6 => 'Mesmer', 7 => 'Nekromant');
		if (in_array($klasse, $arrayKlasse)) {
			return true; 
		}
		return false;
	}
	
	public function checkWeapon($haupthand, $begleithand, $klasse)
	{
		$zweihand = false; 
		$arrayZweihand = array(0 => 'Gewehr', 1 => 'Grossschwert', 2 => 'Hammer', 3 => 'Kurzbogen', 4 => 'Langbogen', 5 => 'Stab');
		if (in_array($haupthand, $arrayZweihand)) {
			if($begleithand != "-"){
				/* Zweihandwaffe + Nebenhand */
				return false; 
			}
		}
		$arrayHaupthand = array(0 => 'Gewehr', 1 => 'Grossschwert', 2 => 'Hammer', 3 => 'Kurzbogen', 4 => 'Langbogen', 5 => 'Stab', 
								6 => 'Axt', 7 => 'Dolch', 8 => 'Pistole', 9 => 'Schwert', 10 => 'Streitkolben', 11 => 'Zepter');
		$arrayNebenhand = array(0 => '-', 1 => 'Axt', 2 => 'Dolch', 3 => 'Pistole', 4 => 'Schwert', 5 => 'Streitkolben', 
								6 => 'Fackel', 7 => 'Fokus', 8 => 'Kriegshorn', 9 => 'Schild');
		if (!in_array($haupthand, $arrayHaupthand)) {
			return false; 
		}
		if (!in_array($begleithand, $arrayNebenhand)) {
			return false; 
		}
		/* Es wurde geprueft, ob nicht etwas "reingeschmuggelt wurde" */
		
		if($klasse == "Krieger"){
			$arrayHaupthand = array('Gewehr', 'Grossschwert', 'Hammer', 'Langbogen', 
								'Axt', 'Schwert', 'Streitkolben');
			$arrayNebenhand = array('-', 'Axt', 'Schwert', 'Streitkolben', 
								'Kriegshorn', 'Schild');
		}
		if($klasse == "Wächter"){
			$arrayHaupthand = array('Grossschwert', 'Hammer', 'Stab', 'Schwert', 'Streitkolben', 'Zepter');
			$arrayNebenhand = array('-', 'Fackel', 'Fokus', 'Schild');
		}
		if($klasse == "Dieb"){
			$arrayHaupthand = array('Kurzbogen', 'Dolch', 'Pistole', 'Schwert');
			$arrayNebenhand = array('-', 'Dolch', 'Pistole');
		}
		if($klasse == "Ingenieur"){
			$arrayHaupthand = array('Gewehr', 'Pistole');
			$arrayNebenhand = array('-', 'Pistole', 'Schild');
		}
		if($klasse == "Waldläufer"){
			$arrayHaupthand = array('Grossschwert', 'Kurzbogen', 'Langbogen', 'Axt', 'Schwert');
			$arrayNebenhand = array('-', 'Axt', 'Dolch', 'Fackel', 'Kriegshorn');
		}
		if($klasse == "Elementarmagier"){
			$arrayHaupthand = array('Stab', 'Dolch', 'Zepter');
			$arrayNebenhand = array('-', 'Dolch', 'Fokus');
		}
		if($klasse == "Mesmer"){
			$arrayHaupthand = array('Grossschwert', 'Stab', 'Schwert', 'Zepter');
			$arrayNebenhand = array('-', 'Pistole', 'Schwert', 'Fackel', 'Fokus');
		}
		if($klasse == "Nekromant"){
			$arrayHaupthand = array('Stab', 'Axt', 'Dolch', 'Zepter');
			$arrayNebenhand = array('-', 'Axt', 'Dolch', 'Fokus', 'Kriegshorn');
		}
		/* Die Möglichen Kombinationen wurden der gewaehlten Klasse zugewisen */
		
		if (in_array($haupthand, $arrayHaupthand)) {
			if (in_array($begleithand, $arrayNebenhand)) {
				return true; 
			} 
		}
		return false; 
	}
}










