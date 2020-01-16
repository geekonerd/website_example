var categoriesApp = new Vue({
    el: '#container',

    // MODEL
    data: {

        // REST URLs and parameters
        prefix: "/tutorial/ep8/rest/get",
        suffix: ".php",
        offset: 0,
        limit: 10,

        // POSTS DATA
        categories: {},

        // other local properties
        show_more: false,
        error: false,
        categories_loaded: false,
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
            axios.get(this.prefix + "categories" + this.suffix + "?offset=" + this.offset).then(response => {
                if (response.data.success) {
                    this.categories = this.categories.concat(response.data.data.categories);
                    if (response.data.data.categories.length < this.limit) {
                        this.show_more = false;
                    }
                    this.show_loading = false;
                }
            });
        }
    },

    // AJAX on load
    mounted() {

        // get categories
        axios.get(this.prefix + "categories" + this.suffix).then(response => {
            if (response.data.success) {
                this.categories = response.data.data.categories;
                this.categories_loaded = true;
                if (response.data.data.categories.length >= this.limit) {
                    this.show_more = true;
                }
                this.show_loading = false;
            }
        });
    }
});