var indexApp = new Vue({
    el: '#container',

    // MODEL
    data: {

        // REST URLs and parameters
        prefix: "/tutorial/ep8/rest/get",
        suffix: ".php",
        offset: 0,
        limit: 5,

        // posts, tags data
        posts: {},
        tags: {},

        // other local properties
        tags_loaded: false,
        posts_loaded: false,
        error: "",
        show_loading: true,
        show_error_message: false,
        show_success_message: false
    },

    // CONTROLLER
    methods: {

        /**
         * load more posts
         * @param event default event to prevent
         */
        load_more: function (e) {
            e.preventDefault();
            this.show_loading = true;
            this.offset += this.limit;
            axios.get(this.prefix + "postssummaries" + this.suffix + "?offset=" + this.offset).then(response => {
                if (response.data.success) {
                    this.posts = this.posts.concat(response.data.data.posts);
                    if (response.data.data.posts.length < this.limit) {
                        this.show_more = false;
                    }
                    this.show_loading = false;
                }
            });
        }
    },

    // AJAX on load
    mounted() {

        // get latests posts
        axios.get(this.prefix + "postssummaries" + this.suffix).then(response => {
            if (response.data.success) {
                this.posts = response.data.data.posts;
                this.posts_loaded = true;
                if (response.data.data.posts.length >= this.limit) {
                    this.show_more = true;
                }

                // get tags
                axios.get(this.prefix + "alltags" + this.suffix).then(response => {
                    if (response.data.success) {
                        this.tags = response.data.data.tags;
                        this.tags_loaded = true;
                    }
                    this.show_loading = false;
                });
            }
        });
    }
});