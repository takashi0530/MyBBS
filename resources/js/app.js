require('./bootstrap');

// vueコンポーネント本体をインポートする
import { createApp } from 'vue';

// vueコンポーネントである、ExampleComponentをインポート
import ExampleComponent from './components/ExampleComponent.vue';
import BookmarkComponent from './components/BookmarkComponent.vue';
import ViewerComponent from './components/ViewerComponent.vue';
// import ViewerComponentTest from './components/ViewerComponentTest.vue';


// vueコンポーネントをマウントする
createApp({
    components: {
        ExampleComponent,
        BookmarkComponent,
        ViewerComponent,
        // ViewerComponentTest,
    }
}).mount('#app');
