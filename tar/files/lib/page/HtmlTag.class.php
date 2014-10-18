<?php
// wcf imports
require_once(WCF_DIR . 'lib/page/AbstractPage.class.php');

require_once('Gw2BuildsearchPage.class.php');
require_once('Dropdown.class.php'); 
require_once('BuildDatabase.class.php'); 

/**
 * Guild Wars 2 Buildsearch
 *
 * @author       Marcel H. 
 * @copyright    2013 Marcel H. 
 * @package      net.poebel.gw2.buildsearch
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