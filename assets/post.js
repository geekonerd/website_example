var postApp = new Vue({
    el: '#container',

    // MODEL
    data: {

        // REST URLs and parameters
        prefix: "/tutorial/ep8/rest/get",
        suffix: ".php",

        // post, tags and categories data
        post: {},
        tags: {},
        categories: {},

        // other local properties
        post_loaded: false,
        error: "",
        show_loading: true,
        show_error_message: false,
        show_success_message: false
    },

    // AJAX on load
    mounted() {

        // get post by permalink
        let p = new URLSearchParams(window.location.search).get('p');
        axios.get(this.prefix + "postbypermalink" + this.suffix + "?p=" + p)
                .then(response => {
                    if (response.data.success) {
                        this.post = response.data.data.posts;
                        this.tags = response.data.data.tags;
                        this.categories = response.data.data.categories;
                        this.post_loaded = true;
                        this.show_loading = false;
                    }
                });
    }
});