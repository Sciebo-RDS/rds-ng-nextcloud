<script setup>
import debounce from "debounce";
import {ref, unref} from "vue";

import axios from "@nextcloud/axios";
import {loadState} from "@nextcloud/initial-state";

import {generateUrl} from "@nextcloud/router";
import NcTextField from "@nextcloud/vue/components/NcTextField";

const appUrl = ref(loadState("rdsng", "app_url"));
const domoUrl = ref(loadState("rdsng", "domo_url"));
const instanceId = ref(loadState("rdsng", "instance_id"));
const apiKey = ref(loadState("rdsng", "api_key"));

async function saveSettings(values) {
    await axios.put(
        generateUrl("/apps/rdsng/settings"),
        values
    );
}

const onSettingsChanged = debounce(async () => {
    const values = {
        appUrl: unref(appUrl),
        domoUrl: unref(domoUrl),
        instanceId: unref(instanceId),
        apiKey: unref(apiKey),
    };
    await saveSettings(values, false);
}, 500);
</script>

<template>
    <div id="rdsng-appsettings" class="section">
        <div>
            <h2>bridgit Settings</h2>
        </div>

        <div id="main-settings-section" style="padding-bottom: 1rem;">
            <div class="section-header">
                <h3>Frontend</h3>
            </div>
            <div style="padding-bottom: 1rem;">Configure the frontend settings of bridgit.</div>

            <div class="settings-table">
                <NcTextField id="app-url" v-model="appUrl" class="input" label="Frontend URL" placeholder="https://bridgit.mydomain.com" @update:model-value="onSettingsChanged"/>
                <div class="settings-table-info"><em>The URL of your bridgit Frontend.</em></div>

                <NcTextField id="instance-id" v-model="instanceId" class="input" label="Instance ID" placeholder="some-id" @update:model-value="onSettingsChanged"/>
                <div class="settings-table-info"><em>A cluster-unique identifier for this instance (used to distinguish multiple hosts using a single bridgit deployment).</em></div>
            </div>

            <div id="userid-settings-section">
                <div class="section-header">
                    <h3>Backend</h3>
                </div>
                <div style="padding-bottom: 1rem;">Configure the backend settings of bridgit.</div>

                <div class="settings-table">
                    <NcTextField id="domo-url" v-model="domoUrl" class="input" label="Domo URL" placeholder="https://domo.mydomain.com" @update:model-value="onSettingsChanged"/>
                    <div class="settings-table-info"><em>The URL of your bridgit Domo.</em></div>

                    <NcTextField id="api-key" v-model="apiKey" class="input" label="API key" placeholder="secret-key-1234" @update:model-value="onSettingsChanged"/>
                    <div class="settings-table-info"><em>The API key used to communicate directly with bridgit (must be the same as used during the deployment of bridgit).</em></div>
                </div>
            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>
.settings-table {
    display: inline-grid;
    grid-template-columns: 30rem auto;
    grid-row-gap: 1rem;
    align-self: center;
    align-items: center;
}

.settings-table-info {
    width: 500px;
    padding-left: 1rem;
}
</style>
