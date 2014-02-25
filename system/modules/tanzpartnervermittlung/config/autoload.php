<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2013 Leo Feyer
 *
 * @package Tanzpartnervermittlung
 * @link    https://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Register the namespaces
 */
/*ClassLoader::addNamespaces(array
(
	'TSC_ASTORIA',
));
*/

/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Modules
	'ModuleTanzpartnervermittlungList'   => 'system/modules/tanzpartnervermittlung/modules/ModuleTanzpartnervermittlungList.php',
	'ModuleTanzpartnervermittlungDetail' => 'system/modules/tanzpartnervermittlung/modules/ModuleTanzpartnervermittlungDetail.php',
	'ModuleTanzpartnervermittlungNeu' => 'system/modules/tanzpartnervermittlung/modules/ModuleTanzpartnervermittlungNeu.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'mod_tanzpartnervermittlung_list'   => 'system/modules/tanzpartnervermittlung/templates',
	'mod_tanzpartnervermittlung_detail' => 'system/modules/tanzpartnervermittlung/templates',
	'mod_tanzpartnervermittlung_neu' 	=> 'system/modules/tanzpartnervermittlung/templates',
));
