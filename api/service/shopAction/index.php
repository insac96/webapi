<?php
require 'utils.php';

class Shop extends ShopUtils {
  /* Get All Recharge */
  public function getShopRecharge () {
    $list = (new _PDO())->select(self::$PDO_GetShopRecharge, [], true);
    return $list;
  }

  /* Buy Recharge */
  public function buyRecharge ($user) {
    // Check Data
    if(empty($_POST['server_id']) || empty($_POST['recharge_id']))
      res(400, 'Dữ liệu đầu vào sai');

    // Get Recharge
    $recharge = $this->getRecharge($_POST['recharge_id']);

    // Check Max
    if($recharge['max'] != 0){
      $countBuy = $this->getCountBuyRecharge($user['account'], $recharge['id'], $_POST['server_id']);
      if((int)$countBuy >= (int)$recharge['max'])
        res(400, 'Bạn đã đạt đến giới hạn mua gói này');
    }

    // Check Coin
    $discount = floor((int)$recharge['price'] * (int)$user['vip']['discount_shop'] / 100);
    $need = (int)$recharge['price'] - (int)$discount;
    $this->checkCoin($user, $need);

    // Send Recharge To Game
    (new Game())->sendRecharge($user['account'], array(
      'server_id' => $_POST['server_id'],
      'recharge' => array(
        'id' => $recharge['id'],
        'save_pay_ingame' => $recharge['save_pay_ingame'],
      )
    ));

    // Update User Coin
    $this->updateUserCoin($user, $need);

    // Create Log
    (new _PDO())->create('ny_log_shop', array(
      'account' => (string)$user['account'],
      'server_id' => (string)$_POST['server_id'],
      'shop_id' => (int)$recharge['id'],
      'shop_type' => 'recharge',
      'price' => (int)$recharge['price'],
      'action' => 'Đã mua gói ['.$recharge['name'].'] với giá ['.$recharge['price'].' Xu] tại máy chủ ['.$_POST['server_id'].']',
      'create_time' => time()
    ));
  }

  /* Get All Item */
  public function getShopItem () {
    $list = (new _PDO())->select(self::$PDO_GetShopItem, [], true);
    return $list;
  }

  /* Buy Item */
  public function buyItem ($user) {
    // Check Data
    if(empty($_POST['server_id']) || empty($_POST['item_id']))
      res(400, 'Dữ liệu đầu vào sai');

    // Get Item
    $item = $this->getItem($_POST['item_id']);

    // Check Coin
    $discount = floor((int)$item['price'] * (int)$user['vip']['discount_shop'] / 100);
    $need = (int)$item['price'] - (int)$discount;
    $this->checkCoin($user, $need);

    // Set Items Send
    $items = [];
    $items[] = array(
      'id' => $item['id'],
      'name' => $item['name'],
      'amount' => $item['amount'],
    );

    // Send Items To Game
    (new Game())->sendItems($user['account'], array(
      'server_id' => $_POST['server_id'],
      'items' => $items
    ));

    // Update User Coin
    $this->updateUserCoin($user, $need);

    // Create Log
    (new _PDO())->create('ny_log_shop', array(
      'account' => (string)$user['account'],
      'server_id' => (string)$_POST['server_id'],
      'shop_id' => (int)$item['id'],
      'shop_type' => 'item',
      'price' => (int)$item['price'],
      'action' => 'Đã mua vật phẩm ['.$item['name'].'] số lượng [x'.$item['amount'].'] với giá ['.$item['price'].' Xu] tại máy chủ ['.$_POST['server_id'].']',
      'create_time' => time()
    ));
  }

  /* Get All Currency */
  public function getShopCurrency () {
    $list = (new _PDO())->select(self::$PDO_GetShopCurrency, [], true);
    return $list;
  }

  /* Buy Currency */
  public function buyCurrency ($user) {
    // Check Data
    if(empty($_POST['currency_id']))
      res(400, 'Dữ liệu đầu vào sai');

    // Get Currency
    $currency = $this->getCurrency($_POST['currency_id']);
    $currency_type = $currency['type'];

    // Check Need
    $buy_with = $currency['buy_with'];
    $need = (int)$currency['price'];
    $check = $user[$buy_with];

    if(!isset($check))
      res(400, 'Đơn vị tiền tệ yêu cầu không chính xác');
    if((int)$check < $need)
      res(400, 'Bạn không đủ tiền tệ tương ứng để mua');

    // Update User Currency
    $updateCurrency = array(
      $buy_with => array('-', (int)$currency['price']),
      $currency_type => array('+', (int)$currency['amount'])
    );
        
    // Update
    (new User())->updateUser($user['account'], $updateCurrency);
    
    // Create Log
    (new _PDO())->create('ny_log_shop', array(
      'account' => (string)$user['account'],
      'server_id' => 'WEB',
      'shop_id' => (int)$currency['id'],
      'shop_type' => 'currency',
      'price' => (int)$currency['price'],
      'action' => 'Đã mua ['.$currency['name'].'] với giá ['.$currency['price'].'] bằng ['.$currency['buy_with'].']',
      'create_time' => time()
    ));
  }
}