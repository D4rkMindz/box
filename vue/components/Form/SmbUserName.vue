<template>
  <div class="uk-margin">
    <span class="uk-text-meta">{{ placeholder }}</span>
    <input class="uk-input"
           :class="{'uk-form-danger': valid === false,'uk-form-success': valid === true}"
           type="text"
           :placeholder="placeholder"
           v-model="value"
           @blur="validate()">
    <span class="uk-label uk-label-danger" v-if="valid === false">Please use a valid username</span>
  </div>
</template>

<script>
  import validator from 'validator';

  export default {
    name: 'SmbUserName',
    props: {
      value: {
        type: String,
        required: true,
        default: '',
      },
    },
    data() {
      return {
        placeholder: 'SMB username',
        valid: null,
      };
    },
    methods: {
      validate() {
        this.valid = validator.matches(this.value, /^(?!.*\.\.)(?!.*\.$)[^\W][\w.]{0,29}$/);
        this.$emit('validated', this.valid);
      }
    }
  };
</script>

<style scoped>

</style>
