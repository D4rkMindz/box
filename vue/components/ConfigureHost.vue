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
        <button class="uk-modal-close-default" type="button" uk-close/>
        <div class="uk-modal-header">
          <h2 class="uk-modal-title">Create {{selectedTemplate.name}}</h2>
        </div>
        <div class="uk-modal-body">
          <p>{{ selectedTemplate.description }}</p>
        </div>
        <div class="uk-modal-footer uk-text-right">
          <button class="uk-button uk-button-default uk-modal-close" type="button">Cancel</button>
          <button class="uk-button uk-button-primary" type="button">Save</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name: 'ConfigureHost',
    props: {
      templates: {
        type: Object,
        required: true,
      }
    },
    data() {
      return {
        selectedTemplate: null,
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
