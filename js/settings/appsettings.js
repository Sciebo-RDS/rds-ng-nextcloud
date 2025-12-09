'use strict';

const appID = "rdsng";

function saveSettings() {
    const section = $("#settings-form");
    const appURL = section.find("#app-url").val();
    const instanceID = section.find("#instance-id").val();

    OCP.AppConfig.setValue(appID, "app_url", appURL);
    OCP.AppConfig.setValue(appID, "instance_id", instanceID);

    $("#success-message").show("fast");
    setTimeout(() => {
        $("#success-message").hide("slow");
    }, 3000);
}

$(document).ready(() => {
    const section = $("#settings-form");
    section.find("#app-url").change(saveSettings);
    section.find("#instance-id").change(saveSettings);
});
