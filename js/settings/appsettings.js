const appID = "rdsng";

function saveSettings() {
    const section = $("#settings-form");
    const appURL = section.find("#app-url").val();

    OCP.AppConfig.setValue(appID, "app_url", appURL);

    $("#success-message").show("fast");
    setTimeout(() => {
        $("#success-message").hide("slow");
    }, 3000);
}

$(document).ready(() => {
    const section = $("#settings-form");
    section.find("#app-url").change(saveSettings);
});
