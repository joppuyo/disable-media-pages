<template>
  <div class="disable-media-pages-tool">
    <div class="disable-media-pages-tool__title-container">
    <h2 class="disable-media-pages-tool__title">{{ title }}</h2>
    </div>
    <p>{{ sprintf(description, 0) }}</p>
    <div class="disable-media-pages__progress-bar disable-media-pages__progress-bar--indeterminate"></div>
  </div>
</template>

<script>
import {sprintf} from 'sprintf-js';

export default {
  props: ['title', 'description'],
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
  }
}
</script>