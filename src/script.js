import Vue from 'vue';
import App from "./App";

document.addEventListener('DOMContentLoaded', () => {
    let element = document.getElementById('disable-media-pages');
    if (element) {
        new Vue({
            el: element,
            components: {
                'disable-media-pages': App,
            },
        });
    }
});