import './bootstrap';
import { createApp } from 'vue';

const app = createApp({});

import { ModelListSelect } from 'vue-search-select';
import 'vue-search-select/dist/VueSearchSelect.css';

import ListCalls from './pages/ListCalls.vue';
import CreateCall from './pages/CreateCall.vue';

app.component('list-calls', ListCalls);
app.component('create-call', CreateCall);

app.component('model-list-select', ModelListSelect);

app.mount('#app');
