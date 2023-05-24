<?php
require 'utils.php';

class Notify extends NotifyUtils {
  public function getAllNotify ($user) {
    $account = $user['account'];
    $count = (new _PDO())->select("SELECT count(id) AS total FROM ny_notify WHERE account=:account", array(
      'account' => $account
    ));
    $count = $count['total'];
    return getTableList(null, "SELECT * 
      FROM ny_notify 
      WHERE account='$account'
    ", $count);
  }
}