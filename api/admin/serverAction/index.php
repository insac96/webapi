<?php
require 'utils.php';
require_once API_DIR.'/game/index.php';

class Server extends ServerUtils {
  /* Get All Server */
  public function getAllServer () {
    return getTableList('ny_server', self::$PDO_GetAllServer);
  }

  /* Sync Server */
  public function syncServer () {
    $list = (new Game())->getAllServerAdmin();

    foreach ($list as $server) {
      $had = $this->getServer($server['server_id'], true);
      if(!$had){
        (new _PDO())->create('ny_server', array(
          'server_id' => (string)$server['server_id'],
          'server_name' => (string)$server['server_name'],
          'db_name' => (string)$server['db_name'],
          'update_time' => time()
        ));
      }
      else {
        (new _PDO())->update('ny_server', array(
          'server_name' => (string)$server['server_name'],
          'db_name' => (string)$server['db_name'],
          'update_time' => time()
        ), array(
          'server_id' => (string)$server['server_id']
        ));
      }
    }
  }

  /* Update Server */
  public function updateServer () {
    if(
      empty($_POST['server_id']) 
      || empty($_POST['db_name']) 
      || empty($_POST['path']) 
      || empty($_POST['file_start'])
      || empty($_POST['file_stop']) 
    )
      res(400, 'Dữ liệu đầu vào không đủ');

    // Check Server
    $server = $this->getServer($_POST['server_id']);

    // Update
    (new _PDO())->update('ny_server', 
      array(
        'db_name' => (string)$_POST['db_name'],
        'path' => (string)$_POST['path'],
        'file_start' => (string)$_POST['file_start'],
        'file_stop' => (string)$_POST['file_stop'],
        'update_time' => time()
      ), 
      array('id'=>$server['id'])
    );

    logAdmin('Cập nhật thông tin máy chủ ['.$server['server_id'].']');
  }

  /* Start Server */
  public function startServer () {
    if(empty($_POST['server_id'])) return res(400, 'Dữ liệu đầu vào không đủ');

    // Check Server
    $server = $this->getServer($_POST['server_id']);
    if(empty($server['path'])) return res(400, 'Vui lòng cập nhật đường dẫn thư mục');
    if(empty($server['file_start'])) return res(400, 'Vui lòng cập nhật tệp chạy máy chủ');

    // Run
    $cmd = "cd ".$server['path'].' && '.$server['file_start'];
    $output = null;
    $retval = null;
    exec($cmd, $output, $retval);
    if(!empty($retval)) return res(400, 'Bật máy chủ thất bại');

    // Update
    (new _PDO())->update('ny_server', 
      array(
        'running' => 1,
        'update_time' => time()
      ), 
      array('id'=>$server['id'])
    );
  }

  /* Stop Server */
  public function stopServer () {
    if(empty($_POST['server_id'])) return res(400, 'Dữ liệu đầu vào không đủ');

    // Check Server
    $server = $this->getServer($_POST['server_id']);
    if(empty($server['path'])) return res(400, 'Vui lòng cập nhật đường dẫn thư mục');
    if(empty($server['file_stop'])) return res(400, 'Vui lòng cập nhật tệp dừng máy chủ');

    // Run
    $cmd = "cd ".$server['path'].' && '.$server['file_stop'];
    $output = null;
    $retval = null;
    exec($cmd, $output, $retval);
    if(!empty($retval)) return res(400, 'Tắt máy chủ thất bại');

    // Update
    (new _PDO())->update('ny_server', 
      array(
        'running' => 0,
        'update_time' => time()
      ), 
      array('id'=>$server['id'])
    );
  }

  /* Get Log Server Login */
  public function getLogServerLogin () {
    if(empty($_POST['server_id'])) return res(400, 'Dữ liệu đầu vào sai');
    $server_id = $_POST['server_id'];

    $now = convertTime();
    $start = empty($_POST['start']) ? '2000-01-01' : $_POST['start'];
    $end = empty($_POST['end']) ? $now['sql'] : $_POST['end'];

    $sqlCount = "SELECT
      DATE_FORMAT(FROM_UNIXTIME(create_time), '%Y-%m-%d') AS table_time
      FROM ny_log_login_server
      WHERE DATE_FORMAT(FROM_UNIXTIME(create_time), '%Y-%m-%d') >= '$start'
      AND DATE_FORMAT(FROM_UNIXTIME(create_time), '%Y-%m-%d') <= '$end'
      AND server_id = '$server_id'
      GROUP BY table_time
    ";
    $countQuery = (new _PDO())->select($sqlCount, [], true);
    $count = count($countQuery);

    $sql = "SELECT
      COUNT(account) as sign_in,
      DATE_FORMAT(FROM_UNIXTIME(create_time), '%Y-%m-%d') AS table_time
      FROM ny_log_login_server
      WHERE DATE_FORMAT(FROM_UNIXTIME(create_time), '%Y-%m-%d') >= '$start'
      AND DATE_FORMAT(FROM_UNIXTIME(create_time), '%Y-%m-%d') <= '$end'
      AND server_id = '$server_id'
      GROUP BY table_time
    ";

    return getTableList(null, $sql, $count);
  }

