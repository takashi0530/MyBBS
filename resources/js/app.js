require('./bootstrap');

// vueコンポーネント本体をインポートする
import { createApp } from 'vue';

// vueコンポーネントである、ExampleComponentをインポート
import ExampleComponent from './components/ExampleComponent.vue';

// vueコンポーネントをマウントする
createApp({
    components: {
        ExampleComponent
    }
}).mount('#app');
