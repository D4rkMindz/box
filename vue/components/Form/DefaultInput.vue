<script>
  export default {
    name: 'DefaultInput',
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
        input: null,
      };
    },
    mounted() {
      this.input = this.value;
    },
    methods: {
      emit(valid) {
        this.$emit('validated', valid);
        this.$emit('input', this.input);
      }
    },
    watch: {
      value() {
        this.input = this.value;
      },
    },
  }
</script>
