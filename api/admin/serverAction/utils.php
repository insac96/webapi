<?php
require 'pdo.php';

class ServerUtils extends ServerPDO {
  /* Get Server By ID */
  public function getServer ($server_id, $boolean = false) {
    if(empty($server_id)) return res(400, 'Không tìm thấy ID máy chủ');

    $server = (new _PDO())->select(self::$PDO_GetServer, array('server_id' => $server_id));

    if($boolean){
      if(empty($server)) return false;
      return true;
    }
    else {
      if(empty($server)) return res(400, 'Máy chủ không tồn tại');
      return $server;
    }
  }
}