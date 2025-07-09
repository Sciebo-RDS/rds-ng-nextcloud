<?php

use OCP\Util;

use OCA\RdsNg\AppInfo\Application;

Util::addScript(Application::APP_ID, "launcher/launcher");

Util::addStyle(Application::APP_ID, "main");
Util::addStyle(Application::APP_ID, "launcher/launcher");
?>

<div id="content" class="app-wrapper">
    <iframe id="app-frame" class="app-frame" src="<?php p($_['app-source']); ?>" title="bridgit" x-origin="<?php p($_['app-origin']); ?>"></iframe>
</div>
