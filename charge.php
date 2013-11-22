<?php

require 'webpay-php-1.1.2-full/autoload.php';
use WebPay\WebPay;
require 'config.php';

// 支払金額。実際には商品番号などを送信し、それに対応する金額をデータベースから引きます
$amount = $_POST['amount'];
// トークン
$token = $_POST['webpay-token'];

$webpay = new WebPay(SECRET_KEY);

try {
    $result = $webpay->charges->create(array(
       "amount" => intval($amount, 10),
       "currency" => "jpy",
       "card" => $token,
       "description" => "PHP からのアイテムの購入"
    ));
} catch (\WebPay\Exception\CardException $e) {
    // カードが拒否された場合
    print("CardException\n");
    print('Status is:' . $e->getStatus() . "\n");
    print('Type is:' . $e->getType() . "\n");
    print('Code is:' . $e->getCardErrorCode() . "\n");
    print('Param is:' . $e->getParam() . "\n");
    print('Message is:' . $e->getMessage() . "\n");
    exit('Error');
} catch (\WebPay\Exception\InvalidRequestException $e) {
    // リクエストで指定したパラメータが不正な場合
    print("InvalidRequestException\n");
    print('Param is:' . $e->getParam() . "\n");
    print('Message is:' . $e->getMessage() . "\n");
    exit('Error');
} catch (\WebPay\Exception\AuthenticationException $e) {
    // 認証に失敗した場合
    print("AuthenticationException\n");
    print('Param is:' . $e->getParam() . "\n");
    print('Message is:' . $e->getMessage() . "\n");
    exit('Error');
} catch (\WebPay\Exception\APIConnectionException $e) {
    // APIへの接続エラーが起きた場合
    print("APIConnectionException\n");
    print('Param is:' . $e->getParam() . "\n");
    print('Message is:' . $e->getMessage() . "\n");
    exit('Error');
} catch (\WebPay\Exception\APIException $e) {
    // WebPayのサーバでエラーが起きた場合
    print("APIException\n");
    print('Message is:' . $e->getMessage() . "\n");
    exit('Error');
} catch (Exception $e) {
    // WebPayとは関係ない例外の場合
    print("Unexpected exception\n");
    print('Message is:' . $e->getMessage() . "\n");
    exit('Error');
}

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
