<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="input-group mb-3">
          <input
            v-model="search_query"
            type="text"
            class="form-control"
            :placeholder="placeholderText"
            aria-label="Recipient's username"
            aria-describedby="button-addon2"
          />
          <div class="input-group-append">
            <button
              v-on:click="getVideos()"
              class="btn btn-outline-secondary"
              type="button"
              id="button-addon2"
            >
              <div v-if="!searchPressed">{{ searchText }}</div>
              <div
                v-if="searchPressed"
                class="spinner-grow spinner-grow-sm"
                role="status"
              >
                <span class="sr-only">{{ loadingText }}</span>
              </div>
            </button>
          </div>
        </div>
        <div v-for="video in videos" :key="video.id" class="card">
          <div class="card-header">{{ video.title }}</div>
          <div class="card-body">
            <b-img
              :src="video.medium_cover_image"
              class="float-left mt-2 mr-2"
            />
            <div><b>Description:</b> {{ video.description_full }}</div>
            <div><b>Date:</b> {{ video.year }}</div>
            <div><b>Rating:</b> {{ video.rating }}</div>
            <b-button
              class="mt-2 p-2"
              variant="outline-secondary"
              :href="`https://www.imdb.com/title/${video.imdb_code}`"
              target="_blank"
            >
              IMDB
            </b-button>
            <hr />
            <button
              type="button"
              class="btn btn-outline-secondary"
              v-b-modal="`modal-video-${video.id}`"
            >
              <svg
                width="1em"
                height="1em"
                viewBox="0 0 16 16"
                class="bi bi-play"
                fill="currentColor"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  fill-rule="evenodd"
                  d="M10.804 8L5 4.633v6.734L10.804 8zm.792-.696a.802.802 0 0 1 0 1.392l-6.363 3.692C4.713 12.69 4 12.345 4 11.692V4.308c0-.653.713-.998 1.233-.696l6.363 3.692z"
                />
              </svg>
            </button>
            <b-modal
              :id="`modal-video-${video.id}`"
              centered
              size="lg"
              style="min-height:500px;"
              hide-header
              hide-footer
            >
              <video-player
                :user="user"
                :video="video"
              />
            </b-modal>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style>
.card {
  margin-bottom: 1em;
}
</style>

<script>
export default {
  data: function () {
    return {
      user: {},
      message: 'Привет биба, вот результат:',
      videos: [],
      search_query: '',
      searchPressed: false
    }
  },
  computed: {
    placeholderText () { return this.user.locale === 'en' ? 'Let\'s search something' : 'Давай поищем что-нибудь' },
    searchText () { return this.user.locale === 'en' ? 'Search' : 'Поиск' },
    loadingText () { return this.user.locale === 'en' ? 'Sending...' : 'Ищем...' }
  },
  async mounted () {
    await axios
      .get('/me')
      .then((response) => {
        this.user = response.data
      })
      .catch(() => {})

    await axios
      .get('/api/latest')
      .then(response => {
        this.videos = response.data.data.movies
      })
      .catch(() => {})
      .finally(() => {
        this.searchPressed = false
      })
  },
  methods: {
    getVideos () {
      this.searchPressed = true

      axios
        .get('/api/latest', {
          params: {
            query: this.search_query
          }
        })
        .then(response => {
          this.videos = response.data.data.movies
        })
        .catch(() => {})
        .finally(() => {
          this.searchPressed = false
        })
    }
  }
}
</script>
