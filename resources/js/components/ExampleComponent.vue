<template>
    <div class='hello-vue'>
        HELLO！Vueコンポーネント！
    </div>
</template>

<script>
export default {
    data() {
        return {
            message: 'こんにちは！vue.js  '
        }
    },
    // vue読み込み時に実行される （コンポーネントのインスタンスがDOMと結びついた直後）
    mounted() {
        // alert(this.message);
        console.log('VUe Component がマウントされました');
    }
}
</script>

<style scoped>
.hello-vue {
    background-color: skyblue;
}
</style>
