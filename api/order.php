<?php
require 'db.php';
$data = json_decode(file_get_contents('php://input'), true);
if ($data['uid'] == '') {
	$returnArr = array("ResponseCode" => "401", "Result" => "false", "ResponseMsg" => "Something Went Wrong!");
} else {

	$uid =  $data['uid'];
	$ddate = $data['ddate'];
	$a = explode('/', $ddate);
	$ddate = $a[2] . '-' . $a[1] . '-' . $a[0];
	$timesloat = $data['timesloat'];
	$oid = '#' . uniqid();
	$pname = $data['pname'];
	$status = 'pendiente';
	$p_method = $data['p_method'];
	$address_id = $data['address_id'];
	$tax = $data['tax'];
	$coupon_id = $data['coupon_id'];
	$cou_amt = $data['cou_amt'];
	$wal_amt = $data['wal_amt'];
	$timestamp = date("Y-m-d");
	$tid = $data['tid'];
	$total = number_format((float)$data['total'], 2, '.', '');
	$e = array();
	$p = array();
	$w = array();
	$pp = array();
	$q = array();
	for ($i = 0; $i < count($pname); $i++) {
		$e[] = mysqli_real_escape_string($con, $pname[$i]['title']);
		$p[] = $pname[$i]['pid'];
		$w[] = $pname[$i]['weight'];
		$pp[] = $pname[$i]['cost'];
		$q[] = $pname[$i]['qty'];
	}
	$pname = implode('$;', $e);
	$pid = implode('$;', $p);
	$ptype = implode('$;', $w);
	$pprice = implode('$;', $pp);
	$qty = implode('$;', $q);

	$getuinfo = $con->query("select * from user where id=" . $uid . "")->fetch_assoc();
	if ($wal_amt != 0) {
		if ($wal_amt > $getuinfo['wallet']) {
			$returnArr = array("ResponseCode" => "401", "Result" => "false", "ResponseMsg" => "You Not Have Enough Balance In Wallet!");
		} else {
			$con->query("insert into orders(`oid`,`uid`,`pname`,`pid`,`ptype`,`pprice`,`ddate`,`timesloat`,`order_date`,`status`,`qty`,`total`,`p_method`,`address_id`,`tax`,`tid`,`cou_amt`,`coupon_id`,`wal_amt`)values('" . $oid . "'," . $uid . ",'" . $pname . "','" . $pid . "','" . $ptype . "','" . $pprice . "','" . $ddate . "','" . $timesloat . "','" . $timestamp . "','" . $status . "','" . $qty . "'," . $total . ",'" . $p_method . "'," . $address_id . "," . $tax . ",'" . $tid . "'," . $cou_amt . "," . $coupon_id . "," . $wal_amt . ")");

			$con->query("update user set wallet=wallet-" . $wal_amt . " where id=" . $uid . "");
			$con->query("insert into wallet_report(`uid`,`message`,`status`,`amt`)values(" . $uid . ",'Wallet Balance Use For Order!!','Debit'," . $wal_amt . ")");
			$returnArr = array("ResponseCode" => "200", "Result" => "true", "ResponseMsg" => "Order Placed Successfully!!!");
		}
	} else {
		$timestamp = date("Y-m-d H:i:s");
 

		$con->query("insert into orders(`oid`,`uid`,`pname`,`pid`,`ptype`,`pprice`,`ddate`,`timesloat`,`order_date`,`status`,`qty`,`total`,`p_method`,`address_id`,`tax`,`tid`,`cou_amt`,`coupon_id`,`wal_amt`,`rid`,`a_status`)values('" . $oid . "'," . $uid . ",'" . $pname . "','" . $pid . "','" . $ptype . "','" . $pprice . "','" . $ddate . "','" . $timesloat . "','" . $timestamp . "','" . $status . "','" . $qty . "'," . $total . ",'" . $p_method . "'," . $address_id . "," . $tax . ",'" . $tid . "'," . $cou_amt . "," . $coupon_id . "," . $wal_amt . ",1,1)");
		$con->query("update user set wallet=wallet-" . $wal_amt . " where id=" . $uid . "");
		$con->query("insert into rnoti(`rid`,`msg`,`date`)values(1,'Nuevo pedido de agua','" . $timestamp . "')");
		$content = array(
			"en" => 'Tienes un nuevo pedido de agua' //mesaj burasi
		);
		$fields = array(
			'app_id' => "eded5695-98a3-4c7a-9d0a-31b0f321ec8d",
			'contents' => $content,
			'included_segments' =>  array('All'), // Enviar a todos los usuarios
			'priority' => 'high' // Configurar la prioridad como "high"

		  );
		  $fields = json_encode($fields);


		  $ch = curl_init();
		  curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
		  curl_setopt(
			$ch,
			CURLOPT_HTTPHEADER,
			array(
			  'Content-Type: application/json; charset=utf-8',
			  'Authorization: Basic ' . "YzE4MThmMDQtYjA5OC00MmM0LWEzOTktZWNkYWQzNjQxMmUy"
			)
		  );
		  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		  curl_setopt($ch, CURLOPT_HEADER, FALSE);
		  curl_setopt($ch, CURLOPT_POST, TRUE);
		  curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
		  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

		  $response = curl_exec($ch);
		  curl_close($ch);

		
		$returnArr = array("ResponseCode" => "200", "Result" => "true", "ResponseMsg" => "Order Placed Successfully!!!");

		
	}
}

echo json_encode($returnArr);
