<template>
  <div class="wrap disable-media-pages">
    <h1>{{ i18n.plugin_title }}</h1>

    <div class="card" v-if="!fetchingAllPosts && !manglingPosts && !complete">
      <h2 class="title">{{ i18n.mangle_title }}</h2>
      <p>
        {{ i18n.mangle_description }}
      </p>
      <p>
      <button class="button button-primary" v-on:click="fetchAllPosts">{{ i18n.mangle_button }}</button>
      </p>
    </div>

    <div class="card" v-if="fetchingAllPosts">
      <h2 class="title">{{ i18n.mangle_progress_title }}</h2>

      <p>{{ sprintf(i18n.mangle_progress_description, 0) }}</p>


      <div class="disable-media-pages__progress-bar disable-media-pages__progress-bar--indeterminate"></div>

    </div>

    <div class="card" v-if="manglingPosts">
      <h2 class="title">{{ i18n.mangle_progress_title }}</h2>

      <p>{{ sprintf(i18n.mangle_progress_description, progress) }}</p>

      <div class="disable-media-pages__progress-bar">
        <div class="disable-media-pages__progress-bar-inner" v-bind:style="{
          width: `${progress}%`
        }">
        </div>
      </div>

    </div>

    <div class="card" v-if="complete">
      <h2 class="title">{{ i18n.mangle_success_title }}</h2>

      <p>{{ sprintf(i18n.mangle_progress_description, 100) }}</p>


      <div class="disable-media-pages__progress-bar">
        <div class="disable-media-pages__progress-bar-inner" v-bind:style="{
          width: '100%'
        }">
        </div>
      </div>

      <p>
        <button class="button button-primary" v-on:click="complete = false">{{ i18n.mangle_success_button }}</button>
      </p>

    </div>

  </div>
</template>

<script>
import axios from 'axios';
import { sprintf } from 'sprintf-js';
export default {
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
    progress: function() {
      return Math.round(this.processed / this.total * 100)
    }
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
      axios.get(`${window.disable_media_pages.root}disable-media-pages/v1/get_all_attachments`, options).then(response => {
        console.log(response)
        this.posts = response.data.posts;
        this.total = response.data.total;

        this.fetchingAllPosts = false;
        this.manglingPosts = true;
        this.processImage(this.posts[0])
      })
    },
    processImage(id) {
      const options = {
        headers: {
          'X-WP-Nonce': window.disable_media_pages.token,
        }
      }
      axios.post(`${window.disable_media_pages.root}disable-media-pages/v1/process/${id}`, null, options).then(response => {

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
          this.posts = [];
          this.currentIndex = 0;
          this.total = 0;
          this.processed = 0;
          this.currentIndex = 0;
        }
      });
    }
  }
}
</script>