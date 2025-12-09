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

            <div class="settings-table settings-table-main">
                <label for="app-url">bridgit URL:</label>
                <input id="app-url" type="text" style="width: 400px;" placeholder="https://www.mydomain.com" value="<?php p($_['app_url']) ?>"/>
                <div class="settings-table-info"><em>The URL of your bridgit instance.</em></div>

                <label for="instance-id">Instance ID:</label>
                <input id="instance-id" type="text" style="width: 400px;" placeholder="some-id" value="<?php p($_['instance_id']) ?>"/>
                <div class="settings-table-info"><em>A cluster-unique identifier for this instance (used to distinguish multiple hosts using a single bridgit deployment).</em></div>
            </div>
        </div>

        <div id="security-settings-section">
            <div class="section-header">
                <h3>Security</h3>
            </div>
            <div style="padding-bottom: 1rem;">Configure various settings related to security.</div>
            <div style="padding-bottom: 1rem;">
                <em>The public/private user token keys are used to generate authentication tokens for the users.</em>
            </div>

            <div class="settings-table settings-table-security" style="white-space: pre-line; display: grid; grid-template-columns: auto auto; grid-gap: 2rem;">
                <div style="align-self: baseline;">
                    <label>User token - Public key:</label>
                    <div style="font-family: monospace; font-size: small;"><?php p($_['usertoken_public_key']); ?></div>
                </div>

                <div style="align-self: baseline;">
                    <label>User token - Private key:</label>
                    <div style="font-family: monospace; font-size: small;"><?php p($_['usertoken_private_key']) ?></div>
                </div>
            </div>
        </div>
    </form>

    <div id="success-message" class="success-message" style="display: none;">Settings saved!</div>
</div>
