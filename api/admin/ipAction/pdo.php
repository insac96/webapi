<?php
class IPClientPDO {
  static $PDO_GetAllIPClient = "SELECT * FROM ny_log_ip";
  static $PDO_GetIPClient = "SELECT * FROM ny_log_ip WHERE ip=:ip";
}