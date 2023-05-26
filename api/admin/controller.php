<?php
require 'utils.php';
require 'configAction/index.php';
require 'serverAction/index.php';
require 'ipAction/index.php';
require 'statisticalAction/index.php';
require 'vipAction/index.php';
require 'authAction/index.php';
require 'userAction/index.php';
require 'gateAction/index.php';
require 'payAction/index.php';
require 'withdrawAction/index.php';
require 'shopAction/index.php';
require 'newsAction/index.php';
require 'notifyAction/index.php';
require 'eventAction/index.php';
require 'missionAction/index.php';
require 'wheelAction/index.php';
require 'giftcodeAction/index.php';
require 'logAction/index.php';

class Controller {
/* Config */
  public function getConfig () {
    (new Auth())->getAuth(2);
    $config = (new Config())->getConfig();
    res(200, null, $config);
  }

  public function saveConfig () {
    (new Auth())->getAuth(2);
    (new Config())->saveConfig();
    res(200, 'Cập nhật thành công', null);
  }
/* End Config */

/* Server */
  public function getAllServer () {
    (new Auth())->getAuth(2);
    $list = (new Server())->getAllServer();
    res(200, null, $list);
  }

  public function syncServer () {
    (new Auth())->getAuth(2);
    (new Server())->syncServer();
    res(200, 'Đồng bộ thành công', null);
  }
  
  public function updateServer () {
    (new Auth())->getAuth(2);
    (new Server())->updateServer();
    res(200, 'Cập nhật thành công', null);
  }

  public function startServer () {
    (new Auth())->getAuth(2);
    (new Server())->startServer();
    res(200, 'Bật máy chủ thành công', null);
  }

  public function stopServer () {
    (new Auth())->getAuth(2);
    (new Server())->stopServer();
    res(200, 'Tắt máy chủ thành công', null);
  }

  public function getLogServerLogin () {
    (new Auth())->getAuth(2);
    $list = (new Server())->getLogServerLogin();
    res(200, null, $list);
  }

  public function getLogServerSpend () {
    (new Auth())->getAuth(2);
    $list = (new Server())->getLogServerSpend();
    res(200, null, $list);
  }

  public function getLogServerRank () {
    (new Auth())->getAuth(2);
    $list = (new Server())->getLogServerRank();
    res(200, null, $list);
  }
/* End Server */

/* IP Client */
  public function getAllIPClient () {
    (new Auth())->getAuth(2);
    $list = (new IPClient())->getAllIPClient();
    
    res(200, null, $list);
  }

  public function searchIPClient () {
    (new Auth())->getAuth(2);
    $list = (new IPClient())->searchIPClient();
    
    res(200, null, $list);
  }

  public function getAllAccountByIPClient () {
    (new Auth())->getAuth(2);
    $list = (new IPClient())->getAllAccountByIPClient();
    
    res(200, null, $list);
  }

  public function setBlockIP () {
    (new Auth())->getAuth(2);
    (new IPClient())->setBlockIP();
    res(200, 'Thao tác thành công');
  }
/* End IP Client */

/* User */
  public function getAllUser () {
    (new Auth())->getAuth(2);
    $list = (new User())->getAllUser();
    
    res(200, null, $list);
  }

  public function searchUser () {
    (new Auth())->getAuth(2);
    $list = (new User())->searchUser();
    
    res(200, null, $list);
  }

  public function getLogUserIP () {
    (new Auth())->getAuth(2);
    $list = (new User())->getLogUserIP();
    
    res(200, null, $list);
  }

  public function getLogUserReferral () {
    (new Auth())->getAuth(2);
    $list = (new User())->getLogUserReferral();
    
    res(200, null, $list);
  }
  
  public function updateUserAuth () {
    (new Auth())->getAuth(2);
    (new User())->updateUserAuth();
    
    res(200, 'Cập nhật tài khoản người dùng thành công');
  }

  public function updateUserInfo () {
    (new Auth())->getAuth(2);
    (new User())->updateUserInfo();
    
    res(200, 'Cập nhật tài khoản người dùng thành công');
  }

  public function updateUserMission () {
    (new Auth())->getAuth(2);
    (new User())->updateUserMission();
    
    res(200, 'Cập nhật tài khoản người dùng thành công');
  }
/* End User */

/* News */
  public function getAllNews () {
    (new Auth())->getAuth(2);
    $list = (new News())->getAllNews();

    res(200, null, $list);
  }

  public function updateNews () {
    (new Auth())->getAuth(2);
    (new News())->updateNews();
    
    res(200, 'Cập nhật tin tức thành công');
  }

  public function createNews () {
    (new Auth())->getAuth(2);
    (new News())->createNews();
    
    res(200, 'Tạo tin tức thành công');
  }

  public function deleteNews () {
    (new Auth())->getAuth(2);
    (new News())->deleteNews();
    
    res(200, 'Xóa tin tức thành công');
  }
/* End News */

/* Gate */
  public function getAllGate () {
    (new Auth())->getAuth(2);
    $list = (new Gate())->getAllGate();
    res(200, null, $list);
  }

