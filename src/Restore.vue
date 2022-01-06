<template>
  <div>
    <ToolStart v-if="!fetchingAllPosts && !manglingPosts && !complete"
                 v-bind:title="i18n.restore_title"
                 v-bind:subtitle="i18n.restore_subtitle"
                 v-bind:description="i18n.restore_description"
                 v-bind:button-text="i18n.restore_button"
                 v-bind:event-name="'fetch-all-posts-to-restore'"
    />
    <ToolFetch v-if="fetchingAllPosts"
                 v-bind:description="i18n.restore_progress_description"
                 v-bind:title="i18n.restore_title"
                 v-bind:subtitle="i18n.restore_progress_title"
    />
    <ToolProcess
        v-if="manglingPosts"
        v-bind:progress="progress"
        v-bind:description="i18n.restore_progress_description"
        v-bind:title="i18n.restore_title"
        v-bind:subtitle="i18n.restore_progress_title"
        v-bind:total="total"
        v-bind:processed="processed"
    />
    <ToolResult
        v-if="complete"
        v-bind:title="i18n.restore_title"
        v-bind:subtitle="i18n.restore_success_title"
        v-bind:description="i18n.restore_progress_description"
        v-bind:button-text="i18n.restore_success_button"
        v-bind:total="total"
        v-bind:processed="processed"
    />
  </div>
</template>

<script>
import axios from 'axios';
import {sprintf} from 'sprintf-js';
import ToolStart from "./ToolStart";
import ToolProcess from "./ToolProcess";
import ToolResult from "./ToolResult";
import ToolFetch from "./ToolFetch";

export default {
  components: {ToolFetch, ToolResult, ToolProcess, ToolStart},
  data: function () {
    return {
      fetchingAllPosts: false,
      manglingPosts: false,
      posts: [],
      total: 0,
      processed: 0,
      currentIndex: 0,
      complete: false,
      i18n: window.disable_media_pages.i18n,
    }
  },
  computed: {
    progress: function () {
      return Math.round(this.processed / this.total * 100)
    }
  },
  mounted() {
    this.$root.$on('fetch-all-posts-to-restore', this.fetchAllPosts);
    this.$root.$on('start-over', this.startOver);
  },
  beforeDestroy() {
    // https://readybytes.in/blog/how-to-fix-duplicate-event-listeners-in-vuejs
    this.$root.$off('fetch-all-posts-to-restore', this.fetchAllPosts);
    this.$root.$off('start-over', this.startOver);
  },
  methods: {
    sprintf(...args) {
      return sprintf(...args)
    },
    fetchAllPosts() {
      this.fetchingAllPosts = true;
      const options = {
        headers: {
          'X-WP-Nonce': window.disable_media_pages.token,
        }
      }
      axios.get(`${window.disable_media_pages.root}disable-media-pages/v1/get-attachments-to-restore`, options).then(response => {
        console.log(response)
        this.posts = response.data.posts;
        this.total = response.data.total;

        this.fetchingAllPosts = false;
        this.manglingPosts = true;
        if (this.total > 0) {
          this.processImage(this.posts[0])
        } else {
          // Nothing to process
          this.manglingPosts = false;
          this.complete = true;
        }
      })
    },
    processImage(id) {
      const options = {
        headers: {
          'X-WP-Nonce': window.disable_media_pages.token,
        }
      }
      axios.post(`${window.disable_media_pages.root}disable-media-pages/v1/restore/${id}`, null, options).then(response => {

      }).catch(response => {
        // TODO: handle error?
      }).finally(() => {
        this.processed = this.processed + 1;
        let newIndex = this.currentIndex + 1;
        if (this.posts[newIndex]) {
          this.currentIndex = newIndex;
          this.processImage(this.posts[newIndex]);
        } else {
          this.manglingPosts = false;
          this.complete = true;
        }
      });
    },
    startOver() {
      this.complete = false;
      this.posts = [];
      this.currentIndex = 0;
      this.total = 0;
      this.processed = 0;
      this.currentIndex = 0;
    }
  }
}
</script>