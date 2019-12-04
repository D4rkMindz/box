<template>
  <div class="uk-margin">
    <span class="uk-text-meta">{{ placeholder }}</span>
    <input :class="{'uk-form-danger': valid === false,'uk-form-success': valid === true}"
           :placeholder="placeholder"
           @blur="validate()"
           class="uk-input"
           type="text"
           v-model="input">
    <span class="uk-label uk-label-danger" v-if="valid === false">Please use an alphanumeric name</span>
  </div>
</template>

<script>
  import validator from 'validator';
  import DefaultInput from "@components/Form/DefaultInput";

  export default {
    extends: DefaultInput,
    name: 'HostName',
    data() {
      return {
        placeholder: 'Display name',
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
