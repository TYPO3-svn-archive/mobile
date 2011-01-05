<?php
/**
 * $Id: ext_tables.php 26984 20-10-2010 12:00Z Chandan Web Solutions <typo3@chandanweb.com>
 */

if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

#Define the Templavoila Mobile Version
t3lib_extMgm::addPageTSConfig('

TCEFORM.tx_templavoila_tmplobj.rendertype.addItems.mobile = Mobile Version

');

// Declare static TS file
t3lib_extMgm::addStaticFile($_EXTKEY, 'static/', 'Mobile Configuration');

?>