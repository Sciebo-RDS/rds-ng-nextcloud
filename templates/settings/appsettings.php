<?php

use OCP\Util;

use OCA\RdsNg\AppInfo\Application;

Util::addScript(Application::APP_ID, "settings/appsettings");

Util::addStyle(Application::APP_ID, "main");
Util::addStyle(Application::APP_ID, "settings/appsettings");

?>

<div id="settings" class="section">
    <h2>RDS NG Settings</h2>

    <form id="settings-form" style="padding-bottom: 1rem; width: 600px;">
        <div id="main-settings-section" style="padding-bottom: 1rem;">
            <div class="section-header">
                <h3>Main</h3>
            </div>
            <div style="padding-bottom: 1rem;">Configure the main RDS NG settings.</div>

            <div class="settings-table settings-table-main">
                <label for="app-url">RDS NG URL:</label>
                <input id="app-url" type="text" style="width: 400px;" placeholder="https://www.mydomain.com" value="<?php p($_['app_url']) ?>"/>
                <div class="settings-table-info"><em>The URL of your RDS NG instance.</em></div>
            </div>
        </div>

        <div id="userid-settings-section">
            <div class="section-header">
                <h3>User IDs</h3>
            </div>
            <div style="padding-bottom: 1rem;">Configure how the user IDs for RDS NG are generated.</div>
            <div style="padding-bottom: 1rem;">
                <em>By default, a suffix (if specified) is only appended to a Nextcloud ID if it is not an email address. This behavior can be changed by enforcing the suffix.</em>
            </div>

            <div class="settings-table settings-table-userid">
                <label for="userid-suffix">Suffix:</label>
                <input id="userid-suffix" type="text" style="width: 400px;" placeholder="mydomain.com" value="<?php p($_['userid_suffix']) ?>"/>
                <div class="settings-table-info"><em>The user IDs will be generated in the form of <i>nextcloud-id@suffix</i>. It should thus be in the form of <i>host.tld</i>, like <i>mydomain.com</i>.</em></div>

                <div style="padding-top: 3.0rem;">&nbsp;</div>
                <div>
                    <input id="userid-suffix-enforce" type="checkbox" class="checkbox" <?php p($_['userid_suffix_enforce'] ? 'checked' : ''); ?>/>
                    <label for="userid-suffix-enforce">Enforce suffix</label>
                </div>
                <div class="settings-table-info"><em>If enabled, user IDs which already are an email address will nonetheless use the specified suffix.</em></div>
            </div>
        </div>

        <div id="security-settings-section">
            <div class="section-header">
                <h3>Security</h3>
            </div>
            <div style="padding-bottom: 1rem;">Configure various settings related to security.</div>
            <div style="padding-bottom: 1rem;">
                <em>The public/private user token keys are used to generate authentication tokens for the users. A new key pair can be created using the <b>rdsng:create-user-token-keys</b> command.</em>
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
