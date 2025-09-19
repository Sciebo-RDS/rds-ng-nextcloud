'use strict';

const appID = "rdsng";

function saveSettings() {
    const section = $("#settings-form");
    const appURL = section.find("#app-url").val();
    const instanceID = section.find("#instance-id").val();
    const userIdSuffix = section.find("#userid-suffix").val();
    const userIdSuffixEnforce = section.find("#userid-suffix-enforce").is(":checked");

    OCP.AppConfig.setValue(appID, "app_url", appURL);
    OCP.AppConfig.setValue(appID, "instance_id", instanceID);
    OCP.AppConfig.setValue(appID, "userid_suffix", userIdSuffix);
    OCP.AppConfig.setValue(appID, "userid_suffix_enforce", userIdSuffixEnforce);

    $("#success-message").show("fast");
    setTimeout(() => {
        $("#success-message").hide("slow");
    }, 3000);
}

$(document).ready(() => {
    const section = $("#settings-form");
    section.find("#app-url").change(saveSettings);
    section.find("#instance-id").change(saveSettings);
    section.find("#userid-suffix").change(saveSettings);
    section.find("#userid-suffix-enforce").change(saveSettings);
});
