<template>
  <div class="uk-margin">
    <span class="uk-text-meta">{{ placeholder }}</span>
    <input :class="{'uk-form-danger': valid === false,'uk-form-success': valid === true}"
           :placeholder="placeholder"
           @blur="validate()"
           class="uk-input"
           type="text"
           v-model="input">
    <span class="uk-label uk-label-danger" v-if="valid === false">Please use valid user domain (eg. WORKGROUP)</span>
  </div>
</template>

<script>
  import validator from 'validator';
  import DefaultInput from "@components/Form/DefaultInput";

  export default {
    name: 'SmbUserDomain',
    extends: DefaultInput,
    data() {
      return {
        placeholder: 'SMB User Domain',
      };
    },
    methods: {
      validate() {
        const valid = validator.isAlphanumeric(this.input);
        this.emit(valid);
      }
    }
  };
</script>

<style scoped>

</style>
