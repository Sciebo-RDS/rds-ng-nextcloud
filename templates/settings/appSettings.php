<?php

use OCP\Util;

use OCA\RdsNg\AppInfo\Application;

Util::addScript(Application::APP_ID, Application::APP_ID . "-settings_appsettings");

Util::addStyle(Application::APP_ID, "main");
?>

<div id="rdsng-appsettings"></div>
