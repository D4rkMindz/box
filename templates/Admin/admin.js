import Vue from 'vue';
import ObjectSelector from '@components/ObjectSelector';

(() => {
  document.addEventListener('DOMContentLoaded', () => {
    new Vue({
      el: '#object-selector',
      components: {
        ObjectSelector,
      }
    });
  });
})();
