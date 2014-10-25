<?php
// wcf imports
namespace wcf\page;
use wcf\system\WCF;

require_once('EsoBuildsearchPage.class.php');
require_once('Dropdown.class.php'); 
require_once('BuildDatabase.class.php'); 

/**
 * Guild Wars 2 Buildsearch
 *
 * @author       Marcel H. 
 * @copyright    2014 Marcel H. 
 * @package      ch.merlin.eso.buildsearch
 */
class HtmlTag
{	
	private $class="";
	private $id="";
	private $style="";
	private $tag=""; 
	
	public function __construct ()
	{
		 
	}
	
	public function getTag()
	{
		return $this -> tag;
	}
	
	
}