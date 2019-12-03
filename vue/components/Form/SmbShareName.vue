<template>
  <div class="uk-margin">
    <span class="uk-text-meta">{{ placeholder }}</span>
    <input class="uk-input"
           :class="{'uk-form-danger': valid === false,'uk-form-success': valid === true}"
           type="text"
           :placeholder="placeholder"
           v-model="value"
           @blur="validate()">
    <span class="uk-label uk-label-danger" v-if="valid === false">Please use valid share name</span>
  </div>
</template>

<script>
  import validator from 'validator';

  export default {
    name: 'SmbShareName',
    props: {
      value: {
        type: String,
        required: true,
        default: '',
      },
    },
    data() {
      return {
        placeholder: 'SMB Share Name',
        valid: null,
      };
    },
    methods: {
      validate() {
        // from https://stackoverflow.com/questions/29106365/strict-regular-expression-for-shared-network-folder
        this.valid = validator.matches(this.value, /^(\\)(\\[A-Za-z0-9-_]+){2,}(\\?)$/);
        this.$emit('validated', this.valid);
      }
    }
  };
</script>

<style scoped>

</style>
