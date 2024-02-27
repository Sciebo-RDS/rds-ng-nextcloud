<?php

use OCP\Util;

use OCA\RdsNg\AppInfo\Application;

Util::addScript(Application::APP_ID, "settings/appsettings");

Util::addStyle(Application::APP_ID, "main");
Util::addStyle(Application::APP_ID, "settings/appsettings");
?>

<div id="settings" class="section">
    <h2>RDS NG Settings</h2>

    <form id="settings-form">
        <div id="main-settings-section">
            <div class="section-header">
                <h3>Main</h3>
            </div>
            <div>Configure the main RDS NG settings.</div>
            <div>&nbsp;</div>

            <div class="settings-table settings-table-main">
                <label for="app-url">RDS NG URL:</label>
                <input id="app-url" type="text" style="width: 400px;" placeholder="https://www.mydomain.com" value="<?php p($_['app_url']) ?>"/>
                <div style="padding-left: 1rem;"><em>Enter the URL of your RDS NG instance.</em></div>
            </div>
        </div>
    </form>

    <div>&nbsp;</div>
    <div id="success-message" class="success-message" style="display: none;">Settings saved!</div>
</div>