  /* Get Log Server Spend */
  public function getLogServerSpend () {
    if(empty($_POST['server_id'])) return res(400, 'Dữ liệu đầu vào sai');
    $server_id = $_POST['server_id'];

    $now = convertTime();
    $start = empty($_POST['start']) ? '2000-01-01' : $_POST['start'];
    $end = empty($_POST['end']) ? $now['sql'] : $_POST['end'];

    $sqlCount = "SELECT
      DATE_FORMAT(FROM_UNIXTIME(create_time), '%Y-%m-%d') AS table_time
      FROM ny_log_shop 
      WHERE shop_type != 'currency'
      AND server_id = '$server_id'
      AND DATE_FORMAT(FROM_UNIXTIME(create_time), '%Y-%m-%d') >= '$start'
      AND DATE_FORMAT(FROM_UNIXTIME(create_time), '%Y-%m-%d') <= '$end'
      GROUP BY table_time
    ";
    $countQuery = (new _PDO())->select($sqlCount, [], true);
    $count = count($countQuery);

    $sql = "SELECT
      COUNT(DISTINCT account) AS user_spend,
      COUNT(CASE WHEN 1 = 1 THEN 1 ELSE NULL END) AS spend_count,
      COUNT(CASE WHEN shop_type = 'recharge' THEN 1 ELSE NULL END) AS spend_count_recharge,
      COUNT(CASE WHEN shop_type = 'item' THEN 1 ELSE NULL END) AS spend_count_item,
      SUM(CASE WHEN 1 = 1 THEN price ELSE 0 END) AS spend_all,
      SUM(CASE WHEN shop_type = 'recharge' THEN price ELSE 0 END) AS spend_recharge,
      SUM(CASE WHEN shop_type = 'item' THEN price ELSE 0 END) AS spend_item,
      DATE_FORMAT(FROM_UNIXTIME(create_time), '%Y-%m-%d') AS table_time
      FROM ny_log_shop
      WHERE shop_type != 'currency'
      AND server_id = '$server_id'
      AND DATE_FORMAT(FROM_UNIXTIME(create_time), '%Y-%m-%d') >= '$start'
      AND DATE_FORMAT(FROM_UNIXTIME(create_time), '%Y-%m-%d') <= '$end'
      GROUP BY table_time
    ";

    return getTableList(null, $sql, $count);
  }

  /* Get Log Server Rank */
  public function getLogServerRank () {
    if(empty($_POST['server_id'])) return res(400, 'Dữ liệu đầu vào sai');
    $server_id = $_POST['server_id'];

    $now = convertTime();
    $start = empty($_POST['start']) ? $now['sql'] : $_POST['start'];
    $end = empty($_POST['end']) ? $now['sql'] : $_POST['end'];

    $sqlCount = "SELECT
      account
      FROM ny_log_shop 
      WHERE shop_type != 'currency'
      AND server_id = '$server_id'
      AND DATE_FORMAT(FROM_UNIXTIME(create_time), '%Y-%m-%d') >= '$start'
      AND DATE_FORMAT(FROM_UNIXTIME(create_time), '%Y-%m-%d') <= '$end'
      GROUP BY account
    ";
    $countQuery = (new _PDO())->select($sqlCount, [], true);
    $count = count($countQuery);

    $sql = "SELECT
      SUM(CASE WHEN 1 = 1 THEN price ELSE 0 END) AS spend_all,
      SUM(CASE WHEN shop_type = 'recharge' THEN price ELSE 0 END) AS spend_recharge,
      SUM(CASE WHEN shop_type = 'item' THEN price ELSE 0 END) AS spend_item,
      account
      FROM ny_log_shop
      WHERE shop_type != 'currency'
      AND server_id = '$server_id'
      AND DATE_FORMAT(FROM_UNIXTIME(create_time), '%Y-%m-%d') >= '$start'
      AND DATE_FORMAT(FROM_UNIXTIME(create_time), '%Y-%m-%d') <= '$end'
      GROUP BY account
    ";

    return getTableList(null, $sql, $count);
  }
}