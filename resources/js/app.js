window._ = require('lodash');
try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');
    require('bootstrap');
} catch (e) {}

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

require('./datatables.bootstrap.js');
window.bootbox = require('bootbox');
require('jquery-validation');
require('./asp.validation.js');
window.toastr = require('toastr');
