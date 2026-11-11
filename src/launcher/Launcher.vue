<script setup>
import {ref, onBeforeMount} from "vue";

import {loadState} from "@nextcloud/initial-state";

const appVersion = loadState("rdsng", "app_version");
const appSource = loadState("rdsng", "app_source");
const appOrigin = loadState("rdsng", "app_origin");

const loading = ref(true);

onBeforeMount(() => {
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
                    case "reload":
                        // window.location.reload() won't work properly in FF, but this weird trick does
                        document.getElementById("app-frame").src += "";
                        break;

                    case "redirect":
                        if (data.hasOwnProperty("data")) {
                            window.location.replace(data["data"]);
                        }
                        break;
                }
            }
        },
        false,
    );
});
</script>

<template>
    <div id="content" class="app-wrapper">
        <div id="app-loading" v-show="loading" class="app-wrapper-loading" style="color: black;">Loading application...</div>
        <iframe
            id="app-frame"
            v-show="!loading"
            class="app-frame"
            :class="{ 'app-loaded': !loading }"
            :src="appSource"
            :title="`bridgit ${appVersion}`"
            :x-origin="appOrigin"
            @load="loading = false"
        ></iframe>
    </div>
</template>

<style lang="scss" scoped>
.app-wrapper {
    display: block;
    margin: 1rem 0 0 !important;
    border: none;
    width: 100%;
}

.app-wrapper-loading {
    text-align: center;
    vertical-align: middle;
    font-size: 120%;
    font-weight: bold;
    padding: 10px;
    background: #eee;
    border: #eee solid;
    border-radius: 5px;
    width: 100%;
    opacity: 60%;
}

.app-frame {
    width: 100%;
    margin-bottom: 20px;
}

iframe.app-loaded {
    background-color: white;
}
</style>
