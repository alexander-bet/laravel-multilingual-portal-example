import './bootstrap';
import './carousels';

import Alpine from 'alpinejs';
import focus from '@alpinejs/focus';
import collapse from '@alpinejs/collapse';
import { leadForm } from './lead-form';

Alpine.plugin(focus);
Alpine.plugin(collapse);

Alpine.data('leadForm', leadForm);

window.Alpine = Alpine;
Alpine.start();
