<template>
  <div class="uk-margin">
    <span class="uk-text-meta">{{ placeholder }}</span>
    <input :class="{'uk-form-danger': valid === false,'uk-form-success': valid === true}"
           :placeholder="placeholder"
           @blur="validate()"
           class="uk-input"
           type="text"
           v-model="value">
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
      valid: {
        type: Boolean,
        required: false,
        default: null,
      },
    },
    data() {
      return {
        placeholder: 'SMB username',
      };
    },
    methods: {
      validate() {
        const valid = validator.matches(this.value, /^(?!.*\.\.)(?!.*\.$)[^\W][\w.]{0,29}$/);
        this.$emit('validated', valid);
        this.$emit('input', this.value);
      }
    }
  };
</script>

<style scoped>

</style>
