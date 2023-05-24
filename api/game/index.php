<?php
require 'utils.php';
require 'socket/index.php';

class Game extends GameUtils {
  /* Get All Server */
  public function getAllServer () {
    /* Dev */
    if(DEV){
      $list = [];
      $list[] = array('server_id' => 'sf1', 'server_name' => 'Máy chủ thử nghiệm');
      return $list;
    }

    /* Prod */
    $sql = "SELECT server_id, name AS server_name FROM ny_server";
    $list = (new _PDO('backstage'))->select($sql, [], true);
    return $list;
  }

  /* Get Role  */
  public function getRole ($user) {
    if(DEV){
      $role = array('role_id' => '1234567', 'role_name' => 'S1.Admin');
      return $role;
    }

    /* Prod */
    $role = $this->getRoleByServer($user['account'], $_POST['server_id']);
    return $role;
  }
}
