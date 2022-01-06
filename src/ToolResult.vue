<template>
  <div>
    <div class="disable-media-pages-tool__title-container">
      <h2 class="disable-media-pages-tool__title">{{ title }}</h2>
    </div>
    <div class="disable-media-pages-tool__card">

      <div class="disable-media-pages-tool__subtitle">{{ subtitle }}</div>

      <div class="disable-media-pages-tool__progress-title">
        {{ sprintf(description, 100) }}
      </div>

      <div class="disable-media-pages__progress-bar">
        <div class="disable-media-pages__progress-bar-inner" v-bind:style="{
          width: '100%'
        }">
        </div>
      </div>

      <div class="disable-media-pages-tool__progress-subtitle disable-media-pages-tool__progress-subtitle--has-button">
        {{ sprintf(i18n.tool_progress_subtitle, processed, total) }}
      </div>

      <p>
        <button class="button button-primary" v-on:click="startOver">{{ buttonText }}</button>
      </p>
    </div>
  </div>
</template>

<script>
import {sprintf} from 'sprintf-js';
import Mangle from "./Mangle";

export default {
  props: ['title', 'description', 'buttonText', 'subtitle', 'total', 'processed'],
  components: {Mangle},
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
    startOver() {
      this.$root.$emit('start-over');
    }
  }
}
</script>