<?php
require 'utils.php';

class IPClient extends IPClientUtils {
  /* Get All IP */
  public function getAllIPClient () {
    return getTableList('ny_log_ip', self::$PDO_GetAllIPClient);
  }

  /* Search IP */
  public function searchIPClient () {
    $sqlCount = "SELECT count(id) AS total FROM ny_log_ip WHERE ip LIKE :query";
    $sqlSearch = "SELECT * FROM ny_log_ip WHERE ip LIKE :query";
    return getTableSearch($sqlCount, $sqlSearch);
  }

  public function getAllAccountByIPClient () {
    if(empty($_POST['ip'])) return res(400, 'Dữ liệu đầu vào sai');

    $ip = $_POST['ip'];
    $count = (new _PDO())->select("SELECT count(id) AS total FROM ny_log_user_ip WHERE ip=:ip", array(
      'ip' => (string)$ip
    ));
    $count = $count['total'];
    
    return getTableList(null, "SELECT * FROM ny_log_user_ip WHERE ip='$ip'", $count);
  }

  /* Set Block IP*/
  public function setBlockIP () {
    if(!is_numeric($_POST['status']) || empty($_POST['ip'])) return res(400, 'Dữ liệu đầu vào sai');
    if($_POST['status'] != 0 && $_POST['status'] != 1) return res(400, 'Dữ liệu đầu vào sai');
    if($_POST['status'] == 0 && empty($_POST['reason_unblock'])) return res(400, 'Vui lòng nhập lý do');
    if($_POST['status'] == 1 && empty($_POST['reason_block'])) return res(400, 'Vui lòng nhập lý do');

    // Check IP
    $log = $this->getIPClient($_POST['ip']);

    // Update
    (new _PDO())->update('ny_log_ip', array(
      'block' => (int)$_POST['status']
    ), array(
      'ip' => (string)$log['ip']
    ));

    // Log Admin
    if($_POST['status'] == 0){
      logAdmin('Bỏ chặn IP ['.$log['ip'].'] với lý do ['.$_POST['reason_unblock'].']');
    }
    if($_POST['status'] == 1){
      logAdmin('Chặn IP ['.$log['ip'].'] với lý do ['.$_POST['reason_block'].']');
    }
  }
}