<?php
/* ----------------------------------------------------------------------------
 * Easy!Appointments - Online Appointment Scheduler
 *
 * @package     EasyAppointments
 * @author      A.Tselegidis <alextselegidis@gmail.com>
 * @copyright   Copyright (c) Alex Tselegidis
 * @license     https://opensource.org/licenses/GPL-3.0 - GPLv3
 * @link        https://easyappointments.org
 * @since       v1.0.0
 * ---------------------------------------------------------------------------- */

/**
 * Easy!Appointments Configuration File
 *
 * Set your installation BASE_URL * without the trailing slash * and the database
 * credentials in order to connect to the database. You can enable the DEBUG_MODE
 * while developing the application.
 *
 * Set the default language by changing the LANGUAGE constant. For a full list of
 * available languages look at the /application/config/config.php file.
 *
 * IMPORTANT:
 * If you are updating from version 1.0 you will have to create a new "config.php"
 * file because the old "configuration.php" is not used anymore.
 */

$baseUrl = getenv('EA_BASE_URL');
$baseUrl = $baseUrl === false || $baseUrl === '' ? 'https://calender.sdpflashinfotech.com' : rtrim($baseUrl, '/');
define('EA_BASE_URL', $baseUrl);

$language = getenv('EA_LANGUAGE');
$language = $language === false || $language === '' ? 'english' : $language;
define('EA_LANGUAGE', $language);

$debugMode = getenv('EA_DEBUG_MODE');
$debugMode = filter_var($debugMode, FILTER_VALIDATE_BOOL, ['flags' => FILTER_NULL_ON_FAILURE]);
define('EA_DEBUG_MODE', $debugMode === null ? false : $debugMode);

$dbHost = getenv('EA_DB_HOST');
$dbHost = $dbHost === false || $dbHost === '' ? 'mysql' : $dbHost;
define('EA_DB_HOST', $dbHost);

$dbName = getenv('EA_DB_NAME');
$dbName = $dbName === false || $dbName === '' ? 'easyappointments' : $dbName;
define('EA_DB_NAME', $dbName);

$dbUser = getenv('EA_DB_USERNAME');
$dbUser = $dbUser === false || $dbUser === '' ? 'user' : $dbUser;
define('EA_DB_USERNAME', $dbUser);

$dbPass = getenv('EA_DB_PASSWORD');
$dbPass = $dbPass === false ? 'password' : $dbPass;
define('EA_DB_PASSWORD', $dbPass);

$googleSync = getenv('EA_GOOGLE_SYNC_FEATURE');
$googleSync = filter_var($googleSync, FILTER_VALIDATE_BOOL, ['flags' => FILTER_NULL_ON_FAILURE]);
define('EA_GOOGLE_SYNC_FEATURE', $googleSync === null ? false : $googleSync);

$googleClientId = getenv('EA_GOOGLE_CLIENT_ID');
$googleClientId = $googleClientId === false ? '' : $googleClientId;
define('EA_GOOGLE_CLIENT_ID', $googleClientId);

$googleClientSecret = getenv('EA_GOOGLE_CLIENT_SECRET');
$googleClientSecret = $googleClientSecret === false ? '' : $googleClientSecret;
define('EA_GOOGLE_CLIENT_SECRET', $googleClientSecret);

class Config
{
    // ------------------------------------------------------------------------
    // GENERAL SETTINGS
    // ------------------------------------------------------------------------

    const BASE_URL = EA_BASE_URL;
    const LANGUAGE = EA_LANGUAGE;
    const DEBUG_MODE = EA_DEBUG_MODE;

    // ------------------------------------------------------------------------
    // DATABASE SETTINGS
    // ------------------------------------------------------------------------

    const DB_HOST = EA_DB_HOST;
    const DB_NAME = EA_DB_NAME;
    const DB_USERNAME = EA_DB_USERNAME;
    const DB_PASSWORD = EA_DB_PASSWORD;

    // ------------------------------------------------------------------------
    // GOOGLE CALENDAR SYNC
    // ------------------------------------------------------------------------

    const GOOGLE_SYNC_FEATURE = EA_GOOGLE_SYNC_FEATURE; // Enter TRUE or FALSE
    const GOOGLE_CLIENT_ID = EA_GOOGLE_CLIENT_ID;
    const GOOGLE_CLIENT_SECRET = EA_GOOGLE_CLIENT_SECRET;
}
