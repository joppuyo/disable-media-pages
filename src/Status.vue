<template>
  <div>
  <div class="disable-media-pages-tool__title-container">
    <h2 class="disable-media-pages-tool__title">{{ i18n.status_title }}</h2>
  </div>
  <div class="disable-media-pages-tool__card">
    <div class="disable-media-pages-health" v-if="loading">
      <div class="disable-media-pages-health__icon"
           v-html="require('!raw-loader!./icons/icon-loading.svg')"
      >

      </div>
      <div>
        <div class="disable-media-pages-health__title">
          {{ i18n.status_loading_title }}
        </div>
        <div class="disable-media-pages-health__description">
          {{ i18n.status_loading_description }}
        </div>
      </div>
    </div>
    <div class="disable-media-pages-health" v-if="!loading && this.nonUniqueCount === 0">
      <div class="disable-media-pages-health__icon" v-html="require('!raw-loader!./icons/icon-ok.svg')"></div>
      <div>
        <div class="disable-media-pages-health__title">
          {{ i18n.status_no_issues_title }}
        </div>
        <div class="disable-media-pages-health__description">
          {{ i18n.status_no_issues_description }}
        </div>
      </div>
    </div>
    <div class="disable-media-pages-health" v-if="!loading && this.nonUniqueCount > 0">
      <div class="disable-media-pages-health__icon" v-html="require('!raw-loader!./icons/icon-warning.svg')"></div>
      <div>
        <div class="disable-media-pages-health__title">
          <div>{{ i18n.status_some_issues_title }}</div>
        </div>
        <div class="disable-media-pages-health__description disable-media-pages-health__description--has-button">
          <p><span v-if="nonUniqueCount === 1">{{sprintf(i18n.status_non_unique_count_singular, nonUniqueCount)}}</span>
            <span v-else>{{sprintf(i18n.status_non_unique_count_plural, nonUniqueCount)}}</span>
            <span>{{i18n.status_non_unique_description}}</span></p>
        </div>
        <div class="disable-media-pages-health__button">
          <button class="button button-primary" v-on:click="goToMangle">{{i18n.status_open_tool_button}}</button>
        </div>
      </div>
    </div>
  </div>
  </div>
</template>

<script>
import axios from 'axios';
import {sprintf} from 'sprintf-js';

export default {
  components: {},
  data: function () {
    return {
      nonUniqueCount: null,
      loading: false,
      error: false,
      i18n: window.disable_media_pages.i18n,
    }
  },
  computed: {
  },
  mounted() {
    this.fetchStatus();
  },
  beforeDestroy() {
  },
  methods: {
    sprintf(...args) {
      return sprintf(...args)
    },
    fetchStatus() {
      const options = {
        headers: {
          'X-WP-Nonce': window.disable_media_pages.token,
        }
      }
      this.loading = true;
      axios.get(`${window.disable_media_pages.root}disable-media-pages/v1/get_status`, options).then(response => {
        console.log(response)
        this.loading = false;
        this.nonUniqueCount = response.data.non_unique_count;
      })
    },
    goToMangle() {
      this.$root.$emit('go-to-mangle');
    }
  }
}
</script>