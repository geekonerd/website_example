var adminApp = new Vue({
    el: '#admin',

    // MODEL
    data: {

        // REST URLs and parameters
        add_prefix: "/tutorial/ep8/rest/add",
        get_prefix: "/tutorial/ep8/rest/get",
        suffix: ".php",
        offset: 0,
        limit: 10,

        // tags, categories and roles
        tags: {},
        categories: {},
        roles: {},

        // type of modal to show
        type: "",

        // other local properties
        error: false,
        show_loading: false,
        show_error_message: false,
        show_success_message: false
    },

    // CONTROLLER
    methods: {

        /**
         * show a modal with all fields to create a new TYPE of content
         * @param string type of content to create (post|category|tag|user|role)
         */
        show_editor: function (type) {

            // remove old errors and set type of modal
            this.error = false;
            this.type = type;

            // specific "POST modal" settings
            // a new post requires all tags and categories
            if ("post" === type) {
                this.show_loading = true;
                axios.get(this.get_prefix + "alltags" + this.suffix).then(response => {
                    if (response.data.success) {
                        this.tags = response.data.data.tags;
                        this.tags.sort((a, b) => a["tag"].localeCompare(b["tag"]));
                        this.get_categories(this.offset);
                    } else {
                        this.error = response.data.error +
                                " (" + response.data.code + ")";
                        this.show_error_message = true;
                    }
                });
            }

            // specific "USER modal" settings
            // a new user requires all roles
            else if ("user" === type) {
                this.show_loading = true;
                axios.get(this.get_prefix + "allroles" + this.suffix).then(response => {
                    if (response.data.success) {
                        this.roles = response.data.data.roles;
                        this.roles.sort((a, b) => a["role"].localeCompare(b["role"]));
                        $('#admin_editor_' + this.type).modal();
                        this.show_loading = false;
                    } else {
                        this.error = response.data.error +
                                " (" + response.data.code + ")";
                        this.show_error_message = true;
                    }
                });
            }

            // all modals: show specific modal
            else {
                $('#admin_editor_' + type).modal();
            }
        },

        /**
         * get all categories, recursively until there're more to catch
         * @param int offset
         */
        get_categories: function (offset) {
            axios.get(this.get_prefix + "categories" + this.suffix + "?offset=" + offset).then(response => {
                if (response.data.success) {
                    this.categories = response.data.data.categories.concat(this.categories);
                    if (response.data.data.categories.length >= this.limit) {
                        this.get_categories(offset + this.limit);
                    } else {
                        this.categories.sort((a, b) => a["title"].localeCompare(b["title"]));
                        $('#admin_editor_' + this.type).modal();
                        this.show_loading = false;
                    }
                } else {
                    this.error = response.data.error +
                            " (" + response.data.code + ")";
                    this.show_error_message = true;
                }
            });
        },

        /**
         * create new content (post|category|tag|user|role)
         */
        create_new: function () {
            
            // retrieve all fields from active form and convert it to FormData
            var tmp = $("#admin_editor_" + this.type + " .modal-body form")
                    .serializeArray();
            var data = new FormData();
            for (var i = 0; i < tmp.length; i++) {
                data.set(tmp[i]["name"], tmp[i]["value"]);
            }

            // specific "CATEGORY modal" settings
            // manage input file
            if ("category" === this.type) {
                var file_data = $("#admin_editor_" + this.type + ' input[name="file"]')[0].files;
                for (var i = 0; i < file_data.length; i++) {
                    data.append("file", file_data[i]);
                }
            }

            // execute action
            var that = this;
            this.execute_action(this.type, data, function (data) {
                // fn callback: show success message and hide modal
                that.show_success_message = true;
                $('#admin_editor_' + that.type).modal('hide');
            });
        },

        /**
         * generic POST action to execute
         * @param string action to execute
         * @param object data to send
         * @param fn callback fn
         */
        execute_action: function (action, data, callback) {
            axios.post(this.add_prefix + action + this.suffix, data,
                    {headers: {'Content-Type': 'multipart/form-data'}})
                    .then(response => {
                        if (response.data.success) {
                            callback(response.data);
                        } else {
                            this.error = response.data.error +
                                    " (" + response.data.code + ")";
                            this.show_error_message = true;
                            $('#admin_editor_' + this.type).modal('hide');
                        }
                    }).catch(function (error) {
                console.log(error);
            });
        }
    }
});