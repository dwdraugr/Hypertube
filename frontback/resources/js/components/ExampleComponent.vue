<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="input-group mb-3">
          <input
            v-model="search_query"
            type="text"
            class="form-control"
            placeholder="Let's search something..."
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
              <div v-if="!searchPressed">Search</div>
              <div
                v-if="searchPressed"
                class="spinner-grow spinner-grow-sm"
                role="status"
              >
                <span class="sr-only">Loading...</span>
              </div>
            </button>
          </div>
        </div>
        <div v-for="video in videos" :key="video.link" class="card">
          <div class="card-header">{{ video.title }}</div>
          <div class="card-body">
            <p><b>Description:</b> {{ video.description }}</p>
            <p><b>Date:</b> {{ video.date }}</p>
            <hr />
            <p><b>Link:</b> {{ video.link }}</p>

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
              hide-header
              hide-footer
            >
              <video-player :video="video" />
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
  mounted() {
    console.log("Component mounted.");
  },
  data: function() {
    return {
      message: "Привет биба, вот результат:",
      videos: [],
      search_query: "",
      searchPressed: false
    };
  },
  computed: {
    bibaData: function() {
      return navigator.userAgent;
    }
  },
  methods: {
    getVideos() {
      this.searchPressed = true;

      axios
        .get(`/search`, {
          params: {
            query: this.search_query
          }
        })
        .then(response => {
          this.videos = response.data.map(video => {
            video.id = Math.floor(Math.random() * Math.floor(4294967296));
            if (video.description && video.description.length > 140) {
              video.description = video.description.substring(0, 140) + "...";
            }
            return video;
          });
        })
        .finally(() => {
          this.searchPressed = false;
        });
    }
  }
};
</script>
