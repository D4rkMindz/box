<template>
  <div class="uk-margin">
    <span class="uk-text-meta">{{ placeholder }}</span>
    <input :class="{'uk-form-danger': valid === false,'uk-form-success': valid === true}"
           :placeholder="placeholder"
           @blur="validate()"
           class="uk-input"
           type="text"
           v-model="value">
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
      valid: {
        type: Boolean,
        required: false,
        default: null,
      },
    },
    data() {
      return {
        placeholder: 'SMB Share Name',
      };
    },
    methods: {
      validate() {
        // from https://stackoverflow.com/questions/29106365/strict-regular-expression-for-shared-network-folder
        const valid = validator.matches(this.value, /^(\\)(\\[A-Za-z0-9-_]+){2,}(\\?)$/);
        this.$emit('validated', valid);
        this.$emit('input', this.value);
      }
    }
  };
</script>

<style scoped>

</style>
