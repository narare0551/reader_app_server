<?php
require_once('controllers/includes/auth.php');
require_once('controllers/includes/config.php');
require_once('controllers/includes/function.php');
require_once('controllers/includes/DB_helper.php');
//require_once('controllers/FileUploadManagementController.php');

$config = new init_Config();
if($config->error_message == 'on')
{
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
}
Theme_Config::Theme_Default();
require_once('router/router.php');
