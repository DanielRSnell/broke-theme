import Alpine from 'alpinejs'
import persist from '@alpinejs/persist'
import morph from '@alpinejs/morph'

import 'htmx.org'

// Import js for components
function importAll(r) {
  r.keys().forEach(r)
}

window.htmx = require('htmx.org');

htmx.config.globalViewTransitions = true


importAll(require.context("../../blocks/", true, /\/script\.js$/))

Alpine.plugin(persist, morph);
window.Alpine = Alpine;
Alpine.start();
