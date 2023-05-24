<?php
require 'pdo.php';

class UserUtils extends UserPDO {
  /* Get Time Update*/
  function getTimeUpdate ($time = null) {
    $time = isset($time) ? $time : time();

    $timeUpdate = array(
      'date' => date('d', $time),
      'month' => date('m', $time),
      'year' => date('Y', $time),
      'update_time' => $time
    );

    return $timeUpdate;
  }

  /* Create New User No Referraler */
  public function createUserNoReferraler ($account) {
    // Get Config
    $config = (new Config())->getConfig();

    // Create
    (new _PDO())->create('ny_user', array_merge(
      array(
        'account' => (string)$account,
        'login_day' => 1,
        'create_time' => (int)time()
      ),
      $this->getTimeUpdate()
    ));
  }

  /* Create New User With Referraler */
  public function createUserWithReferraler ($account, $referraler) {
    // Get Config
    $config = (new Config())->getConfigAll();

    // Get VIP Referraler
    $referraler = $this->getUser($referraler);
    $vip = $referraler['vip'];
    $referral_bonus_coin = (int)$vip['referral_bonus_coin'];

    // Create User
    (new _PDO())->create('ny_user', array_merge(
      array(
        'account' => (string)$account,
        'login_day' => 1,
        'coin_lock' => (int)$referral_bonus_coin,
        'create_time' => (int)time()
      ),
      $this->getTimeUpdate()
    ));

    // Update For Referraler
    $this->updateUser($referraler['account'], array(
      'coin_lock' => array('+', (int)$referral_bonus_coin),
      'referral_count' => array('+', 1)
    ));

    // Make Notify
    $notify_invitee = 'Bạn đăng ký tài khoản bằng mã mời của ['.$referraler['account'].'] và nhận được ['.$referral_bonus_coin.' Xu Khóa] từ đặc quyền [VIP '.$vip['number'].'] của người ấy';
    $notify_referraler = '['.$account.'] đã đăng ký tài khoản bằng mã mời của bạn. Bạn nhận được ['.$referral_bonus_coin.' Xu Khóa] từ đặc quyền thưởng giới thiệu [VIP '.$vip['number'].']';
    (new Notify())->create($account, $notify_invitee, 'referral');
    (new Notify())->create($referraler['account'], $notify_referraler, 'invitee'); 

    // Save Log For Referraler
    $action = '['.$account.'] đã đăng ký tài khoản bằng mã mời từ ['.$referraler['account'].'], cả 2 nhận được ['.$referral_bonus_coin.' Xu Khóa] từ đặc quyền [VIP '.$vip['number'].'] của ['.$referraler['account'].']';
    (new _PDO())->create('ny_log_referral', array(
      'account' => (string)$referraler['account'],
      'invitee' => (string)$account,
      'action' => (string)$action,
      'create_time' => time()
    ));
  }

  /* Get User */
  public function getUser ($account) {
    $user = (new _PDO())->select(self::$PDO_GetUser, array('account'=>(string)$account));
    
    if(empty($user)) return res(400, 'Tài khoản không tồn tại');
    $this->autoUpdate($user);
    return $this->convertUser($user);
  }

  /* Convert User */
  public function convertUser ($user) {
    // Set VIP
    $vip_level = (int)$user['vip'];
    $user['vip'] = (new Vip())->getVip($vip_level);
    unset($user['vip']['id']);
    unset($user['vip']['need_exp']);

    if($vip_level < 10){
      $next_vip = $vip_level + 1;
      $user['next_vip'] = (new Vip())->getVip($next_vip);
      unset($user['next_vip']['id']);
    }
    else {
      $user['next_vip'] = 'max';
    }

    // Set Phone
    if(!empty($user['phone']))
      $user['phone'] = substr($user['phone'], 0, 6).'****';

    // Set Notify
    $user['notify'] = (new Notify())->getCountNewNotify($user['account']);

    // Set Private
    unset($user['password']);
    unset($user['token']);

    // Get Referraler
    if(!empty($user['referraler']))
      $user['referraler'] = (new _PDO())->select(self::$PDO_GetReferraler, array('referraler'=>(string)$user['referraler']));

    return $user;
  }

  /* Update User */
  public function updateUser ($account, $update, $time = null) {
    $time = isset($time) ? $time : $this->getTimeUpdate();
    $update = array_merge($update, $time);
    $where = array('account'=>$account);

    (new _PDO())->update('ny_user', $update, $where);
  }

  /* Auto Update */
  public function autoUpdate ($user) {
    $update = array();
    $time = $this->getTimeUpdate();
    $isNextDate = ($user['date'] != $time['date']) ? true : false;
    $isNextMonth = ($user['month'] != $time['month']) ? true : false;

    // Check Is Next Day
    if($isNextDate){
      $update['login_day'] = (int)$user['login_day'] + 1;
      $update['pay_day'] = 0;
      $update['spend_day'] = 0;
    }

    // Check Is Next Month
    if($isNextMonth){
      $update['pay_month'] = 0;
      $update['spend_month'] = 0;
    }

    // Check VIP
    $new_vip = (new Vip())->getVipNew($user['vip_exp']);
    if(empty($new_vip) || $new_vip['number'] == 10){
      $update['vip'] = 10;
    }
    if((int)$new_vip['number'] < 1){
      $update['vip'] = 0;
    }
    else {
      $update['vip'] = ((int)$new_vip['need_exp'] <= (int)$user['vip_exp']) ? (int)$new_vip['number'] : ((int)$new_vip['number'] - 1);
    }

    if(count($update) != 0)
      $this->updateUser($user['account'], $update, $time);  
  }
}