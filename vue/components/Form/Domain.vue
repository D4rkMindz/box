<template>
  <div class="uk-margin">
    <span class="uk-text-meta">{{ placeholder }}</span>
    <input class="uk-input"
           :class="{'uk-form-danger': valid === false,'uk-form-success': valid === true}"
           type="text"
           :placeholder="placeholder"
           v-model="value"
           @blur="validate()">
    <span class="uk-label uk-label-danger" v-if="valid === false">Please use a valid Website address</span>
  </div>
</template>

<script>
  import validator from 'validator';

  export default {
    name: 'Domain',
    props: {
      value: {
        type: String,
        required: true,
      },
    },
    data() {
      return {
        placeholder: 'Website Domain',
        valid: null,
      };
    },
    methods: {
      validate() {
        this.valid = validator.isURL(this.value);
        this.$emit('validated', this.valid);
      }
    }
  };
</script>

<style scoped>

</style>
