<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010-2011 Chandan Web Solutions (typo3 AT chandanweb.com)
*  All rights reserved
*
*  This script is part of the Typo3 project. The Typo3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*  A copy is found in the textfile GPL.txt and important notices to the license
*  from the author is found in LICENSE.txt distributed with these scripts.
*
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

/**
 * Hook 'TemplaVolia Mobile Changer' for the 'Mobile Version' extension.
 *
 * @author	Chandan Web Solutions (typo3@chandanweb.com)
 *
 */
class tx_mobile_changer {
	public $extKey = 'mobile';
	private $mobileUrl ;
	private $mobileVersionType ;
	private $curHOST;
	private $curTYPE;	
	
	public function __construct(){
		$confArr = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$this->extKey]);		
		$this->mobileUrl = $confArr['MobileURL'];
		$this->mobileVersionType = $confArr['MobileVersionType'];
		$this->curHOST = t3lib_div::getIndpEnv("HTTP_HOST");
		$this->curTYPE= t3lib_div::_GET("type");
	}
    function renderElement_preProcessRow( &$row, &$table, &$tv_plugin )    {

		//redirect to mobile version if a mobilebrowser/device is detected
		//$this->goMobile();
		
		//if we are in the mobile version, let us use corresponding TO				
		if ( $this->curHOST == $this->mobileUrl && $this->curTYPE == $this->mobileVersionType ) {			
			$row["tx_templavoila_to"] = $this->getChildTemplate($row,'mobile');			
		}

		//print_r($row);
		return;
    }

	public function getChildTemplate($row,$renderType) {
		$this->markupObj = t3lib_div::makeInstance('tx_templavoila_htmlmarkup');
        $TOrec = $this->markupObj->getTemplateRecord($row['tx_templavoila_to'], $renderType, $GLOBALS['TSFE']->sys_language_uid);
		return $TOrec['uid'];
	}
		
}

if (defined("TYPO3_MODE") && $TYPO3_CONF_VARS[TYPO3_MODE]["XCLASS"]["ext/mobile/class.tx_mobile_changer.php"])    {
    include_once($TYPO3_CONF_VARS[TYPO3_MODE]["XCLASS"]["ext/mobile/class.tx_mobile_changer.php"]);
}
?>