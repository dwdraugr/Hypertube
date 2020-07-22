<template>
  <div class="comments overflow-auto">
    <div class="comment-header">
      Comments
    </div>

    <b-media
      v-for="comment in comments"
      :key="comment"
      class="my-4"
    >
      {{ comment }}
    </b-media>
  </div>
</template>

<script>
export default {
  props: {
    video: {
      type: Object,
      default: () => {
        return {}
      }
    }
  },
  async mounted () {
    await axios
      .get(`/api/comments/${this.video.id}`)
      .then(response => {})
      .catch(() => {
        // this.comments = []
      })
  },
  data () {
    return {
      comments: []
    }
  }
}
</script>

<style scoped>
.comments {
  height: 220px;
  border: 0;
}
</style>
