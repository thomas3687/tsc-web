<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2013 Leo Feyer
 *
 * @package Turnierpaare
 * @link    https://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Modules
	'ModuleTurnierpaareList'   => 'system/modules/turnierpaare/modules/ModuleTurnierpaareList.php',
	'ModuleTurnierpaareDetail' => 'system/modules/turnierpaare/modules/ModuleTurnierpaareDetail.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'mod_turnierpaare_detail' => 'system/modules/turnierpaare/templates',
	'mod_turnierpaare_list'   => 'system/modules/turnierpaare/templates',
));
