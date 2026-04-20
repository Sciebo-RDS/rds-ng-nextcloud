<?php

use OCP\Util;

use OCA\RdsNg\AppInfo\Application;

Util::addScript(Application::APP_ID, "settings/appsettings");

Util::addStyle(Application::APP_ID, "main");
Util::addStyle(Application::APP_ID, "settings/appsettings");

?>

<div id="settings" class="section">
    <h2>bridgit settings</h2>

    <form id="settings-form" style="padding-bottom: 1rem; width: 600px;">
        <div id="main-settings-section" style="padding-bottom: 1rem;">
            <div class="section-header">
                <h3>Main</h3>
            </div>
            <div style="padding-bottom: 1rem;">Configure the main bridgit settings.</div>

            <div style="font-weight: bold; font-size: 110%;">Frontend</div>
            <div class="settings-table settings-table-main">
                <label for="app-url">Frontend URL:</label>
                <input id="app-url" type="text" style="width: 400px;" placeholder="https://www.mydomain.com" value="<?php p($_['app_url']) ?>"/>
                <div class="settings-table-info"><em>The URL of your bridgit Frontend.</em></div>

                <label for="instance-id">Instance ID:</label>
                <input id="instance-id" type="text" style="width: 400px;" placeholder="some-id" value="<?php p($_['instance_id']) ?>"/>
                <div class="settings-table-info"><em>A cluster-unique identifier for this instance (used to distinguish multiple hosts using a single bridgit deployment).</em></div>
            </div>

            <div style="font-weight: bold; font-size: 110%; margin-top: 25px;">Backend</div>
            <div class="settings-table settings-table-main">
                <label for="domo-url">Domo URL:</label>
                <input id="domo-url" type="text" style="width: 400px;" placeholder="https://www.mydomain.com" value="<?php p($_['domo_url']) ?>"/>
                <div class="settings-table-info"><em>The URL of your bridgit Domo.</em></div>

                <label for="api-key">API Key:</label>
                <input id="api-key" type="text" style="width: 400px;" placeholder="some-key" value="<?php p($_['api_key']) ?>"/>
                <div class="settings-table-info"><em>The API key used to communicate directly with bridgit (must be the same as used during the deployment of bridgit).</em></div>
            </div>
        </div>
    </form>

    <div id="success-message" class="success-message" style="display: none;">Settings saved!</div>
</div>
