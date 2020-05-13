<?php

use Illuminate\Database\Seeder;
use \App\Models\User;

/**
 * Class DummyDataSeeder
 *
 * dummyデータを生成する
 */
class DummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = \Carbon::now();

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('users')->truncate();
        DB::table('analytics')->truncate();
        DB::table('clients')->truncate();
        DB::table('client_label')->truncate();
        DB::table('label_project')->truncate();
        DB::table('labels')->truncate();
        DB::table('projects')->truncate();
        DB::table('project_statuses')->truncate();
        DB::table('memos')->truncate();
        DB::table('todos')->truncate();
        DB::table('sales')->truncate();

        DB::table('users')->insert([
            [
                'name' => 'user1',
                'email' => 'user1@user.com',
                'password' => \Hash::make('password1'),
                'icon_path' => 'https://my-manage-tool.s3-ap-northeast-1.amazonaws.com/files/common/img/header-icon.jpg',
                'created_at' => $now,
                'updated_at' => $now,
            ]
        ]);
        DB::table('clients')->insert([
                [
                    'user_id' => 1,
                    'name' => 'システム開発会社 xx',
                    'address' => '大阪府大阪市北区扇町 xxx',
                    'note' => "Webシステム開発の会社\r\n 今後は機械学習方面にも進出予定\r\n SES事業から受託に移行中",
                    'url' => '',
                    'contract_date' => '2020-1-10',
                    'icon_path' => 'https://my-manage-tool.s3-ap-northeast-1.amazonaws.com/files/common/img/company-icon-1.jpg',
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'user_id' => 1,
                    'name' => 'システム開発会社 ◯◯',
                    'address' => '大阪府大阪市中央区本町 xxx',
                    'note' => "求人仲介事業をメインに扱う会社 \r\n 求人サイトを複数運営しており、機能追加・改修がメインとなる",
                    'url' => '',
                    'contract_date' => '2020-1-20',
                    'icon_path' => 'https://my-manage-tool.s3-ap-northeast-1.amazonaws.com/files/common/img/company-icon-2.jpg',
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'user_id' => 1,
                    'name' => 'デザイン会社 xx',
                    'address' => '兵庫県明石市相生町 xxx',
                    'note' => "Webをメインとするデザイン製作会社\r\n デザイナーは多数いるがエンジニアが不足しているとのこと",
                    'url' => '',
                    'contract_date' => '2020-2-15',
                    'icon_path' => 'https://my-manage-tool.s3-ap-northeast-1.amazonaws.com/files/common/img/company-icon-3.jpg',
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'user_id' => 1,
                    'name' => 'デザイン会社 ◯◯',
                    'address' => '京都府京都市中京区柏屋町 xxx',
                    'note' => "京都にあるデザイン製作会社\r\n 紙媒体からWebまで幅広く案件あり\r\n\r\n オフィスがおしゃれ",
                    'url' => '',
                    'contract_date' => '2020-2-20',
                    'icon_path' => 'https://my-manage-tool.s3-ap-northeast-1.amazonaws.com/files/common/img/company-icon-4.jpg',
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'user_id' => 1,
                    'name' => 'ゲーム制作会社 xx',
                    'address' => '大阪府大阪市浪速区湊町 xxx',
                    'note' => "アプリをメインとしたゲーム制作会社\r\n API側はほぼ業務委託で回している",
                    'url' => '',
                    'contract_date' => '2020-2-28',
                    'icon_path' => 'https://my-manage-tool.s3-ap-northeast-1.amazonaws.com/files/common/img/company-icon-5.jpg',
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'user_id' => 1,
                    'name' => 'おさかなやさん ◯◯',
                    'address' => '大阪府大阪市中央区日本橋2-4-1 xxx',
                    'note' => "黒門市場にある魚屋さん\r\n ECサイトを展開予定\r\n\r\n のどぐろが絶品",
                    'url' => 'https://kuromon.com/jp/',
                    'contract_date' => '2020-3-1',
                    'icon_path' => 'https://my-manage-tool.s3-ap-northeast-1.amazonaws.com/files/common/img/company-icon-6.jpg',
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
            ]

        );

        DB::table('project_statuses')->insert([
                [
                    'user_id' => 1,
                    'name' => '新規受付',
                    'color' => '#7A9E9F',
                ],
                [
                    'user_id' => 1,
                    'name' => '進行中',
                    'color' => '#EB5E28',
                ],
                [
                    'user_id' => 1,
                    'name' => '完了',
                    'color' => '#41B883',
                ],
                [
                    'user_id' => 1,
                    'name' => 'キャンセル',
                    'color' => '#F3BB45',
                ],
            ]
        );

        DB::table('sale_statuses')->insert([
                [
                    'user_id' => 1,
                    'name' => '仮確定',
                    'color' => '#7A9E9F',
                ],
                [
                    'user_id' => 1,
                    'name' => '確定',
                    'color' => '#EB5E28',
                ],
                [
                    'user_id' => 1,
                    'name' => '請求書送付済み',
                    'color' => '#F3BB45',
                ],
                [
                    'user_id' => 1,
                    'name' => '入金済み',
                    'color' => '#41B883',
                ],
            ]
        );

        DB::table('projects')->insert([
                [
                    'user_id' => 1,
                    'client_id' => 1,
                    'name' => '顧客管理システム',
                    'content' => "インフラ整備会社の顧客管理システム開発\r\nデザインは管理画面テンプレートを使用",
                    'status_id' => 3,
                    'start_date' => '2020-1-10',
                    'limit_date' => '2020-4-10',
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'user_id' => 1,
                    'client_id' => 2,
                    'name' => '求人システム',
                    'content' => "稼働中の求人システムの改修\r\nチケットが切られるのでissue単位での対応",
                    'status_id' => 2,
                    'start_date' => '2020-1-20',
                    'limit_date' => null,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'user_id' => 1,
                    'client_id' => 3,
                    'name' => '地域ポータルサイト',
                    'content' => "デザインと仕様書は先方から支給(psd)\r\n受け取り次第コーディング・システム組み込み開始",
                    'status_id' => 3,
                    'start_date' => '2020-2-15',
                    'limit_date' => '2020-4-10',
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'user_id' => 1,
                    'client_id' => 4,
                    'name' => 'LPサイトお問い合わせフォーム',
                    'content' => "LPサイトのお問い合わせフォーム実装\r\nデザイン及びコーディングデータは先方から支給\r\n\r\n要セキュリティ対策 (CSRF / XSS など)",
                    'status_id' => 3,
                    'start_date' => '2020-2-20',
                    'limit_date' => '2020-3-20',
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'user_id' => 1,
                    'client_id' => 5,
                    'name' => 'iosアプリのAPI開発',
                    'content' => "2021年リリース予定のiosアプリのAPI開発\r\n作業指示は先方のディレクターからいただく",
                    'status_id' => 2,
                    'start_date' => '2020-4-1',
                    'limit_date' => '2021-4-1',
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'user_id' => 1,
                    'client_id' => 6,
                    'name' => 'ECサイト開発',
                    'content' => "取扱商品のECサイト開発\r\n先方はWebに詳しくないので密な打ち合わせが必要",
                    'status_id' => 1,
                    'start_date' => null,
                    'limit_date' => null,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
            ]
        );

        DB::table('sales')->insert([
                [
                    'user_id' => 1,
                    'project_id' => 1,
                    'planned_deposit_date' => '2020-1-31',
                    'deposit_date' => '2020-1-31',
                    'price' => 180000,
                    'sale_status_id' => 4,
                    'note' => null,
                ],
                [
                    'user_id' => 1,
                    'project_id' => 1,
                    'planned_deposit_date' => '2020-2-28',
                    'deposit_date' => '2020-2-28',
                    'price' => 200000,
                    'sale_status_id' => 4,
                    'note' => null,
                ],
                [
                    'user_id' => 1,
                    'project_id' => 2,
                    'planned_deposit_date' => '2020-2-28',
                    'deposit_date' => '2020-2-28',
                    'price' => 150000,
                    'sale_status_id' => 4,
                    'note' => null,
                ],
                [
                    'user_id' => 1,
                    'project_id' => 3,
                    'planned_deposit_date' => '2020-3-15',
                    'deposit_date' => '2020-3-15',
                    'price' => 100000,
                    'sale_status_id' => 4,
                    'note' => null,
                ],
                [
                    'user_id' => 1,
                    'project_id' => 1,
                    'planned_deposit_date' => '2020-3-31',
                    'deposit_date' => '2020-3-31',
                    'price' => 210000,
                    'sale_status_id' => 4,
                    'note' => null,
                ],
                [
                    'user_id' => 1,
                    'project_id' => 2,
                    'planned_deposit_date' => '2020-3-31',
                    'deposit_date' => '2020-3-31',
                    'price' => 180000,
                    'sale_status_id' => 4,
                    'note' => null,
                ],
                [
                    'user_id' => 1,
                    'project_id' => 1,
                    'planned_deposit_date' => '2020-4-30',
                    'deposit_date' => '2020-4-30',
                    'price' => 200000,
                    'sale_status_id' => 4,
                    'note' => null,
                ],
                [
                    'user_id' => 1,
                    'project_id' => 2,
                    'planned_deposit_date' => '2020-4-30',
                    'deposit_date' => '2020-4-30',
                    'price' => 220000,
                    'sale_status_id' => 4,
                    'note' => null,
                ],
                [
                    'user_id' => 1,
                    'project_id' => 3,
                    'planned_deposit_date' => '2020-4-30',
                    'deposit_date' => '2020-4-30',
                    'price' => 320000,
                    'sale_status_id' => 4,
                    'note' => null,
                ],
                [
                    'user_id' => 1,
                    'project_id' => 5,
                    'planned_deposit_date' => '2020-4-30',
                    'deposit_date' => null,
                    'price' => 158000,
                    'sale_status_id' => 4,
                    'note' => null,
                ],
                [
                    'user_id' => 1,
                    'project_id' => 4,
                    'planned_deposit_date' => '2020-5-1',
                    'deposit_date' => '2020-5-1',
                    'price' => 58000,
                    'sale_status_id' => 4,
                    'note' => null,
                ],
                [
                    'user_id' => 1,
                    'project_id' => 1,
                    'planned_deposit_date' => '2020-5-30',
                    'deposit_date' => null,
                    'price' => 180000,
                    'sale_status_id' => 3,
                    'note' => null,
                ],
                [
                    'user_id' => 1,
                    'project_id' => 2,
                    'planned_deposit_date' => '2020-5-30',
                    'deposit_date' => null,
                    'price' => 320000,
                    'sale_status_id' => 2,
                    'note' => null,
                ],
                [
                    'user_id' => 1,
                    'project_id' => 5,
                    'planned_deposit_date' => '2020-5-30',
                    'deposit_date' => null,
                    'price' => 235000,
                    'sale_status_id' => 2,
                    'note' => null,
                ],
                [
                    'user_id' => 1,
                    'project_id' => 6,
                    'planned_deposit_date' => '2020-5-25',
                    'deposit_date' => null,
                    'price' => 120000,
                    'sale_status_id' => 1,
                    'note' => null,
                ],
            ]
        );

        DB::table('labels')->insert([
                [
                    'user_id' => 1,
                    'name' => '新規',
                    'type' => 1,
                ],
                [
                    'user_id' => 1,
                    'name' => '見積もり済み',
                    'type' => 1,
                ],
                [
                    'user_id' => 1,
                    'name' => '先方チェック待ち',
                    'type' => 1,
                ],
                [
                    'user_id' => 1,
                    'name' => '納品完了',
                    'type' => 1,
                ],
                [
                    'user_id' => 1,
                    'name' => '請求済み',
                    'type' => 1,
                ],
                [
                    'user_id' => 1,
                    'name' => '入金済み',
                    'type' => 1,
                ],
                [
                    'user_id' => 1,
                    'name' => '毎週火曜打ち合わせ',
                    'type' => 1,
                ],
            ]
        );

        DB::table('label_project')->insert([
                [
                    'project_id' => 1,
                    'label_id' => 4,
                ],
                [
                    'project_id' => 1,
                    'label_id' => 5,
                ],
                [
                    'project_id' => 1,
                    'label_id' => 6,
                ],
                [
                    'project_id' => 3,
                    'label_id' => 4,
                ],
                [
                    'project_id' => 3,
                    'label_id' => 5,
                ],
                [
                    'project_id' => 3,
                    'label_id' => 6,
                ],
                [
                    'project_id' => 4,
                    'label_id' => 4,
                ],
                [
                    'project_id' => 4,
                    'label_id' => 5,
                ],
                [
                    'project_id' => 4,
                    'label_id' => 6,
                ],
                [
                    'project_id' => 2,
                    'label_id' => 3,
                ],
                [
                    'project_id' => 5,
                    'label_id' => 7,
                ],
                [
                    'project_id' => 6,
                    'label_id' => 1,
                ],
                [
                    'project_id' => 6,
                    'label_id' => 2,
                ],
            ]
        );

        DB::table('labels')->insert([
                [
                    'user_id' => 1,
                    'name' => '新規',
                    'type' => 2,
                ],
                [
                    'user_id' => 1,
                    'name' => '要客先打ち合わせ',
                    'type' => 2,
                ],
                [
                    'user_id' => 1,
                    'name' => '出向あり',
                    'type' => 2,
                ],
                [
                    'user_id' => 1,
                    'name' => 'フルリモート',
                    'type' => 2,
                ],
                [
                    'user_id' => 1,
                    'name' => '単発',
                    'type' => 2,
                ],
                [
                    'user_id' => 1,
                    'name' => '継続あり',
                    'type' => 2,
                ],
            ]
        );

        DB::table('client_label')->insert([
                [
                    'client_id' => 1,
                    'label_id' => 10,
                ],
                [
                    'client_id' => 1,
                    'label_id' => 13,
                ],
                [
                    'client_id' => 2,
                    'label_id' => 11,
                ],
                [
                    'client_id' => 2,
                    'label_id' => 13,
                ],
                [
                    'client_id' => 3,
                    'label_id' => 11,
                ],
                [
                    'client_id' => 3,
                    'label_id' => 12,
                ],
                [
                    'client_id' => 4,
                    'label_id' => 11,
                ],
                [
                    'client_id' => 4,
                    'label_id' => 12,
                ],
                [
                    'client_id' => 5,
                    'label_id' => 9,
                ],
                [
                    'client_id' => 5,
                    'label_id' => 11,
                ],
                [
                    'client_id' => 5,
                    'label_id' => 13,
                ],
                [
                    'client_id' => 6,
                    'label_id' => 8,
                ],
            ]
        );

        DB::table('memos')->insert([
                [
                    'user_id' => 1,
                    'title' => 'Vueで要素を表示 / 非表示時にアニメーションさせる',
                    'content' => '- アニメーションさせたい要素を`transition`( = ラッパーコンポーネント)で囲む
- `transition`のname属性に好きな文字列を設定
- 例えば`modal`という名前にした場合、表示の場合は`modal-enter`というクラス名が付与され、非表示の場合は`modal-leave-active`というクラス名が付与される
- <a href="https://jp.vuejs.org/v2/guide/transitions.html#%E3%83%88%E3%83%A9%E3%83%B3%E3%82%B8%E3%82%B7%E3%83%A7%E3%83%B3%E3%82%AF%E3%83%A9%E3%82%B9" target="_blank">クラス一覧はここ</a>
- <a href="https://jp.vuejs.org/v2/guide/transitions.html#%E3%82%AB%E3%82%B9%E3%82%BF%E3%83%A0%E3%83%88%E3%83%A9%E3%83%B3%E3%82%B8%E3%82%B7%E3%83%A7%E3%83%B3%E3%82%AF%E3%83%A9%E3%82%B9" target="_blank">クラス名は独自のものにカスタマイズも可能</a>


```js
<transition name="modal">
    <div class="modal-container" v-if="show">
        (省略)
    </div>
  </transition>
```
***
```css
  .modal-enter,
  .modal-leave-active {
    opacity: 0;
  }
  .modal-enter .modal-container,
  .modal-leave-active .modal-container {
    -webkit-transform: scale(1.1);
    transform: scale(1.1);
  }
```',
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'user_id' => 1,
                    'title' => '認証でjwt-authを使ってみる',
                    'content' => "- <a href=\"https://jwt-auth.readthedocs.io/en/develop/quick-start/\" target=\"_blank\">参考サイト1</a>
- <a href=\"https://dev.to/mrnaif2018/how-to-make-nuxt-auth-working-with-jwt-a-definitive-guide-9he\" target=\"_blank\">参考サイト2</a>",
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'user_id' => 1,
                    'title' => '【React】都道府県セレクトボックスめも',
                    'content' => '### 定数定義
```js
export default class Const {
  static PREF_OPTIONS = [
      "北海道",
      "青森県",
      "岩手県",
      "宮城県",
      "秋田県",
      "山形県",
      "福島県",
      "茨城県",
      "栃木県",
      "群馬県",
      "埼玉県",
      "千葉県",
      "東京都",
      "神奈川県",
      "新潟県",
      "富山県",
      "石川県",
      "福井県",
      "山梨県",
      "長野県",
      "岐阜県",
      "静岡県",
      "愛知県",
      "三重県",
      "滋賀県",
      "京都府",
      "大阪府",
      "兵庫県",
      "奈良県",
      "和歌山県",
      "鳥取県",
      "島根県",
      "岡山県",
      "広島県",
      "山口県",
      "徳島県",
      "香川県",
      "愛媛県",
      "高知県",
      "福岡県",
      "佐賀県",
      "長崎県",
      "熊本県",
      "大分県",
      "宮崎県",
      "鹿児島県",
      "沖縄県"
  ];
}
```

### 表示側
```js
import Const from "./const";
class Form extends Component {
    render() {
      <select>
        {Const.PREF_OPTIONS.map(option => {
          return (<option value={option}>{option}</option>)
        })}
      </select>

    }
}
```
',
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'user_id' => 1,
                    'title' => 'Nuxtで複数のAPIを呼ぶと画面描画が遅くなる',
                    'content' => "promise.allで解決した

```js
    await Promise.all([
        store.dispatch('project/fetch'),
        store.dispatch('client/fetch'),
        store.dispatch('label/fetch'),
    ]);
```",
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'user_id' => 1,
                    'title' => 'Nuxtで金額をカンマ区切りで表示',
                    'content' => "### plugins/filter.jsを作成

```js
import Vue from 'vue'

Vue.filter('price', function (value) {
 return Number(value).toLocaleString();
})
```

### nuxt.config.jsで読み込む
```js
  plugins: [
    { src: '~/plugins/filter' },
  ],
```

### 使用する
```js
<p>{{ price | price }}円</p>
```",
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'user_id' => 1,
                    'title' => '読みたい本',
                    'content' => "- <a href=\"https://www.amazon.co.jp/dp/4492762396/?coliid=I2HE4HI7TZV7B9&colid=1Q6YNY42VUHES&psc=1&ref_=lv_ov_lig_dp_it\" target=\"_blank\">AI vs. 教科書が読めない子どもたち</a>
- <a href=\"https://www.amazon.co.jp/dp/B0851BGDQG/?coliid=I1D83DLWK7PEAY&colid=13J5LII2J9Y7&psc=0&ref_=lv_ov_lig_dp_it\" target=\"_blank\">実践Firestore</a>
- <a href=\"https://www.amazon.co.jp/dp/4798124702/?coliid=I25Z9BP0JUVEUX&colid=13J5LII2J9Y7&psc=1&ref_=lv_ov_lig_dp_it\" target=\"_blank\">徹底指南書</a>
- <a href=\"https://www.amazon.co.jp/%E4%BD%93%E7%B3%BB%E7%9A%84%E3%81%AB%E5%AD%A6%E3%81%B6-%E5%AE%89%E5%85%A8%E3%81%AAWeb%E3%82%A2%E3%83%97%E3%83%AA%E3%82%B1%E3%83%BC%E3%82%B7%E3%83%A7%E3%83%B3%E3%81%AE%E4%BD%9C%E3%82%8A%E6%96%B9-%E7%AC%AC2%E7%89%88-%E8%84%86%E5%BC%B1%E6%80%A7%E3%81%8C%E7%94%9F%E3%81%BE%E3%82%8C%E3%82%8B%E5%8E%9F%E7%90%86%E3%81%A8%E5%AF%BE%E7%AD%96%E3%81%AE%E5%AE%9F%E8%B7%B5-%E5%BE%B3%E4%B8%B8/dp/4797393165/ref=tmm_hrd_swatch_0?_encoding=UTF8&qid=1588561338&sr=1-1\" target=\"_blank\">安全なWebアプリケーションの作り方</a>
- <a href=\"https://www.amazon.co.jp/%E3%83%97%E3%83%AD%E3%82%B0%E3%83%A9%E3%83%9F%E3%83%B3%E3%82%B0TypeScript-%E2%80%95%E3%82%B9%E3%82%B1%E3%83%BC%E3%83%AB%E3%81%99%E3%82%8BJavaScript%E3%82%A2%E3%83%97%E3%83%AA%E3%82%B1%E3%83%BC%E3%82%B7%E3%83%A7%E3%83%B3%E9%96%8B%E7%99%BA-Boris-Cherny/dp/4873119049/ref=sr_1_16?__mk_ja_JP=%E3%82%AB%E3%82%BF%E3%82%AB%E3%83%8A&crid=3NCXZVLL9DBB2&dchild=1&keywords=typescript&qid=1588561450&s=books&sprefix=types%2Cstripbooks%2C263&sr=1-16\" target=\"_blank\">プログラミングTypeScript</a>
- <a href=\"https://www.amazon.co.jp/SQL%E3%82%A2%E3%83%B3%E3%83%81%E3%83%91%E3%82%BF%E3%83%BC%E3%83%B3-Bill-Karwin/dp/4873115892/ref=sr_1_3?__mk_ja_JP=%E3%82%AB%E3%82%BF%E3%82%AB%E3%83%8A&dchild=1&keywords=sql&qid=1588561523&s=books&sr=1-3\" target=\"_blank\">SQLアンチパターン</a>
",
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
            ]
        );

        DB::table('todos')->insert([
                [
                    'user_id' => 1,
                    'title' => '【システム開発会社 ◯◯】契約書に刻印して返送する',
                    'status' => true,
                    'limit_datetime' => '2020-2-10',
                    'sort' => 1,
                ],
                [
                    'user_id' => 1,
                    'title' => '【システム開発会社 ◯◯】2020年4月分請求書発行',
                    'status' => true,
                    'limit_datetime' => '2020-5-5',
                    'sort' => 2,
                ],
                [
                    'user_id' => 1,
                    'title' => '【デザイン会社 ◯◯】2020年5月分請求書発行',
                    'status' => false,
                    'limit_datetime' => '2020-6-5',
                    'sort' => 3,
                ],
                [
                    'user_id' => 1,
                    'title' => '税理士さんに確定申告関連書類送る',
                    'limit_datetime' => '2020-2-28',
                    'status' => true,
                    'sort' => 4,
                ],
                [
                    'user_id' => 1,
                    'title' => 'type-C ケーブル買いに行く',
                    'limit_datetime' => null,
                    'status' => false,
                    'sort' => 5,
                ],
            ]

        );

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
