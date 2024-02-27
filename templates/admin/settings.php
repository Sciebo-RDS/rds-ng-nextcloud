<?php
//Util::addScript(Application::APP_ID, 'admin');
//Util::addStyle(Application::APP_ID, 'admin');
?>

<div id="settings" class="section">
    <h2>RDS NG Settings</h2>

    <form id="settings-form">
        <div id="main-settings-section" style="grid-row: 1;">
            <div class="section-header">
                <h3>Main</h3>
            </div>
            <div>Configure the main RDS NG settings.</div>
            <div>&nbsp;</div>

            <div class="settings-table settings-table-main">
                <label for="app-url" style="grid-row: 1;">RDS NG URL:</label>
                <input id="app-url" type="text" style="width: 400px; grid-row: 1;" placeholder="https://www.myoverleaf.com" value="<?php p($_['app_url']) ?>"/>
                <div><em>Enter the URL of your RDS NG instance.</em></div>
            </div>
        </div>

        <div style="grid-row: 3;">&nbsp;</div>
        <div style="grid-row: 4;">
            <button id="settings-save">Save settings</button>
        </div>
    </form>
</div>
