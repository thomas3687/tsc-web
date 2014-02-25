<?php
/**
 * MySQL Database Configuration
 *
 * @file /includes/config.inc.php
 * @note Replace the settings below with those for your MySQL database.
 */

ini_set('display_errors', 1);

define('DB_HOSTNAME', 'localhost');
define('DB_USERNAME', 'web311');
define('DB_PASSWORD', 'astoria');
define('DB_DATABASE', 'usr_web311_2');


define('STATE_NEW', 'NEW');
define('STATE_CONFIRMED', 'CONF');
define('STATE_REJECTED', 'REJ');

define('STATE_DESC_NEW', 'Offen');
define('STATE_DESC_CONFIRMED', 'Gemeldet');
define('STATE_DESC_REJECTED', 'Abgelehnt');

?>