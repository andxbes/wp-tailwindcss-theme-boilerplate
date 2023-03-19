// you can import modules from the theme lib or even from
// NPM packages if they support it…
import ExampleComponent1 from "./components/ExampleComponent1";

// you can also require modules if they support it…
const ExampleModule2 = require('./components/example-2');

// Some convenient tools to get you started…
import ReplaceObfuscatedEmailAddresses from "./components/ReplaceObfuscatedEmailAddresses";
import AnimateOnPageLinks from "./components/AnimateOnPageLinks";


// Initialise our components on jQuery.ready…
// jQuery(function ($) {
//     ExampleComponent1.init();
//     ExampleModule2.init();
//     ReplaceObfuscatedEmailAddresses.init();
//     AnimateOnPageLinks.init();
// });

import Alpine from 'alpinejs';
import intersect from '@alpinejs/intersect';
Alpine.plugin(intersect); //lazy-loading, infinity loading

import theme from "./components/alpine/theme";
import accordions from "./components/alpine/accordions";

if (typeof window !== 'undefined') {
    window.addEventListener('DOMContentLoaded', () => {
        const _load = Promise.resolve(Alpine.start());
        _load.then(() => {
            // console.info(started alpine);
        });
    })

    document.addEventListener('alpine:init', () => {
        window.Alpine = Alpine;
        window.theme = theme;
        window.accordions = accordions;
    });
}