  public function updateGate () {
    (new Auth())->getAuth(2);
    (new Gate())->updateGate();
    
    res(200, 'Cập nhật kênh thanh toán thành công');
  }
/* End Gate */

/* Shop Recharge */
  public function getAllShopRecharge () {
    (new Auth())->getAuth(2);
    $list = (new Shop())->getAllShopRecharge();
    
    res(200, null, $list);
  }

  public function searchShopRecharge () {
    (new Auth())->getAuth(2);
    $list = (new Shop())->searchShopRecharge();

    res(200, null, $list);
  }

  public function updateShopRecharge () {
    (new Auth())->getAuth(2);
    (new Shop())->updateShopRecharge();
    
    res(200, 'Cập nhật gói thành công');
  }

  public function createShopRecharge () {
    (new Auth())->getAuth(2);
    (new Shop())->createShopRecharge();
    
    res(200, 'Tạo gói thành công');
  }

  public function deleteShopRecharge () {
    (new Auth())->getAuth(2);
    (new Shop())->deleteShopRecharge();
    
    res(200, 'Xóa gói thành công');
  }
/* End Shop Recharge*/

/* Shop Item */
  public function getAllShopItem () {
    (new Auth())->getAuth(2);
    $list = (new Shop())->getAllShopItem();

    res(200, null, $list);
  }

  public function searchShopItem () {
    (new Auth())->getAuth(2);
    $list = (new Shop())->searchShopItem();

    res(200, null, $list);
  }

  public function updateShopItem () {
    (new Auth())->getAuth(2);
    (new Shop())->updateShopItem();
    
    res(200, 'Cập nhật vật phẩm thành công');
  }

  public function createShopItem () {
    (new Auth())->getAuth(2);
    (new Shop())->createShopItem();
    
    res(200, 'Tạo vật phẩm thành công');
  }

  public function deleteShopItem () {
    (new Auth())->getAuth(2);
    (new Shop())->deleteShopItem();
    
    res(200, 'Xóa vật phẩm thành công');
  }
/* End Shop Item*/

/* Shop Currency */
  public function getAllShopCurrency () {
    (new Auth())->getAuth(2);
    $list = (new Shop())->getAllShopCurrency();

    res(200, null, $list);
  }

  public function searchShopCurrency () {
    (new Auth())->getAuth(2);
    $list = (new Shop())->searchShopCurrency();

    res(200, null, $list);
  }

  public function updateShopCurrency () {
    (new Auth())->getAuth(2);
    (new Shop())->updateShopCurrency();
    
    res(200, 'Cập nhật vật phẩm thành công');
  }

  public function createShopCurrency () {
    (new Auth())->getAuth(2);
    (new Shop())->createShopCurrency();
    
    res(200, 'Tạo vật phẩm thành công');
  }

  public function deleteShopCurrency () {
  (new Auth())->getAuth(2);
  (new Shop())->deleteShopCurrency();
  
  res(200, 'Xóa vật phẩm thành công');
  }
/* End Shop Currency*/

/* Pay */
  public function getAllPay () {
    (new Auth())->getAuth(2);
    $list = (new Pay())->getAllPay();
    
    res(200, null, $list);
  }

  public function searchPay () {
    (new Auth())->getAuth(2);
    $list = (new Pay())->searchPay();
    
    res(200, null, $list);
  }

  public function verifyPay () {
    $user = (new Auth())->getAuth(2);
    (new Pay())->verifyPay($user['account']);
    
    res(200, 'Thao tác thành công');
  }
/* End Pay */


/* Statistical */
  public function getStatisticalRevenue () {
    $user = (new Auth())->getAuth(2);
    $revenue = (new Statistical())->getStatisticalRevenue();

    res(200, null, $revenue);
  }

  public function getStatisticalTableRevenue () {
    $user = (new Auth())->getAuth(2);
    $list = (new Statistical())->getStatisticalTableRevenue();
    
    res(200, null, $list);
  }

  public function getStatisticalSignUp () {
    $user = (new Auth())->getAuth(2);
    $list = (new Statistical())->getStatisticalSignUp();
    
    res(200, null, $list);
  }

  public function getStatisticalSignIn () {
    $user = (new Auth())->getAuth(2);
    $list = (new Statistical())->getStatisticalSignIn();
    
    res(200, null, $list);
  }
/* End Statistical */

/* Withdraw */
  public function getAllWithdraw () {
    (new Auth())->getAuth(2);
    $list = (new Withdraw())->getAllWithdraw();
    
    res(200, null, $list);
  }

  public function searchWithdraw () {
    (new Auth())->getAuth(2);
    $list = (new Withdraw())->searchWithdraw();
    
    res(200, null, $list);
  }

  public function verifyWithdraw () {
    $user = (new Auth())->getAuth(2);
    (new Withdraw())->verifyWithdraw($user['account']);
    
    res(200, 'Thao tác thành công');
  }
/* End Withdraw */

/* Event */
  public function getAllEvent () {
    (new Auth())->getAuth(2);
    $list = (new Event())->getAllEvent();

    res(200, null, $list);
  }

