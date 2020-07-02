<template>
  <div>{{ template }}</div>
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
  async fetch() {
    await axios
      .get("/download", {
        params: {
          torrentLink: this.video.link
        }
      })
      .then(response => {
        // тут же в ответ должен прилететь темплейт плеера?
        // если так, то я тупа вставлю {{ template }} наверх в див
        this.template = response;
      })
      .catch(() => {
        this.template = "Кина не будет. Плеер принял ислам"
      })
  },
  data() {
    return {
      template: ""
    };
  }
};
</script>
