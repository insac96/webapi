<?php
require 'utils.php';

class User extends UserUtils {
  /* Get All User */
  public function getAllUser () {
    return getTableList('ny_user', self::$PDO_GetAllUser);
  }

  /* Search User */
  public function searchUser () {
    $sqlCount = "SELECT 
      count(id) AS total 
      FROM ny_user 
      WHERE account LIKE :query
    ";

    $sqlSearch = "SELECT 
      user.*,
      auth.block, auth.phone, auth.type as type_user, auth.referraler
      FROM ny_user user
      LEFT JOIN ny_auth auth ON user.account = auth.account
      WHERE user.account LIKE :query
    ";

    return getTableSearch($sqlCount, $sqlSearch);
  }

  /* Get User IP */
  public function getLogUserIP () {
    if(empty($_POST['account'])) return res(400, 'Vui lòng chọn tài khoản trước');

    $account = $_POST['account'];
    $count = (new _PDO())->select("SELECT count(DISTINCT ip) AS total FROM ny_log_login WHERE account=:account", array(
      'account' => $account
    ));
    $count = $count['total'];

    return getTableList(null, "SELECT
      loglogin.ip, MAX(loglogin.create_time) AS create_time, 
      ANY_VALUE(logip.block) AS block, 
      ANY_VALUE(user.update_time) AS update_time
      FROM ny_log_login loglogin
      LEFT JOIN ny_log_ip logip ON logip.ip = loglogin.ip
      LEFT JOIN ny_user user ON user.account = loglogin.account
      WHERE loglogin.account='$account'
      GROUP BY loglogin.ip
    ", $count);
  }

  /* Get User Referral */
  public function getLogUserReferral () {
    if(empty($_POST['account'])) return res(400, 'Vui lòng chọn tài khoản trước');

    $account = $_POST['account'];
    $count = (new _PDO())->select("SELECT count(id) AS total FROM ny_log_referral WHERE account=:account", array(
      'account' => $account
    ));
    $count = $count['total'];

    return getTableList(null, "SELECT * FROM ny_log_referral WHERE account='$account'", $count);
  }

  /* Update User Auth */
  public function updateUserAuth () {
    if(
      empty($_POST['account'])
      || empty($_POST['phone'])
      || !is_numeric($_POST['type_user']) 
      || !is_numeric($_POST['block'])  
    ) return res(400, 'Dữ liệu đầu vào không đủ');
    
    // Check User
    $user = $this->getUser($_POST['account']);

    // Check Phone
    if(!empty($_POST['phone']) && $_POST['phone'] != $user['phone']){
      $check = (new Auth())->getAuthCheckByPhone($_POST['phone']);
      if(!empty($check)) return res(400, 'Số điện thoại đã tồn tại');
    }

    // Set Token
    if(!empty($_POST['password'])){
      $key = $user['account'].'-'.md5($_POST['password']).'-'.time();
      $token = md5($key);
    }
    else {
      $token = $user['token'];
    }
    
    // Update
    (new Auth())->updateAuth($user['account'], array(
      'password' => empty($_POST['password']) ? (string)$user['password'] : md5($_POST['password']),
      'phone' => empty($_POST['phone']) ? (string)$user['phone'] : (string)$_POST['phone'],
      'type' => (int)$_POST['type_user'],
      'block' => (int)$_POST['block'],
      'token' => (string)$token
    ));

    // Log
    logAdmin('Cập nhật thông tin tài khoản ['.$user['account'].']');
  }

  /* Update User Info */
  public function updateUserInfo () {
    if(
      empty($_POST['account']) 
      || empty($_POST['reason']) 
      || !is_numeric($_POST['coin'])
      || !is_numeric($_POST['coin_lock'])
      || !is_numeric($_POST['diamond'])
      || !is_numeric($_POST['wheel'])
    ) return res(400, 'Dữ liệu đầu vào không đủ');
    
    // Check User
    $user = $this->getUser($_POST['account']);

    // Update
    $this->updateUser($user['account'], array(
      'coin' => array('+', (int)$_POST['coin']),
      'coin_lock' => array('+', (int)$_POST['coin_lock']),
      'diamond' => array('+', (int)$_POST['diamond']),
      'wheel' => array('+', (int)$_POST['wheel']),
    ));

    // Log
    logAdmin('Cập nhật tiền tệ cho tài khoản ['.$user['account'].'] với lý do ['.$_POST['reason'].']');
  }

  /* Update User Mission */
  public function updateUserMission () {
    if(
      empty($_POST['account']) 
      || !is_numeric($_POST['join_group'])
      || !is_numeric($_POST['join_zalo'])
      || !is_numeric($_POST['join_telegram'])
      || !is_numeric($_POST['share_web'])
    ) return res(400, 'Dữ liệu đầu vào không đủ');

    // Check User
    $user = $this->getUser($_POST['account']);

    // Update
    $this->updateUser($user['account'], array(
      'join_group' => (int)$_POST['join_group'],
      'join_zalo' => (int)$_POST['join_zalo'],
      'join_telegram' => (int)$_POST['join_telegram'],
      'share_web' => (int)$_POST['share_web'],
    ));

    // Log
    logAdmin('Cập nhật trạng thái nhiệm vụ cho tài khoản ['.$user['account'].']');
  }
}