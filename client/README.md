# my-manage-tool-front

> my-manage-toolのフロントです

## Build Setup

```bash
# install dependencies
$ npm install

# serve with hot reload
$ npm run dev

# build for production and launch server
$ npm run build
$ npm run start

# generate static project
$ npm run generate
```

For detailed explanation on how things work, check out [Nuxt.js docs](https://nuxtjs.org).

## 補足

- Nuxtのデフォルトは`localhost:3000`ですがpackage.jsonをいじってportを3333にしています
  - [参考URL](https://ja.nuxtjs.org/faq/host-port/)
  
- HTTPクライアントは[axios](https://axios.nuxtjs.org/usage)を使用

- 環境変数設定は[dotenv](https://github.com/nuxt-community/dotenv-module)を使用

- 認証関連は[auth](https://auth.nuxtjs.org/)を使用

- セレクトボックスには[multiselect](https://github.com/spektrummedia/nuxt-vue-multiselect)を使用
  - optionなどドキュメントは[ココ](https://vue-multiselect.js.org/)
