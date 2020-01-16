var tagApp = new Vue({
    el: '#container',

    // MODEL
    data: {

        // REST URLs and parameters
        prefix: "/tutorial/ep8/rest/get",
        suffix: ".php",
        offset: 0,
        limit: 5,

        // POSTS DATA
        posts: {},

        // other local properties
        posts_loaded: false,
        show_more: false,
        error: "",
        show_loading: true,
        show_error_message: false,
        show_success_message: false
    },

    // CONTROLLER
    methods: {

        /**
         * load more posts by tag
         * @param event default event to prevent
         */
        load_more: function (e) {
            e.preventDefault();
            this.show_loading = true;
            this.offset += this.limit;
            let p = new URLSearchParams(window.location.search).get('p');
            axios.get(this.prefix + "postsbytag" + this.suffix + "?t=" + p + "&offset=" + this.offset)
                    .then(response => {
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
        let p = new URLSearchParams(window.location.search).get('p');
        axios.get(this.prefix + "postsbytag" + this.suffix + "?t=" + p)
                .then(response => {
                    if (response.data.success) {
                        this.posts = response.data.data.posts;
                        this.posts_loaded = true;
                        if (response.data.data.posts.length < this.limit) {
                            this.show_more = false;
                        }
                        this.show_loading = false;
                    }
                });
    }
});