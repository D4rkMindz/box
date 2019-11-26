<template>
  <div class="uk-margin">
    <span class="uk-text-meta">{{ placeholder }}</span>
    <input class="uk-range"
           :class="{'uk-form-danger': valid === false,'uk-form-success': valid === true}"
           type="range"
           step="1"
           :min="min"
           :max="max"
           v-model="value"
           @blur="validate()">
    {{ value }} Min
    <span class="uk-label uk-label-danger" v-if="valid === false">Please dont manipulate the range slider</span>
  </div>
</template>

<script>
  import validator from 'validator';

  export default {
    name: 'Alias',
    props: {
      value: {
        type: String,
        required: false,
      },
      min: {
        type: Number,
        default: 1,
      },
      max: {
        type: Number,
        default: 10,
      },
    },
    data() {
      return {
        placeholder: 'Check interval',
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
