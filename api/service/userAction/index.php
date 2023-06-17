<?php
require 'utils.php';

class User extends UserUtils {
  /* Get Gift Referraler */
  public function getGiftReferraler ($user) {
    // Check Data
    if(empty($_POST['server_id']))
      res(400, 'Dữ liệu đầu vào sai');

    // Check User
    if($user['get_gifts_referral'] == 1)
      res(400, 'Bạn đã nhận phần thưởng này rồi');
    
    // Check referraler
    if(empty($user['referraler']))
      res(400, 'Bạn không có người giới thiệu');

    $referraler = $user['referraler'];
    $gifts = $referraler['gifts'];
    $items = (array)json_decode($gifts);

    if(count($items) == 0)
      res(400, 'Phần thưởng chưa cập nhật, vui lòng quay lại nhận sau');

    // Send Items
    (new Game())->sendItems($user['account'], array(
      'server_id' => $_POST['server_id'],
      'items' => $items
    ));

    // Update User
    $this->updateUser($user['account'], array(
      'get_gifts_referral' => 1
    ));
  }

  /* Update User Mission */
  public function updateUserMission ($user) {
    if(empty($_POST['type'])) return res(400, 'Dữ liệu đầu vào sai');
    
    $typeAccept = array('zalo', 'group', 'telegram');
    $type = trim(strtolower($_POST['type']));
    $type_check = 'join_'.$type;

    // Check Type
    if(!in_array($type, $typeAccept)) return res(400, 'Kiểu nhiệm vụ không hỗ trợ');

    // Check User
    if($user[$type_check] > 0) return res(400, 'Bạn đã hoàn thành nhiệm vụ này rồi');

    // Update User
    $this->updateUser($user['account'], array(
      $type_check => 1
    ));
  }

  /* Get All User Effect */
  public function getAllUserEffect ($user) {
    $sql = "SELECT effect.id, effect.name, effect.type 
      FROM ny_log_shop log
      LEFT JOIN ny_shop_effect effect ON effect.id = log.shop_id
      WHERE log.account=:account
      AND log.shop_type=:shop_type
    ";

    $list = (new _PDO())->select($sql, array(
      'account' => $user['account'],
      'shop_type' => 'effect'
    ), true);

    return $list;
  }

  /* Update User Effect */
  public function updateUserEffect ($user) {
    if(empty($_POST['effect_type'])) return res(400, 'Dữ liệu đầu vào sai');

    if($_POST['effect_type'] != 'vip'){
      // Check Effect
      $effect = (new Shop())->getEffectByType($_POST['effect_type']);

      // Check Buy
      $countBuy = (new Shop())->getCountBuyEffect($user['account'], $effect['id']);
      if($countBuy < 1) return res(400, 'Bạn chưa mua hiệu ứng này');

      // Update
      $this->updateUser($user['account'], array(
        'effect' => $effect['type']
      ));
    }
    else {
      $this->updateUser($user['account'], array(
        'effect' => 'vip'
      ));
    }
  }
}