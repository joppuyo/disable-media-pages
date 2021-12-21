<template>
  <div class="disable-media-pages">
    <div class="disable-media-pages-toolbar">
      <div class="disable-media-pages-toolbar__plugin-title">
        <h1>{{ i18n.plugin_title }}</h1>
      </div>
      <div class="disable-media-pages-toolbar__tabs">
        <button class="disable-media-pages-toolbar__tabs-tab"
                v-on:click="currentTab = 'mangle'"
                v-bind:class="{'disable-media-pages-toolbar__tabs-tab--active': currentTab === 'mangle'}"
        >
          {{ i18n.tab_mangle }}
        </button>
        <button class="disable-media-pages-toolbar__tabs-tab"
                v-on:click="currentTab = 'restore'"
                v-bind:class="{'disable-media-pages-toolbar__tabs-tab--active': currentTab === 'restore'}"
        >
          {{ i18n.tab_restore }}
        </button>
        <button class="disable-media-pages-toolbar__tabs-tab">
          {{ i18n.tab_options }}
        </button>
      </div>
    </div>
    <Mangle v-if="currentTab === 'mangle'" />
    <Restore v-if="currentTab === 'restore'" />
  </div>
</template>

<script>
import { sprintf } from 'sprintf-js';
import Mangle from "./Mangle";
import Restore from "./Restore";
export default {
  components: {Restore, Mangle},
  data: function () {
    return {
      i18n: window.disable_media_pages.i18n,
      currentTab: 'mangle',
    }
  },
  computed: {
  },
  methods: {
    sprintf(...args) {
      return sprintf(...args)
    },
  }
}
</script>