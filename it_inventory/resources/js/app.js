import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

// Note: Dark mode initialization is now handled in the <head> of layouts
// to prevent flash of light mode. This ensures the theme is applied before
// the page renders.

Alpine.start();
