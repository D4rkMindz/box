<template>
  <div class="uk-margin">
    <span class="uk-text-meta">{{ placeholder }}</span>
    <input class="uk-range"
           :class="{'uk-form-danger': valid === false,'uk-form-success': valid === true}"
           type="range"
           step="5"
           :min="min"
           :max="max"
           v-model="value"
           @blur="validate()">
    {{ value }} %
    <span class="uk-label uk-label-danger" v-if="valid === false">Please dont manipulate the range slider</span>
  </div>
</template>

<script>
  import validator from 'validator';

  export default {
    name: 'SmbWarningPercent',
    props: {
      value: {
        type: String,
        required: false,
        default: 85,
      },
      min: {
        type: Number,
        default: 0,
      },
      max: {
        type: Number,
        default: 100,
      },
    },
    data() {
      return {
        placeholder: 'SMB Warning Percentage',
        valid: null,
      };
    },
    methods: {
      validate() {
        this.valid = validator.isInt(this.value, {min: this.min, max: this.max});
        this.$emit('validated', this.valid);
      }
    }
  };
</script>

<style scoped>

</style>
