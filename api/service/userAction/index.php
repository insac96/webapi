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
}