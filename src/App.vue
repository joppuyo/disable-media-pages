<template>
  <div class="disable-media-pages">
    <div class="disable-media-pages-toolbar">
      <div class="disable-media-pages-toolbar__plugin-title">
        <h1>{{ i18n.plugin_title }}</h1>
      </div>
      <div class="disable-media-pages-toolbar__tabs">
        <button class="disable-media-pages-toolbar__tabs-tab"
                v-on:click="currentTab = 'status'"
                v-bind:class="{'disable-media-pages-toolbar__tabs-tab--active': currentTab === 'status'}"
        >
          {{ i18n.tab_status }}
        </button>
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
      </div>
    </div>
    <div class="disable-media-pages-content">
      <Status v-if="currentTab === 'status'" />
      <Mangle v-if="currentTab === 'mangle'" />
      <Restore v-if="currentTab === 'restore'" />
    </div>
  </div>
</template>

<script>
import { sprintf } from 'sprintf-js';
import Mangle from "./Mangle";
import Restore from "./Restore";
import Status from "./Status";
export default {
  components: {Restore, Mangle, Status},
  data: function () {
    return {
      i18n: window.disable_media_pages.i18n,
      currentTab: 'status',
    }
  },
  computed: {
  },
  methods: {
    sprintf(...args) {
      return sprintf(...args)
    },
    goToMangle() {
      this.currentTab = 'mangle';
    }
  },
  mounted() {
    this.$root.$on('go-to-mangle', this.goToMangle);
  },
  beforeDestroy() {
    // https://readybytes.in/blog/how-to-fix-duplicate-event-listeners-in-vuejs
    this.$root.$off('go-to-mangle', this.goToMangle);
  },
}
</script>