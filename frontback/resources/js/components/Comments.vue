<template>
  <div class="comments overflow-auto">
    <div class="my-2">
      {{ titleText }}
    </div>

    <b-media
      v-for="comment in comments"
      :key="comment"
      class="my-2"
    >
      <template v-slot:aside>
        <b-img
          :src="comment.user.icon"
          width="60px"
          style="border-radius:5px;"
        />
      </template>

      <b-row align-h="start">
        <b-col cols="auto">
          {{ comment.user.name }}
        </b-col>
      </b-row>

      <b-row class="m-auto">
        <span class="text-justify">
          {{ comment.text }}
        </span>
      </b-row>
    </b-media>

    <b-input
      v-model="text"
      class="my-2"
    />

    <b-button
      class="my-2"
      variant="outline-secondary"
      @click="onCommentPost"
    >
      <div v-if="!submitPressed">{{ submitText }}</div>
      <div v-else>
        <div
          class="spinner-grow spinner-grow-sm"
          role="status"
        />
        {{ sendingText }}
      </div>
    </b-button>
  </div>
</template>

<script>
export default {
  props: {
    user: {
      type: Object,
      default: () => {
        return {
          name: 'Anonymous',
          locale: 'en'
        }
      }
    },
    video: {
      type: Object,
      default: () => {
        return {}
      }
    }
  },
  data () {
    return {
      comments: [],
      text: '',
      submitPressed: false
    }
  },
  computed: {
    titleText () { return this.user.locale ==='en' ? 'Comments' : 'Комментарии' },
    submitText () { return this.user.locale ==='en' ? 'Submit' : 'Отправить' },
    sendingText () { return this.user.locale ==='en' ? 'Sending...' : 'Отправка...' }
  },
  async mounted () {
    await axios
      .get(`/api/comments/${this.video.id}`)
      .then(response => {
        /**
         * 
         * 
         * 
         * 
         * 
         * 
         * 
         * 
         * 
         * 
         * 
         * 
         * У меня не работает подгруз очка видосов
         * Положи сюда тот респонс, который возвращает апишка комментов
         * 
         * 
         * 
         */
        this.comments = response
        /**
         * 
         * 
         * 
         * 
         * 
         * 
         * 
         * 
         * 
         * 
         * 
         * 
         * 
         * 
         * 
         * 
         * 
         */
      })
      .catch(() => {})
  },
  methods: {
    async onCommentPost () {
      this.submitPressed = true
      await axios
        .post('/api/comment/', {
          video_id: this.video.id,
          text: this.text
        })
        .then(() => {
          this.comments.push({
            text: this.text,
            user: this.user
          })
        })
        .catch(() => {})
        .finally(() => { this.submitPressed = false })
    }
  }
}
</script>

<style scoped>
.comments {
  min-height: 220px;
  border: 0;
}
</style>
