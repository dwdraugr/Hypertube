<template>
  <div>
    <b-overlay :show="queryInProgress" spinner-type="grow">
      <div v-html="template" />
    </b-overlay>
  </div>
</template>

<script>
export default {
  props: {
    video: {
      type: Object,
      default: () => {
        return {};
      }
    }
  },
  data () {
    return {
      queryInProgress: true
    };
  },
  async mounted () {
    await axios
      .get("/download", {
        params: {
          torrentLink: this.video.torrents[0].url
        }
      })
      .then(response => {
        this.template = response.data;
      })
      .catch(() => {
        this.template = "Кина не будет. Плеер принял ислам";
      })
      .finally(() => {
        this.queryInProgress = false;
      });
  }
};
</script>
