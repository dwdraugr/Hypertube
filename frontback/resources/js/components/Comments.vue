<template>
  <div class="comments overflow-auto">
    <div class="my-2">
      Comments
    </div>

    <b-media
      v-for="comment in comments"
      :key="comment"
      class="my-2"
    >
      <template v-slot:aside>
        <b-img
          blank
          blank-color="#C5C5C5"
          width="60px"
          style="border-radius:5px;"
        />
        <!--
          Расскоментить, когда будет гарантированно возвращаться base64
          и удалить <b-img> выше
        <b-img
          :src="comment.user.icon"
          width="60px"
          style="border-radius:5px;"
        /> -->
      </template>

      <b-row align-h="start">
        <b-col cols="auto">
          {{ [comment.user.first_name, comment.user.last_name].join(" ") }}
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
      <div v-if="!submitPressed">Submit</div>
      <div v-else>
        <div
          class="spinner-grow spinner-grow-sm"
          role="status"
        />
        Sending...
      </div>
    </b-button>
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
  data () {
    return {
      user: {},
      comments: [],
      text: '',
      submitPressed: false
    }
  },
  async mounted () {
    await axios
      .get('/me')
      .then((response) => {
        user = response
      })
      .catch(() => {})

    await axios
      .get(`/api/comments/${this.video.id}`)
      .then(response => {
        // Раскоментить, когда будет работать GET /api/comment/<video_id>/
        // и удалить блок с хард-кодными комментами в mounted ()
        // this.comments = response
      })
      .catch(() => {})
    
    this.comments = this.comments.concat([
      {
        text: 'Hello, Biba',
        user: {
          name: 'uvarly',
          first_name: 'Пипипп',
          last_name: 'Пепаноб',
          icon: ''
        }
      },
      {
        text: 'sam Biba',
        user: {
          name: 'dwdraugr',
          first_name: 'Гоздя',
          last_name: 'Бибиненков',
          icon: ''
        }
      },
      {
        text: 'Э',
        user: {
          name: 'uvarly',
          first_name: 'Пипипп',
          last_name: 'Пепаноб',
          icon: ''
        }
      }
    ])
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
          // Раскомментить, когда будет работать путь /me
          // this.comments.push({ text, user })
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
