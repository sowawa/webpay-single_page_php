<?php

require 'webpay-php-1.1.1-full/autoload.php';
use WebPay\WebPay;
require 'config.php';

// 支払金額。実際には商品番号などを送信し、それに対応する金額をデータベースから引きます
$amount = $_POST['amount'];
// トークン
$token = $_POST['webpay-token'];

$webpay = new WebPay(SECRET_KEY);
$result = $webpay->charges->create(array(
   "amount" => intval($amount, 10),
   "currency" => "jpy",
   "card" => $token,
   "description" => "PHP からのアイテムの購入"
));

// 処理終了後、 https://webpay.jp/test/charges で課金が発生したことが分かります。
?>
<html>
  <head>
    <meta charset="utf-8">
    <title>WebPay PHP sample</title>
  </head>
  <body>
    <h1>お支払いありがとうございました</h1>
    <ul>
      <li>お支払い金額: <?php print($result->amount); ?></li>
      <li>カード名義: <?php print($result->card->name); ?></li>
      <li>カード番号: ****-****-****-<?php print($result->card->last4); ?></li>
    </ul>
  </body>
</html>
