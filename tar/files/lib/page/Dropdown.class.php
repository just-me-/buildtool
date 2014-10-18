<?php
// wcf imports
require_once(WCF_DIR . 'lib/page/AbstractPage.class.php');

require_once('Gw2BuildsearchPage.class.php');
require_once('HtmlTag.class.php'); 
require_once('BuildDatabase.class.php'); 

/**
 * Guild Wars 2 Buildsearch
 *
 * @author       Marcel H. 
 * @copyright    2013 Marcel H. 
 * @package      net.poebel.gw2.buildsearch
 */
class Dropdown
{	
	private $label; 
	private $arrayOptions;
	private $htmlOptions;
	private $htmlTag; 
	
	public function __construct ($label, $arrayOptions)
	{
		$this->label=$label; 
		$this->arrayOptions=$arrayOptions;	
	}
	
	private function buildOptions()
	{
		$this->htmlTag = '
			<div class="filter_'. $this->label .' floatleft"><label class="clear">'. $this->label .'</label>
			<select name="'. $this->label .'" onchange="this.form.submit()">
			';
		foreach($this->arrayOptions as $myOption){ 
			$selected = '';
			if(!empty($_POST[$this->label]) && $_POST[$this->label] == $myOption){
				$selected = 'selected';
			}
			$this->htmlOptions .= '<option '. $selected . ' value="' . $myOption . '"  >' . $myOption . '</option>';
		}
		$this->htmlTag .= $this->htmlOptions; 
		$this->htmlTag .= '</select></div>';
	}
	
	public function getDropdown()
	{
		$this->buildOptions();
		return $this->htmlTag;
	}
	
	public function getOnlyDropdown($name)
	{
		$this->htmlTag = '
			<label>'. $this->label .'</label>
			<select name="'. $name . $this->label .'">
			';
		foreach($this->arrayOptions as $myOption){ 
			$this->htmlOptions .= '<option value="' . $myOption . '"  >' . $myOption . '</option>';
		}
		$this->htmlTag .= $this->htmlOptions; 
		$this->htmlTag .= '</select>';
		
		return $this->htmlTag;
	}
	
	public function getOnlyDropdownWithName($name, $name2)
	{
		$this->htmlTag = '
			<label>'. $this->label .'</label>
			<select name="'. $name . $name2 .'">
			';
		foreach($this->arrayOptions as $myOption){ 
			$this->htmlOptions .= '<option value="' . $myOption . '"  >' . $myOption . '</option>';
		}
		$this->htmlTag .= $this->htmlOptions; 
		$this->htmlTag .= '</select>';
		
		return $this->htmlTag;
	}
	
	
		public function getSelectedDropdown($name, $selected)
	{
		$this->htmlTag = '
			<label>'. $this->label .'</label>
			<select name="'. $name . $this->label .'">
			';
		if($selected == ""){
			$selected = "-";
		}
		foreach($this->arrayOptions as $myOption){ 
			$select = "";
			if($myOption == $selected)
			{
				$select = "selected"; 
			}
			$this->htmlOptions .= '<option ' . $select . ' value="' . $myOption . '"  >' . $myOption . '</option>';
		}
		$this->htmlTag .= $this->htmlOptions; 
		$this->htmlTag .= '</select>';
		
		return $this->htmlTag;
	}
	
	public function getSelectedDropdownWithName($name, $name2, $selected)
	{
		$this->htmlTag = '
			<label>'. $this->label .'</label>
			<select name="'. $name . $name2 .'">
			';
		if($selected == ""){
			$selected = "-";
		}
		foreach($this->arrayOptions as $myOption){ 
			$select = "";
			if($myOption == $selected)
			{
				$select = "selected"; 
			}
			$this->htmlOptions .= '<option ' . $select . ' value="' . $myOption . '"  >' . $myOption . '</option>';
		}
		$this->htmlTag .= $this->htmlOptions; 
		$this->htmlTag .= '</select>';
		
		return $this->htmlTag;
	}
	
	
}
