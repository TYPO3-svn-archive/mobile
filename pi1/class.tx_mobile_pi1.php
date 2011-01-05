<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010 Prakash A Bhat <spabhat@spabhat.com>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/
/**
 * [CLASS/FUNCTION INDEX of SCRIPT]
 *
 * Hint: use extdeveval to insert/update function index above.
 */

require_once(PATH_tslib.'class.tslib_pibase.php');


/**
 * Plugin 'Mobile Changer' for the 'mobile' extension.
 *
 * @author	 <>
 * @package	TYPO3
 * @subpackage	tx_mobile
 */
class tx_mobile_pi1 extends tslib_pibase {
	var $prefixId      = 'tx_mobile_pi1';		// Same as class name
	var $scriptRelPath = 'pi1/class.tx_mobile_pi1.php';	// Path to this script relative to the extension dir.
	var $extKey        = 'mobile';	// The extension key.
	var $pi_checkCHash = true;
	private $mobileUrl;
	private $mobileVersionType ;
	private $curHOST;
	private $curTYPE;
	
	/**
	 * The main method of the PlugIn
	 *
	 * @param	string		$content: The PlugIn content
	 * @param	array		$conf: The PlugIn configuration
	 * @return	The content that is displayed on the website
	 */
	public function main($content, $conf)	{
		/*return 'Hello World!<HR>
			Here is the TypoScript passed to the method:'.
					t3lib_div::view_array($conf);
					*/
		$confArr = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$this->extKey]);
		$this->mobileUrl = $confArr['MobileURL'];
		$this->mobileVersionType = $confArr['MobileVersionType'];
		$this->curHOST = t3lib_div::getIndpEnv("HTTP_HOST");
		$this->curTYPE= t3lib_div::_GP("type");
		
		return $this->goMobile();
	}
	
	private function goMobile(){

		$goMobile = true;		
		
		//if we are already on the mobile version, then we should not re-direct to mobile version again
		//if( $this->curHOST == $this->mobileUrl && $this->curTYPE == $this->mobileVersionType && $this->isMobileDevice() )
		if( $this->curHOST == $this->mobileUrl && $this->curTYPE == $this->mobileVersionType && $this->isMobileDevice() ){
			$GLOBALS["TSFE"]->fe_user->setKey('ses','tx_mobile_gomobile',TRUE);
			//$_SESSION[$this->mobileUrl.'tx_mobile_gomobile'] = 'true';					
			return;
		}
		
		$sessionData = $GLOBALS["TSFE"]->fe_user->getKey('ses','tx_mobile_gomobile');
		
		if( isset($_GET['goMobile']) && $_GET['goMobile'] == 'false' ){
			$goMobile = FALSE;			
		}elseif( isset($_GET['goMobile']) && $_GET['goMobile'] == 'true' ){
			$goMobile = TRUE;
		}
		if( $sessionData == FALSE){
			$goMobile = FALSE;			
		}

		if($confArr['EnableLogging']){
			t3lib_div::devLog('','mobile' , 0, array($goMobile,));
		}
		//store session details		
		$GLOBALS["TSFE"]->fe_user->setKey('ses','tx_mobile_gomobile',$goMobile);
		
		if( $goMobile && $this->isMobileDevice() ){
			header("Location: http://" . $this->mobileUrl . '/?type=' . $this->mobileVersionType);
			exit;
		}
	}
	
	private function isMobileDevice(){
		//Detection code obtainined from: http://detectmobilebrowser.com/download/php
		$useragent = t3lib_div::getIndpEnv('HTTP_USER_AGENT');
		$mobileBrowserOrDeviceFound = (preg_match('/android|avantgo|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|e\-|e\/|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(di|rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|xda(\-|2|g)|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)));
		
		return $mobileBrowserOrDeviceFound;
	}
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/mobile/pi1/class.tx_mobile_pi1.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/mobile/pi1/class.tx_mobile_pi1.php']);
}

?>