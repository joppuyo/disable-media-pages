<template>
  <div>
    <h2 class="title">{{ title }}</h2>
    <p>
      {{ description }}
    </p>
    <p>
      <button class="button button-primary" v-on:click="sendEvent">{{ buttonText }}</button>
    </p>
  </div>
</template>

<script>
import {sprintf} from 'sprintf-js';

export default {
  props: ['title', 'description', 'button-text', 'event-name'],
  data: function () {
    return {
      i18n: window.disable_media_pages.i18n,
    }
  },
  computed: {},
  methods: {
    sprintf(...args) {
      return sprintf(...args)
    },
    sendEvent() {
      this.$root.$emit(this.eventName);
    }
  },
}
</script>