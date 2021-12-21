<template>
  <div>
    <h2 class="title">{{ title }}</h2>
    <p>{{ sprintf(i18n.mangle_progress_description, progress) }}</p>
    <div class="disable-media-pages__progress-bar">
      <div class="disable-media-pages__progress-bar-inner" v-bind:style="{
          width: `${progress}%`
        }">
      </div>
    </div>
  </div>
</template>

<script>
import {sprintf} from 'sprintf-js';

export default {
  props: ['title', 'description', 'progress'],
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