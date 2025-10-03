import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// import { createApp } from 'vue';
// import ProgramList from './components/ProgramList.vue';

// const app = createApp({});
// app.component('program-list', ProgramList);
// app.mount('#app')

import { createApp } from 'vue'
import FeedbackForm from './components/FeedbackForm.vue'
import FeedbackReport from './components/FeedbackReport.vue'
import WordCloud from './components/WordCloud.vue'

const app = createApp({})

app.component('feedback-form', FeedbackForm)
app.component('feedback-report', FeedbackReport)
app.component('word-cloud', WordCloud)

app.mount('#app')

