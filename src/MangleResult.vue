<template>
  <div>
    <h2 class="title">{{ title }}</h2>

    <p>{{ sprintf(description, 100) }}</p>


    <div class="disable-media-pages__progress-bar">
      <div class="disable-media-pages__progress-bar-inner" v-bind:style="{
          width: '100%'
        }">
      </div>
    </div>

    <p>
      <button class="button button-primary" v-on:click="startOver">{{ buttonText }}</button>
    </p>
  </div>
</template>

<script>
import {sprintf} from 'sprintf-js';
import Mangle from "./Mangle";

export default {
  props: ['title', 'description', 'buttonText'],
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