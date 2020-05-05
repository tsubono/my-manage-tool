# plugins

plugins ディレクトリには、ルートの Vue.js アプリケーションをインスタンス化する前に実行したい JavaScript プラグインを入れます。 ここはコンポーネントをグローバルに登録したり、関数や定数を挿入するための場所です。

[pluginsについて詳しく](https://ja.nuxtjs.org/guide/plugins/)

***

- axios.js
  - axiosのエラーハンドリングなど
  - [axiosのヘルパー](https://axios.nuxtjs.org/helpers.html)

- dashboard.js
  - paper-dashboardテンプレートのplugin
  
- globalComponents.js
  - components/UIComponents以下のコンポーネントを登録
  
- globalDirectives.js
  - dropdownなどの外側クリックディレクティブを登録
  - [ディレクティブとは](https://jp.vuejs.org/v2/guide/custom-directive.html)
  
- utility.js
  - 共通関数をinjectする
  - [injectとは](https://ja.nuxtjs.org/guide/plugins/#%E7%B5%B1%E5%90%88%E3%81%95%E3%82%8C%E3%81%9F%E6%B3%A8%E5%85%A5)
