<template>
  <div class="uk-margin">
    <span class="uk-text-meta">{{ placeholder }}</span>
    <input :class="{'uk-form-danger': valid === false,'uk-form-success': valid === true}"
           :max="max"
           :min="min"
           @blur="validate()"
           class="uk-range"
           step="1"
           type="range"
           v-model="input">
    {{ value }} Min
    <span class="uk-label uk-label-danger" v-if="valid === false">Please dont manipulate the range slider</span>
  </div>
</template>

<script>
  import validator from 'validator';
  import DefaultInput from "@components/Form/DefaultInput";

  export default {
    extends: DefaultInput,
    name: 'Alias',
    props: {
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
      };
    },
    methods: {
      validate() {
        const valid = validator.isInt(this.input, {min: this.min, max: this.max});
        this.emit(valid);
      }
    }
  };
</script>

<style scoped>

</style>
