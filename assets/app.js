/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/main.scss';

// start the Stimulus application
import './bootstrap';

/*
* Activar JQuery:
* https://stackoverflow.com/questions/48971680/webpack-encore-is-not-defined
* */
const $ = require('jquery');

// create global $ and jQuery variables
global.$ = global.jQuery = $;


//=================================================================================
// Twitter Bootstrap JS
// this "modifies" the jquery module: adding behavior to it
// the bootstrap module doesn't export/return anything
require('bootstrap');

import './sb-admin2/js/sb-admin-2';

require('bootstrap-table');
require('leaflet');
//require('./maps/map');
