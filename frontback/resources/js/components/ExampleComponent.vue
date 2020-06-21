<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="input-group mb-3">
                    <input v-model="search_query" type="text" class="form-control" placeholder="Let's search something..." aria-label="Recipient's username" aria-describedby="button-addon2">
                    <div class="input-group-append">
                        <button v-on:click="getVideos()" class="btn btn-outline-secondary" type="button" id="button-addon2">Button</button>
                    </div>
                </div>
                <div v-for="video in videos" class="card">
                    <div class="card-header">{{ video.title }}</div>
                    <div class="card-body">
                        <p><b>Description:</b> {{ video.description}}</p>
                        <p><b>Date:</b> {{ video.date }}</p>
                        <hr/>
                        <p><b>Link:</b> {{ video.link }}</p>
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
            console.log('Component mounted.');
        },
        data: function () {
            return {
                message: 'Привет биба, вот результат:',
                videos: [],
                search_query: '',
            };
        },
        computed: {
            bibaData: function () {
                return navigator.userAgent;
            },
        },
        methods: {
            getVideos() {
                axios.get('/search', {
                    params: {
                        query: this.search_query
                    }
                })
                    .then(response => {
                        this.videos = this.cutDescription(response.data);
                    });
            },
            cutDescription(videos) {
                for (let i = 0; i < videos.length; i++) {
                    if (videos[i].description != null && videos[i].description.length > 140) {
                        videos[i].description = videos[i].description.substring(0, 140) + '...';
                    }
                }
                return videos;
            }
        }
    }
</script>
