import './bootstrap';
import './theme.js';
import 'tinymce/tinymce';
import 'tinymce/skins/ui/oxide/skin.min.css';
import 'tinymce/skins/content/default/content.min.css';
// TODO: remove the body margin 1rem since it's causing glitch in dark mode.
import 'tinymce/skins/content/default/content.css';
import 'tinymce/icons/default/icons';
import 'tinymce/themes/silver/theme';
import 'tinymce/models/dom/model';
import sort from '@alpinejs/sort'
import Alpine from 'alpinejs';

window.addEventListener('DOMContentLoaded', () => {
    tinymce.init({
        selector: 'textarea',
        skin: false,
        content_css: false
    });
});


Alpine.plugin(sort)
window.Alpine = Alpine;
Alpine.start();
