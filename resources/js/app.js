require('./bootstrap');

import { createApp } from 'vue'
import Alert from './components/Alert.vue'

createApp({
    components: {
        Alert
    }
}).mount('#app')
