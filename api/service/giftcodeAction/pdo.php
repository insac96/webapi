<?php
class GiftcodePDO {
  static $PDO_GetGiftCode = "SELECT * FROM ny_giftcode WHERE display='1' and name=:name";
  static $PDO_GetReceived = "SELECT * FROM ny_log_giftcode WHERE giftcode_id=:giftcode_id and account=:account";
}