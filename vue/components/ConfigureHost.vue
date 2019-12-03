<template>
  <div>
    <a href="#configure-host"
       v-for="(template, templateClass) in templates" :key="templateClass"
       @click="selectedTemplate = template"
       uk-toggle>
      <dl class="uk-description-list uk-description-list-divider dl">
        <dt>{{ template.name }}</dt>
        <dd>{{ template.description }}</dd>
      </dl>
    </a>
    <div id="configure-host" uk-modal v-if="selectedTemplate">
      <div class="uk-modal-dialog">
        <button class="uk-modal-close-default" type="button" @click="close()"/>
        <div class="uk-modal-header">
          <h2 class="uk-modal-title">Create {{ selectedTemplate.name }}</h2>
        </div>
        <div class="uk-modal-body">
          <p>{{ selectedTemplate.description }}</p>
          <div v-for="(field, key) in selectedTemplate.fields" :key="key">
              <component :is="field.type" :value="field.value" @validated="field.valid = $event" />
          </div>
        </div>
        <div class="uk-modal-footer uk-text-right">
          <button class="uk-button uk-button-default" @click="close()" type="button">Cancel</button>
          <button class="uk-button uk-button-primary" type="button">Save</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import UIkit from "uikit";
  import HostName from "@components/Form/HostName";
  import CheckInterval from "@components/Form/CheckInterval";
  import Address from "@components/Form/Address";
  import Alias from "@components/Form/Alias";
  import SmbCriticalPercent from "@components/Form/SmbCriticalPercent";
  import SmbPassword from "@components/Form/SmbPassword";
  import SmbShareName from "@components/Form/SmbShareName";
  import SmbUserDomain from "@components/Form/SmbUserDomain";
  import SmbUserName from "@components/Form/SmbUserName";
  import SmbWarningPercent from "@components/Form/SmbWarningPercent";
  import SnmpCommunity from "@components/Form/SnmpCommunity";
  import Domain from "@components/Form/Domain";

  export default {
    name: 'ConfigureHost',
    props: {
      templates: {
        type: Object,
        required: true,
      }
    },
    components: {
      Address,
      Alias,
      CheckInterval,
      Domain,
      HostName,
      SmbCriticalPercent,
      SmbPassword,
      SmbShareName,
      SmbUserDomain,
      SmbUserName,
      SmbWarningPercent,
      SnmpCommunity,
    },
    data() {
      return {
        selectedTemplate: null,
        value: '',
        valid: false,
      }
    },
    methods: {
      close() {
        this.$emit('close');
        UIkit.modal('#add-host').hide();
      }
    },
  }
</script>

<style lang="scss" scoped>
  a:hover {
    text-decoration: none !important;
  }

  .dl {
    padding: 15px;
    color: #333333;

    &:hover {
      background-color: darken(#fff, 15%);
    }
  }
</style>
