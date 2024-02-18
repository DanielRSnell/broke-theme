import Alpine from 'alpinejs'
import 'htmx.org';

window.Alpine = Alpine

// Import js for components
function importAll(r) {
  r.keys().forEach(r)
}

importAll(require.context("../../blocks/", true, /\/script\.js$/))

window.htmx = require('htmx.org')
window.Alpine.start()
