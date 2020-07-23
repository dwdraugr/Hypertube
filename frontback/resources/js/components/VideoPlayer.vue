<template>
  <div>
    <b-overlay :show="queryInProgress" spinner-type="grow">
      <div
        v-html="template"
        class="text-center"
      />
      <comments
        v-if="!queryInProgress"
        :user="user"
        :video="video"
      />
    </b-overlay>
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
      template: '',
      queryInProgress: true
    }
  },
  computed: {
    errorMessage () {
      return this.user.locale === 'en' ? 'Oh, shit, I\'m sorry' : 'Кина не будет. Плеер принял ислам'
    }
  },
  async mounted () {
    await axios
      .get('/download', {
        params: {
          torrentLink: this.video.torrents[0].url
        }
      })
      .then(response => {
        this.template = response.data
      })
      .catch(() => {
        this.template = this.errorMessage
      })
      .finally(() => {
        this.queryInProgress = false
      })
  }
}
</script>
