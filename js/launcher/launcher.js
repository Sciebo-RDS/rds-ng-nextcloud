'use strict';

$(document).ready(() => {
    $("#app-frame").on("load", () => {
        $("#app-loading").hide();
        $("#app-frame").show();
        $('#app-frame').css('background-color', '#fff');
    });

    // The integrated app occasionally communicates with the host through messages
    window.addEventListener(
        "message",
        (event) => {
            // Make sure that the message came from the embedded app
            if (event.source.parent !== window) {
                return;
            }

            // Commands come in the form { action: '...', data: <any> }
            const data = event.data;
            if (data.hasOwnProperty("action")) {
                switch (event.data["action"]) {
                    case "redirect":
                        if (data.hasOwnProperty("data")) {
                            window.location.replace(data["data"]);
                        }
                }
            }
        },
        false,
    );
});
