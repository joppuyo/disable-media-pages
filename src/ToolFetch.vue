<template>
  <div>
    <div class="disable-media-pages-tool__title-container">
      <h2 class="disable-media-pages-tool__title">{{ title }}</h2>
    </div>
    <div class="disable-media-pages-tool__card">
    <div class="disable-media-pages-tool__subtitle">
      {{ subtitle }}
    </div>
    <div class="disable-media-pages-tool">

      <div class="disable-media-pages-tool__progress-title">
        {{ sprintf(description, 0) }}
      </div>

      <div class="disable-media-pages__progress-bar disable-media-pages__progress-bar--indeterminate"></div>

      <div class="disable-media-pages-tool__progress-subtitle">
        {{ sprintf(i18n.tool_progress_subtitle, 0, '-') }}
      </div>

    </div>
    </div>
  </div>
</template>

<script>
import {sprintf} from 'sprintf-js';

export default {
  props: ['title', 'description', 'subtitle'],
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