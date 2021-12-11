<template>
    <button
        @click="clickBookmark"
        >
        <!-- ＜お気に入りボタン＞ -->
        <!-- <img src="../../../public/star_black_36dp.svg" alt="ブックマーク"> -->

        <!-- お気に入りボタン（星マーク） -->
        <i class="fa fa-star"
            :class="{
                'yellow-text': this.isBookmarkedBy,
                'animated heartBeat fast': this.gotToBookmark
            }"
            aria-hidden="true">
        </i>

    </button>
    <!-- <div>{{ isBookmarkedBy ? '現在ブックマークしています' : 'まだブックマークしていません' }}</div> -->
</template>

<script>
export default {
    props: {
        // 最初のブックマーク有無の値の型定義をbool型とする（trueかfalseか）
        initialIsBookmarkedBy: {
            type: Boolean,
            default: false,
        },
        // 非同期先URLの型定義をstring型とする  例) http://localhost:8590/posts/161/bookmark
        endpoint: {
            type: String,
        },
    },

    data() {
        return {
            isBookmarkedBy: this.initialIsBookmarkedBy,
            // アニメーション用の動作初期値
            gotToBookmark: false
        }
    },

    methods: {

        // ブックマークボタンがクリックされたときの処理
        clickBookmark() {
            // 該当の投稿がすでにブックマーク済みの場合
            if (this.isBookmarkedBy) {
                // ブックマークを解除する
                this.unBookmark();
            }
            // 該当の投稿がまだブックマークされていない場合
            if (!this.isBookmarkedBy) {
                // ブックマークする
                this.bookmark();
            }
        },

        // ブックマークを行う非同期メソッド
        async bookmark() {
            // 非同期通信が完了するまで待機しレスポンスを受け取る 通信先：PostControllerのbookmarkメソッド   this.endpoint   例）http://localhost:8590/posts/161/bookmark   HTTPメソッド:PATCH形式(ルーティングで判別する)
            const response = await axios.patch(this.endpoint);
            console.log(response.data);

            // ブックマークをしている状態にプロパティを変更する
            this.isBookmarkedBy = true;
            this.gotToBookmark = true;
        },

        // ブックマークを解除する非同期メソッド
        async unBookmark() {
            // 非同期通信が完了するまで待機しレスポンスを受け取る 通信先：PostControllerのbookmarkメソッド   this.endpoint   例）http://localhost:8590/posts/161/bookmark   HTTPメソッド:DELETE形式(ルーティングで判別する)
            const response = await axios.delete(this.endpoint);
            console.log(response.data);

            if (!response.data.result) {
                alert('ブックマークの解除に失敗しました');
                return false;
            }

            // ブックマークをしていない状態にプロパティを変更する
            this.isBookmarkedBy = false;
            this.gotToBookmark = false;
        },

    },
    // mounted:  コンポーネントが読み込まれた直後に実行される
    mounted() {
        // console.log('bookmarkをマウント');
    }
}
</script>
<style>
[v-cloak] {
    display: none;
}
/* お気に入りボタンの色を黄色に変える */
.yellow-text {
    color: #c4ba07;
    transition: .3s;
}
i {
    color: rgb(22, 23, 24);
    padding: 0;
    margin: 0 0 0 0;
    font-size: 30px;
}
</style>


