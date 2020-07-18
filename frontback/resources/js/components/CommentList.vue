<template>
  <div>
    <div
      v-for="comment in comments"
      :key="comment"
    >
      {{ comment }}
    </div>
  </div>
</template>

<script>
// Идея такая:
//   * Передаешь в компонент объект видосика (:video="video")
//   * И он запросит комменты при своей сборке
export default {
  props: {
    video: {
      type: Object,
      default: () => {
        return {};
      }
    }
  },
  async fetch() {
    await axios
      .get(`/api/comments/${this.video.id}`, {
        params: {
          video: this.video.id
        }
      })
      .then(response => {})
      .catch(() => {
        this.comments = ["Комментов не будет. Контроллер принял ислам"]
      })
  },
  data() {
    return {
      comments: []
    };
  }
};
</script>
