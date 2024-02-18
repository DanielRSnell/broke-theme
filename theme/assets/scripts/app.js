import Alpine from 'alpinejs'
import persist from '@alpinejs/persist'

import Swup from 'swup';
import SwupFragmentPlugin from '@swup/fragment-plugin';
import SwupFormsPlugin from '@swup/forms-plugin';
import SwupHeadPlugin from '@swup/head-plugin';
import SwupPreloadPlugin from '@swup/preload-plugin';
import SwupProgressPlugin from '@swup/progress-plugin';

const swup = new Swup({
  plugins: [
    new SwupFragmentPlugin(),
    new SwupFormsPlugin(),
    new SwupHeadPlugin(),
    new SwupPreloadPlugin(),
    new SwupProgressPlugin()
  ]
});


// Import js for components
function importAll(r) {
  r.keys().forEach(r)
}

importAll(require.context("../../blocks/", true, /\/script\.js$/))

Alpine.plugin(persist);
window.Alpine = Alpine;
Alpine.start();
