<template>
  <div class="wrap disable-media-pages">
    <h1>Disable Media Pages</h1>

    <div class="card" v-if="!fetchingAllPosts && !manglingPosts">
      <h2 class="title">Mangle existing media slugs</h2>
      <p>
        This tools will let you change all existing post slugs to unique ids so they won't conflict with your page titles
      </p>
      <p>
      <button class="button button-primary">Start mangling process</button>
      </p>
    </div>

    <div class="card" v-if="fetchingAllPosts">
      <h2 class="title">Mangling existing media slugs...</h2>

      <p>Progress 0%</p>


      <div class="disable-media-pages__progress-bar"></div>

    </div>

  </div>
</template>

<script>
export default {
  data: function () {
    return {
      fetchingAllPosts: true,
      manglingPosts: false,
    }
  }
}
</script>