  public function createEvent () {
    (new Auth())->getAuth(2);
    (new Event())->createEvent();
    
    res(200, 'Tạo sự kiện thành công');
  }

  public function updateEvent () {
    (new Auth())->getAuth(2);
    (new Event())->updateEvent();
    
    res(200, 'Cập nhật sự kiện thành công');
  }

  public function deleteEvent () {
    (new Auth())->getAuth(2);
    (new Event())->deleteEvent();
    
    res(200, 'Xóa sự kiện thành công');
  }
/* End Event */

/* Event Milestone */
  public function getAllEventMilestone () {
    (new Auth())->getAuth(2);
    $list = (new Event())->getAllEventMilestone();

    res(200, null, $list);
  }

  public function updateEventMilestone () {
    (new Auth())->getAuth(2);
    (new Event())->updateEventMilestone();
    
    res(200, 'Cập nhật mốc thưởng thành công');
  }

  public function createEventMilestone () {
    (new Auth())->getAuth(2);
    (new Event())->createEventMilestone();
    
    res(200, 'Tạo mốc thưởng thành công');
  }

  public function deleteEventMilestone () {
    (new Auth())->getAuth(2);
    (new Event())->deleteEventMilestone();
    
    res(200, 'Xóa mốc thưởng thành công');
  }
/* End Event Milestone */

/* Mission */
  public function getAllMission () {
    (new Auth())->getAuth(2);
    $list = (new Mission())->getAllMission();

    res(200, null, $list);
  }

  public function createMission () {
    (new Auth())->getAuth(2);
    (new Mission())->createMission();
    
    res(200, 'Tạo nhiệm vụ thành công');
  }

  public function updateMission () {
    (new Auth())->getAuth(2);
    (new Mission())->updateMission();
    
    res(200, 'Sửa nhiệm vụ thành công');
  }

  public function deleteMission () {
    (new Auth())->getAuth(2);
    (new Mission())->deleteMission();
    
    res(200, 'Xóa nhiệm vụ thành công');
  }
/* End Mission */

/* Wheel */
  public function getAllWheelGift () {
    (new Auth())->getAuth(2);
    $list = (new Wheel())->getAllWheelGift();

    res(200, null, $list);
  }

  public function updateWheelGift () {
    (new Auth())->getAuth(2);
    (new Wheel())->updateWheelGift();
    
    res(200, 'Cập nhật phần thưởng thành công');
  }

  public function createWheelGift () {
    (new Auth())->getAuth(2);
    (new Wheel())->createWheelGift();
    
    res(200, 'Tạo phần thưởng thành công');
  }

  public function deleteWheelGift () {
    (new Auth())->getAuth(2);
    (new Wheel())->deleteWheelGift();
    
    res(200, 'Xóa phần thưởng thành công');
  }
/* End Wheel */

/* Giftcode */
  public function getAllGiftcode () {
    (new Auth())->getAuth(2);
    $list = (new Giftcode())->getAllGiftcode();

    res(200, null, $list);
  }

  public function createGiftcode () {
    (new Auth())->getAuth(2);
    (new Giftcode())->createGiftcode();
    
    res(200, 'Tạo Giftcode thành công');
  }

  public function updateGiftcode () {
    (new Auth())->getAuth(2);
    (new Giftcode())->updateGiftcode();
    
    res(200, 'Sửa Giftcode thành công');
  }

  public function deleteGiftcode () {
    (new Auth())->getAuth(2);
    (new Giftcode())->deleteGiftcode();
    
    res(200, 'Xóa Giftcode thành công');
  }
/* End Giftcode */

/* VIP */
  public function getAllVip () {
    (new Auth())->getAuth(2);
    $list = (new Vip())->getAllVip();
    res(200, null, $list);
  }

  public function updateVip () {
    (new Auth())->getAuth(2);
    (new Vip())->updateVip();
    
    res(200, 'Cập nhật cấp VIP thành công');
  }
/* End VIP */

/* Log */
  public function searchLog () {
    (new Auth())->getAuth(2);
    $list = (new Log())->searchLog();

    res(200, null, $list);
  }

  public function getAllLogAdmin () {
    (new Auth())->getAuth(2);
    $list = (new Log())->getAllLogAdmin();
    
    res(200, null, $list);
  }

  public function getAllLogShop () {
    (new Auth())->getAuth(2);
    $list = (new Log())->getAllLogShop();
    
    res(200, null, $list);
  }

  public function getAllLogEvent () {
    (new Auth())->getAuth(2);
    $list = (new Log())->getAllLogEvent();
    
    res(200, null, $list);
  }

  public function getAllLogMission () {
    (new Auth())->getAuth(2);
    $list = (new Log())->getAllLogMission();
    
    res(200, null, $list);
  }

  public function getAllLogWheel () {
    (new Auth())->getAuth(2);
    $list = (new Log())->getAllLogWheel();
    
    res(200, null, $list);
  }

  public function getAllLogGiftcode () {
    (new Auth())->getAuth(2);
    $list = (new Log())->getAllLogGiftcode();
    
    res(200, null, $list);
  }
/* End Log */
}
