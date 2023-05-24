<?php
require 'utils.php';

class Vip extends VipUtils {
  /* Get All Vip */
  public function getAllVip () {
    return getTableList('ny_vip', self::$PDO_GetAllVip);
  }

  public function updateVip () {
    if(
      !is_numeric($_POST['need_exp']) 
      || !is_numeric($_POST['discount_shop']) 
      || !is_numeric($_POST['pay_bonus_coin']) 
      || !is_numeric($_POST['referral_pay_bonus_coin']) 
      || !is_numeric($_POST['referral_bonus_coin']) 
      || !is_numeric($_POST['pay_to_wheel'])
      || !is_numeric($_POST['diamond_to_money'])
    ) return res(400, 'Dữ liệu đầu vào không đủ');

    // Get VIP
    $vip = $this->getVip($_POST['number']);

    // Check Gift
    $gifts = (array)json_decode((string)$_POST['gifts']);
    if(!is_array($gifts))
      res(400, 'Phần thưởng đưa vào không hợp lệ');

    // Update
    (new _PDO())->update('ny_vip',
      array(
        'need_exp' => (int)$_POST['need_exp'],
        'discount_shop' => (int)$_POST['discount_shop'],
        'pay_bonus_coin' => (int)$_POST['pay_bonus_coin'],
        'referral_pay_bonus_coin' => (int)$_POST['referral_pay_bonus_coin'],
        'referral_bonus_coin' => (int)$_POST['referral_bonus_coin'],
        'pay_to_wheel' => (int)$_POST['pay_to_wheel'],
        'diamond_to_money' => (int)$_POST['diamond_to_money'],
        'gifts' => (string)$_POST['gifts']
      ),
      array(
        'number' => $vip['number']
      )
    );

    // Log
    logAdmin('Cập nhật cấp VIP ['.$vip['number'].']');
  }
}