/**
 * We'll load axios for HTTP requests
 */
import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-with'] = 'XMLHttpRequest';

import { Livewire } from '../../vendor/livewire/livewire/dist/livewire.esm';

Livewire.start();
