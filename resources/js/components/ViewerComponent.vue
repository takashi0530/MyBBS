<template>
<div>
    <!-- サムネイル画像（拡大前） -->
    <img
        class="thumbnail_img w-52"
        :src="`${imgName}`"
        @click="clickImg"
    >
    <!-- モーダル部分 -->
    <div
        class="zoom_div"
        v-show="showMask"
        @click="hideImg"
    >
        <!-- 背景のグレーマスク -->
        <div class="back"></div>
        <div class="img_big" ref="img_big">
            <!-- サムネイルを画像した画像 -->
            <img
                :src='`${imgName}`'
            >
        </div>
    </div>
</div>
</template>

<script>
export default {
    props: {
        initialImgName: {
            type: String,
            default: '',
        },
        initialShowMask: {
            type: Boolean,
            default: false
        }
    },
    data() {
        return {
            image_a: 'star_black_36dp.svg',
            // 画像の名前
            imgName: this.initialImgName,
            // モーダルの表示・非表示判定
            showMask: this.initialShowMask
        }
    },
    methods: {
        clickImg() {
            // モーダルの表示と非表示の切り替え
            this.toggleImg();
            // 拡大させる予定の要素を取得
            const img_big    = this.$refs.img_big;
            // 現在のブラウザ幅
            const body_width = document.body.clientWidth;
            // 現在のスクロール量 ＋ 余白分
            const scroll_top = document.documentElement.scrollTop + Number(100);
            // 拡大させる画像のスタイルを変更
            img_big.style.cssText = "position: absolute; left: " + Math.floor((body_width - img_big.width) / 2) + "px; top: " + scroll_top + "px;";
        },
        hideImg() {
            // モーダルの表示と非表示の切り替え
            this.toggleImg();
        },
        toggleImg() {
            this.showMask = !this.showMask;
        }
    }
}
</script>

<style scoped>
.zoom_div {
    margin: 0 auto;
}
.back {
    /* マスクの色指定 */
    background: rgba(0, 0, 0, 0.4);
    /* マスクの位置の指定 以下設定で全画面設定できる */
    position: fixed;
    top: 0;
    bottom: 0;
    right: 0;
    left: 0;
    /* マスクの重なりをモーダルの下に設定する */
    z-index: 1;
}
.back_a {
    background: rgba(0, 0, 0, 0.5);
    position: absolute;
    left: 0px;
    top: 0px;
}
.img_big {
    background: #FFF;
    max-width: 1900px;
    max-height: 1000px;
    width: 1300px;
    height: 800px;
    padding: 20px;
    border-radius: 4px;
    /* position: absolute; */
    /* top: 40px; */
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    margin: auto;
    /* トランスフォームが変化するとき0.4秒かける */
    transition: transform 0.4s;
    /* モーダルの重なりを一番上に設定する */
    z-index: 2;
}
.img_big > img {
    max-width: 1300px;
    max-height: 800px;
    width: 100%;
    height: 100%;
    box-sizing: border-box;
}
</style>
