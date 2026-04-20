'use strict';

const appID = "rdsng";

function saveSettings() {
    const section = $("#settings-form");
    const appURL = section.find("#app-url").val();
    const instanceID = section.find("#instance-id").val();
    const domoURL = section.find("#domo-url").val();
    const apiKey = section.find("#api-key").val();

    OCP.AppConfig.setValue(appID, "app_url", appURL);
    OCP.AppConfig.setValue(appID, "instance_id", instanceID);
    OCP.AppConfig.setValue(appID, "domo_url", domoURL);
    OCP.AppConfig.setValue(appID, "api_key", apiKey);

    $("#success-message").show("fast");
    setTimeout(() => {
        $("#success-message").hide("slow");
    }, 3000);
}

$(document).ready(() => {
    const section = $("#settings-form");
    section.find("#app-url").change(saveSettings);
    section.find("#instance-id").change(saveSettings);
    section.find("#domo-url").change(saveSettings);
    section.find("#api-key").change(saveSettings);
});
