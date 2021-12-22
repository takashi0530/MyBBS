'use strict';
/**
 * ZoomImg
 * 画像の拡大/縮小を行うクラス
 */
class ZoomImg {
    /**
     * コンストラクター
     * @param {string} images_selector クリックしたときに拡大させたいimgタグを指定する（セレクタ）
     */
    constructor(images_selector) {
        // 全ての画像の要素を取得
        this.all_images = document.querySelectorAll(images_selector);    // 例) '.image :first-child, .image_thum'
        this.createTags();
        this.displayLarge();
        this.hideImg();
    }
    get all_images() {
        return this._all_images;
    }
    set all_images(value) {
        this._all_images = value;
    }
    /**
     * 画像拡大用の空のタグ(DOM)を生成して挿入するメソッド（以下のタグをbodyの閉じタグ直前に挿入）
     * @return {void}
     *      <div class="zoom_div">
     *        <div class="back"></div>
     *       <div class="img_big">
     *           <img src="" alt="">
     *       </div>
     *      </div>
     */
    createTags() {
        const zoom_div_tag = document.createElement('div');
        const back_tag     = document.createElement('div');
        const img_big_tag  = document.createElement('div');
        const img_tag      = document.createElement('img');
        const fragment     = document.createDocumentFragment();
        zoom_div_tag .classList.add('zoom_div');
        back_tag     .classList.add('back')
        img_big_tag  .classList.add('img_big')
        img_big_tag  .appendChild(img_tag);
        zoom_div_tag .appendChild(back_tag);
        zoom_div_tag .appendChild(img_big_tag);
        fragment     .appendChild(zoom_div_tag);
        document.body.appendChild(fragment);
    }
    /**
     * 画像を大きくするメソッド
     * @return {void}
     */
    displayLarge() {
        this.all_images.forEach(clicked_item => {
            clicked_item.addEventListener('click', e => {
                const img_path   = clicked_item.getAttribute('src');                // 画像のパスを取得（imgタグのsrc属性値）   例) /img/campaign_banner/20211008-115828-2.jpg
                const zoom_div   = document.getElementsByClassName('zoom_div')[0];
                const img_big    = document.getElementsByClassName('img_big')[0];   // 拡大させる予定の要素を取得
                const img_tag    = img_big.firstElementChild;                       // 拡大させる画像 (imgタグ)
                const back       = document.getElementsByClassName('back')[0];      // 拡大したときの背景の要素を取得
                const body_width = document.body.clientWidth;                       // 現在のブラウザ幅
                const scroll_top = document.documentElement.scrollTop + Number(100);// 現在のスクロール量 ＋ 余白分
                // 拡大表示させる画像のsrc属性を変更
                img_tag.setAttribute('src', img_path);
                // 背景のスタイルを変更
                back.style.cssText = "width:" + body_width + "px; height:" + document.body.clientHeight + "px;";
                // 拡大させる画像のスタイルを変更
                img_big.style.cssText = "position: absolute; left: " + Math.floor((body_width - img_tag.naturalWidth) / 2) + "px; top: " + scroll_top + "px;";
                // フェードインで表示
                this.onFadeIn(zoom_div);
            });
        });
    }
    /**
     * 拡大画像を隠すメソッド
     * @return {void}
     */
    hideImg() {
        const zoom_div = document.getElementsByClassName('zoom_div')[0];
        zoom_div.addEventListener('click', e => {
            this.onFadeOut(zoom_div);
        });
    }
    /**
     * フェードインさせるメソッド（徐々に表示）
     * @return {void}
     */
    onFadeIn(target) {
        target.classList.remove('fadeout');
        target.classList.add('fadein');
    }
    /**
     * フェードアウトさせるメソッド（徐々に非表示）
     * @return {void}
     */
    onFadeOut(target) {
        target.classList.remove('fadein');
        target.classList.add('fadeout');
    }
}
