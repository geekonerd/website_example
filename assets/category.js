var categoryApp = new Vue({
    el: '#container',

    // MODEL
    data: {

        // REST URLs and parameters
        delete_prefix: "/tutorial/ep8/rest/delete",
        edit_prefix: "/tutorial/ep8/rest/edit",
        get_prefix: "/tutorial/ep8/rest/get",
        suffix: ".php",

        // posts, category data
        posts: {},
        category: {},

        // other local properties
        category_loaded: false,
        error: "",
        show_loading: true,
        show_error_message: false,
        show_success_message: false
    },

    // AJAX on load
    mounted() {
        // refresh view
        this.refresh_data();
    },

    // CONTROLLER
    methods: {

        /**
         * refresh data on page
         * @param fn callback fn to execute when the refresh is done
         */
        refresh_data: function (callback) {

            // get latests posts
            this.show_loading = true;
            let p = new URLSearchParams(window.location.search).get('p');
            axios.get(this.get_prefix + "latestpostsbycategory" + this.suffix + "?p=" + p)
                    .then(response => {
                        if (response.data.success) {
                            this.posts = response.data.data.posts;
                            this.category = response.data.data.category;
                            this.category_loaded = true;
                            this.show_loading = false;
                            if (callback) {
                                callback();
                            }
                        }
                    });
        },

        /**
         * show category editor
         */
        show_editor: function () {
            this.error = false;
            $('#category_editor').modal();
        },

        /**
         * edit current category
         */
        edit_category: function () {
            
            // get fields data from modal and convert it to FormData
            var tmp = $("#category_editor .modal-body form").serializeArray();
            var data = new FormData();
            for (var i = 0; i < tmp.length; i++) {
                data.set(tmp[i]["name"], tmp[i]["value"]);
            }
            // get file data, if any cover is in
            var file_data = $("#category_editor" + ' input[name="file"]')[0].files;
            for (var i = 0; i < file_data.length; i++) {
                data.append("file", file_data[i]);
            }
            var that = this;
            
            // execute action
            this.execute_action(this.edit_prefix + "category" + this.suffix,
                    data, function () {
                        // update the view, show success message, and hide modal
                        that.refresh_data(function () {
                            that.show_success_message = true;
                            $('#category_editor').modal('hide');
                        });
                    });
        },

        /**
         * delete current category
         * @param {type} id
         */
        delete_category: function (id) {
            // user must agree
            if (confirm("Sei sicuro di voler cancellare la categoria?")) {
                // get current id and delete category from db
                var data = new FormData();
                data.set("category", id);
                this.execute_action(this.delete_prefix + "category" + this.suffix,
                        data, function (data) {
                            // show success message and hide modal
                            that.refresh_data(function () {
                                that.show_success_message = true;
                                $('#category_editor').modal('hide');
                            });
                        });
            }
        },

        /**
         * generic POST action to execute
         * @param string action to execute
         * @param object data to send
         * @param fn callback fn
         */
        execute_action: function (action, data, callback) {
            axios.post(action, data,
                    {headers: {'Content-Type': 'multipart/form-data'}})
                    .then(response => {
                        if (response.data.success) {
                            callback(response.data);
                        } else {
                            this.error = response.data.error +
                                    " (" + response.data.code + ")";
                            this.show_error_message = true;
                            $('#category_editor').modal('hide');
                        }
                    }).catch(function (error) {
                console.log(error);
            });
        }
    }
});