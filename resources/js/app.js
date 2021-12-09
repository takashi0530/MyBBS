require('./bootstrap');

// vueコンポーネント本体をインポートする
import { createApp } from 'vue';

// vueコンポーネントである、ExampleComponentをインポート
import ExampleComponent from './components/ExampleComponent.vue';
import BookmarkComponent from './components/BookmarkComponent.vue';

// vueコンポーネントをマウントする
createApp({
    components: {
        ExampleComponent,
        BookmarkComponent
    }
}).mount('#app');
