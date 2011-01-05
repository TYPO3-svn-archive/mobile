<?php
if (!defined ('TYPO3_MODE')) {
 	die ('Access denied.');
}

## Register the hook to detect mobile device and re-direct IFF needed
##$TYPO3_CONF_VARS['SC_OPTIONS']['tslib/index_ts.php']['preprocessRequest']['mobile'] = 'EXT:mobile/class.tx_mobile_changer.php:tx_mobile_changer->goMobile';

## Register the frontend library to detect mobile device and re-direct IFF needed
t3lib_extMgm::addPItoST43($_EXTKEY, 'pi1/class.tx_mobile_pi1.php', '_pi1', 'includeLib', 0);

## Register the TemplaVoila hook to change Template Object at runtime
$TYPO3_CONF_VARS['EXTCONF']['templavoila']['pi1']['renderElementClass']['mobile'] = 'EXT:mobile/class.tx_mobile_changer.php:tx_mobile_changer';


?>