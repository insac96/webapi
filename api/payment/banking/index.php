<?php
class MomoPayment {
  public function callback (array $data = []) {
    $code = (string)$data['user'];
		$money = (int)$data['money'];

    (new Pay())->verifyPayAuto($money, $code, 1);
		res(200, 'SUCCESS');
  }
}