# 注意

ここで紹介しているやりかたは、 [Composer](http://getcomposer.org) を利用できない場合のための方法です。
利便性、メンテナンス性の観点から、 Composer を利用することが強く推奨されます。

Composer を利用する場合、 [webpay/webpay - Packagist](https://packagist.org/packages/webpay/webpay) を参照して最新のリリースを `composer.json` の `require` に追加してください。

# セットアップ方法

TODO: http://example.com から最新のパッケージ済みの webpay-php ライブラリをダウンロードし、解凍します。
このドキュメント作成時の最新バージョンは webpay-php-1.1.2-full です。

あなたのプロジェクトでライブラリを配置している場所に、解凍してできたディレクトリを設置します。
今回はルートディレクトリの直下にしました。

PHP ファイルに、次のように記載することで WebPay ライブラリが使えるようになります。
メソッドなど、くわしい使い方については [PHP APIドキュメント | WebPay: 開発者向けクレジットカード決済サービス](https://webpay.jp/docs/api/php) をご覧ください。

```php
require 'webpay-php-1.1.2-full/autoload.php';
use WebPay\WebPay;
```

# このサンプルコードの解説

このサンプルコードでは、安全なカード取引を提供するための最低限の方法を示しています。

まず最初に、あなたの WebPay アカウントに割り当てられたAPIキーを設定してください。
[ユーザ設定 | WebPay: 開発者向けクレジットカード決済サービス](https://webpay.jp/settings) からAPIキーを取得し、 `config.sample.php` に設定して、 `config.php` という名前で保存します。

ユーザは `index.php` を訪問し、支払金額を入力します。通常、この金額はユーザが選択した商品の値段から自動的に算出されます。

「カード情報を入力して支払う」を押すと、 WebPay が提供する Checkout という仕組みで、カード情報入力画面が出てきます。
ユーザが通常のフォームにカード番号などを入力し、あなたのサーバに送信する場合、クレジットカード情報を適切に扱う義務が発生します。
Checkout を利用するとカード番号は直接 WebPay に送信され、あなたのサーバを通過しないので、ユーザが安心して利用できます。
詳細は [トークン決済 | WebPay: 開発者向けクレジットカード決済サービス](https://webpay.jp/docs/payments_with_token) を確認してください。

カード情報を入力しおわると、自動的に `charge.php` に Checkout が生成したトークンと金額が送信されます。
`charge.php` では WebPay にライブラリを利用してアクセスし、課金をおこないます。
生成に成功すると支払い情報が、失敗するとエラーメッセージが表示されます。
