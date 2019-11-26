<template>
  <div>
    <a href="#add-host" uk-toggle>
      <div class="uk-card uk-card-default uk-card-body uk-text-center">
        <div class="uk-position-center">
          <p>Add another</p>
          <span uk-icon="icon: plus-circle; ratio: 2"></span>
        </div>
      </div>
    </a>
    <div id="add-host" uk-modal>
      <div class="uk-modal-dialog">
        <button class="uk-modal-close-default" type="button" uk-close/>
        <div class="uk-modal-header">
          <h2 class="uk-modal-title">Add Host</h2>
        </div>
        <div class="uk-modal-body">
          <p>Please select one from the list below</p>
          <configure-host :templates="templates" @close="open()"/>
        </div>
        <div class="uk-modal-footer uk-text-right">
          <button class="uk-button uk-button-default uk-modal-close" type="button">Cancel</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import UIkit from 'uikit';
  import ConfigureHost from "@components/ConfigureHost";

  export default {
    name: 'ObjectSelector',
    props: {
      objects: {
        type: String,
        required: true,
      }
    },
    computed: {
      templates() {
        return JSON.parse(this.objects);
      }
    },
    components: {
      ConfigureHost,
    },
    methods: {
      open() {
        UIkit.modal('#add-host').show();
      },
    },
  };
</script>
