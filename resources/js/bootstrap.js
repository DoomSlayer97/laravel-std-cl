window._ = require('lodash');
import "bootstrap"

import Axios from "axios"
import Jquery from "jquery"


/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.$ = Jquery;

window.axios = Axios.create({
    baseURL: "http://localhost:8000/api/"
});

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/* Users crud */
axios.get("users")
    .then( res => {

        

    });


