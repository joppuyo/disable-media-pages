<template>
  <div>
    <div class="disable-media-pages-tool__title-container">
      <h2 class="disable-media-pages-tool__title">{{ title }}</h2>
    </div>
    <div class="disable-media-pages-tool__card">
      <div class="disable-media-pages-tool__subtitle">
        {{subtitle}}
      </div>
      <div class="disable-media-pages-tool__description">
        <p>
          {{ description }}
        </p>
      </div>
      <p>
        <button class="button button-primary" v-on:click="sendEvent">{{ buttonText }}</button>
      </p>
    </div>
  </div>
</template>

<script>
import {sprintf} from 'sprintf-js';

export default {
  props: ['title', 'description', 'button-text', 'event-name', 'subtitle'],
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